<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SupportRepositoryInterface;
use App\Models\TicketResponse;
use App\Models\User;
use App\Notifications\Admin\ResponseTicketNotification;
use App\Interfaces\Broker\TicketRepositoryInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupportService
{
    protected $SupportRepository;
    protected $ticketRepository;


    public function __construct(SupportRepositoryInterface $SupportRepository,TicketRepositoryInterface $ticketRepository)
    {
        $this->SupportRepository = $SupportRepository;
        $this->ticketRepository = $ticketRepository;



    }

    public function getAllTicketTypes()
    {
        return $this->SupportRepository->getAllTicketTypes();
    }

    function getTicketTypById($id)
    {
        return $this->SupportRepository->getTicketTypById($id);
    }

    public function createTicketType($data)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->SupportRepository->createTicketType($data);
    }

    public function updateTicketType($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('ticket_type_translations', 'name')->ignore($id, 'ticket_type_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }
        
        validator($data, $rules, $messages)->validate();        
        return $this->SupportRepository->updateTicketType($id, $data);
    }

    public function delete($id)
    {
        return $this->SupportRepository->delete($id);
    }



    public function addResponse(array $data, int $ticketId)
    {
        $ticket = $this->ticketRepository->findTicketById($ticketId);

        if ($ticket->status !== 'Waiting for customer') {
            $ticket->status = 'Waiting for the customer';
            $ticket->save();
        }

        $response = new TicketResponse();
        $response->ticket_id = $ticketId;
        $response->user_id = Auth::id();
        $response->response = $data['response'];

        if (isset($data['response_attachment'])) {
            $file = $data['response_attachment'];
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Tickets/responses'), $fileName);
            $response->response_attachment = 'Tickets/responses/' . $fileName;
        }

        $this->SupportRepository->createTicketResponse($response);
        $this->notifyBroker($response);

        return $response;
    }

    protected function notifyBroker(TicketResponse $response)
    {
        $brokers = User::where('is_broker', true)->get();
        foreach ($brokers as $broker) {
            Notification::send($broker, new ResponseTicketNotification($response));
        }
    }


    public function closeTicket(int $ticketId)
    {
        return $this->ticketRepository->closeTicket($ticketId);
    }



}
