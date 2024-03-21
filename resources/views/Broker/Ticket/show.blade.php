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
                                            href="{{ route('Broker.Tickets.index') }}">@lang('Tickets')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
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


                            <div class="mt-3">
                                <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-secondary">@lang('Back')</a>
                            </div>
                        </div>

                      <!-- Display responses -->
                      {{-- @if($ticket->responses->isNotEmpty()) --}}
                      <div class="mt-4">
                        <h5>@lang('التعليقات')</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('التعليق')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($ticketResponses as $response)
                                <tr>

                                    <td>{{ $response->response }}</td> <!-- Display the response -->
                                    <td>{{ __($ticket->status)}}</td> <!-- Display the response -->
                                    <td>{{ $response->created_at->format('Y-m-d H:i:s') }}</td> <!-- Display the creation date -->
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                      {{-- @endif --}}

                      <!-- Form to add response -->
                      <div class="mt-4">
                          <h5>@lang('اضف تعليقك')</h5>
                          <form action="{{ route('Broker.tickets.addResponse', $ticket->id) }}" method="POST">
                            @csrf
                              <div class="mb-3">
                                  <label for="response" class="form-label">@lang('التعليق')</label>
                                  <textarea class="form-control" id="response" name="response" rows="5" required></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary">@lang('Submit Comment')</button>
                          </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
