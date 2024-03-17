<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SectionService;
use App\Services\Admin\SupportService;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    protected $SupportService;

    public function __construct(SupportService $SupportService)
    {
        $this->SupportService = $SupportService;
    }

    public function index()
    {
        $tickets = $this->SupportService->getAll();
        return view('Admin.supports.Ticket.index', get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.supports.Ticket.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->SupportService->create($request->all());
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('added successfully'));
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $Ticket  =   $this->SupportService->getById($id);
        return view('Admin.supports.Ticket.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $this->SupportService->update($id, $request->all());
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroy($id)
    {
        $this->SupportService->delete($id);
        return redirect()->route('Admin.SupportTickets.index')
            ->withSuccess(__('Deleted successfully'));
    }
}
