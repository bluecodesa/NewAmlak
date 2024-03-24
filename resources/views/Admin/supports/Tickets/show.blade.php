@extends('Admin.layouts.app')
@section('title', __('View Ticket'))
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h4 class="page-title">
                                    @lang('View Ticket')</h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.SupportTickets.show',$ticket->id) }}">@lang('View Ticket')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Admin.SupportTickets.index') }}">@lang('Tickets Support')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Ticket Details')</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>@lang('Ticket Number'):</strong> {{ $ticket->id }}</p>
                                    <p><strong>@lang('Ticket Type'):</strong> {{ $ticket->ticketType->name }}</p>
                                    <p><strong>@lang('Ticket Address'):</strong> {{ $ticket->subject }}</p>
                                    <p><strong>@lang('Ticket Status'):</strong> {{ __($ticket->status) }}</p>
                                </div>
                                <div class="col-md-6">
                                    @if($ticket->image)
                                    <p><strong>@lang('Ticket Image'):</strong></p>
                                    <img src="{{ asset($ticket->image) }}" alt="Ticket Image" class="img-fluid">
                                    @endif
                                    <!-- Add other ticket details here -->
                                </div>
                            </div>



                        </div>

                        <!-- Status and Close Button -->
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <h3 class="mt-0 header-title">@lang('Ticket Status') : <label class="badge badge-primary">{{ __($ticket->status) }}</label></h3>
                            </div>
                            <div class="col-sm-6">
                                @if($ticket->status !== 'Closed')
                                    <form action="{{ route('Broker.closeTicket', $ticket->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">@lang('Close Ticket')</button>
                                    </form>
                                @endif
                            </div>
                        </div>


                    <h5>@lang('Comments')</h5>


                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="datatable-buttons" class="table  table-striped">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('comment')</th>
                                    <th scope="col">@lang('Date')</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($ticketResponses as $response)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{ optional($response->UserData)->avatar ?: 'https://www.svgrepo.com/show/29852/user.svg' }}" class="mr-3 rounded-circle" alt="{{ optional($response->UserData)->name ?? 'Default Name' }}" style="width: 64px; height: 64px;">
                                    </td>
                                    <td>{{ $response->response }}</td>
                                    <td>{{ $response->created_at->format('Y-m-d H:i:s') }}</td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>



                      {{-- @endif --}}
                      @if($ticket->status !="Closed")

                      <!-- Form to add response -->
                      <div class="mt-4">
                          <h5>@lang('اضف تعليقك')</h5>
                          <form action="{{ route('Admin.SupportTickets.addResponse', $ticket->id) }}" method="POST">
                            @csrf
                              <div class="mb-3">
                                  <label for="response" class="form-label">@lang('التعليق')</label>
                                  <textarea class="form-control" id="response" name="response" rows="5" @if($ticket->status === 'closed') disabled @endif required></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary" @if($ticket->status === 'closed') disabled @endif>@lang('Submit Comment')</button>
                          </form>
                      </div>

                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
