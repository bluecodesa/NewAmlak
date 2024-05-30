<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\ProjectRepositoryInterface;
use App\Models\TicketResponse;
use App\Models\User;
use App\Notifications\Admin\ResponseTicketNotification;
use App\Interfaces\Broker\TicketRepositoryInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectService
{
    protected $ProjectRepository;


    public function __construct(ProjectRepositoryInterface $ProjectRepository)
    {
        $this->ProjectRepository = $ProjectRepository;

    }

    public function getAllProjectStatus()
    {
        return $this->ProjectRepository->getAllProjectStatus();
    }

    function getProjectStatuById($id)
    {
        return $this->ProjectRepository->getProjectStatuById($id);
    }

    public function createProjectStatu($data)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('project_status_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ProjectRepository->createProjectStatu($data);
    }

    public function updateProjectStatu($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('project_status_translations', 'name')->ignore($id, 'project_status_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ProjectRepository->updateProjectStatu($id, $data);
    }

    public function deleteProjectStatus($id)
    {
        return $this->ProjectRepository->deleteProjectStatus($id);
    }



    public function getAllDeliveryCases()
    {
        return $this->ProjectRepository->getAllDeliveryCases();
    }

    function getDeliveryCaseById($id)
    {
        return $this->ProjectRepository->getDeliveryCaseById($id);
    }

    public function createDeliveryCase($data)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('delivery_case_translations', 'name')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ProjectRepository->createDeliveryCase($data);
    }

    public function updateDeliveryCase($id, $data)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('delivery_case_translations', 'name')->ignore($id, 'delivery_case_id')]];
        }
        $messages = [];
        foreach (config('translatable.locales') as $locale) {
            $messages[$locale . '.name.required'] = __('The :attribute field is required.', ['attribute' => __('name')]);
            $messages[$locale . '.name.unique'] = __('The :attribute has already been taken.', ['attribute' => __('name')]);
        }

        validator($data, $rules, $messages)->validate();
        return $this->ProjectRepository->updateDeliveryCase($id, $data);
    }

    public function deleteDeliveryCase($id)
    {
        return $this->ProjectRepository->deleteDeliveryCase($id);
    }





}
