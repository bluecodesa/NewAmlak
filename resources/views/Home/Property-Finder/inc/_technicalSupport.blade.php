<div class="text-center my-4">
    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addTicketModal">
        @lang('Add New Ticket')
    </button>
</div>

<div class="row">
    <!-- Left side: list of support tickets -->
    <div class="col-md-4">
        <div class="list-group">
            @foreach($tickets as $ticket)
                <a href="#ticket-{{ $ticket->id }}" class="list-group-item list-group-item-action" data-bs-toggle="collapse">
                    @lang('Ticket Number') #{{ $ticket->formatted_id }} -  <span class="badge bg-label-primary">{{ __($ticket->status) }}</span>
                     <br>  {{ $ticket->ticketType->name }}
                    <span class="badge bg-primary rounded-pill">{{ $ticket->ticketResponses->count() }} @lang('Comments')</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Right side: ticket details and replies -->
    <div class="col-md-8">
        @foreach($tickets as $ticket)
            <div class="collapse" id="ticket-{{ $ticket->id }}">
                <div class="card">
                    <div class="card-header">
                        {{-- @lang('Ticket Number') #{{ $ticket->formatted_id }} - {{ $ticket->subject }} - --}}
                        @lang('Ticket Number') #{{ $ticket->formatted_id }} -
                        @lang('Ticket Type') : <span>{{ $ticket->ticketType->name }}</span>
                        <span class="badge bg-label-primary">{{ __($ticket->status) }}</span>

                    </div>
                    <div class="card-header">
                        <span class="fw-medium me-1">@lang('Description'):</span>
                        {{-- <span>{{ $ticket->content }}</span> --}}
                        <span class="mb-1">{!! $ticket->content !!}</span>

                    </div>
                    <div class="card-body">
                        <!-- Display ticket description -->
                        <p>{{ $ticket->description }}</p>

                        <!-- Display replies -->
                        <div class="chat-box">
                            @foreach($ticket->ticketResponses as $reply)
                                {{-- <div class="chat-message {{ $reply->is_admin ? 'text-right' : '' }}">
                                    <strong>{{ $reply->is_admin ? 'Admin' : $finder->name }}:</strong>
                                    <p>{{  $reply->response  }}</p>

                                    <!-- Check if there's an attachment -->
                                    @if($reply->response_attachment)
                                    <div class="attachment">
                                        @if(in_array(pathinfo($reply->response_attachment, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif']))
                                            <!-- Show image attachment -->
                                            <a href="{{ asset($reply->response_attachment) }}" download>
                                                <i class="tf-icons ti ti-download ti-xs me-1">@lang('Attachments')</i>
                                            </a>
                                            @elseif(pathinfo($reply->response_attachment, PATHINFO_EXTENSION) == 'pdf')
                                            <!-- Show PDF attachment with download icon -->
                                            <a href="{{ asset($reply->response_attachment) }}" download>
                                                <i class="tf-icons ti ti-download ti-xs me-1">@lang('Attachments')</i>
                                            </a>
                                        @endif
                                    </div>
                                @endif


                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div> --}}
                                <div
                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer mb-5">
                                <img src="{{ optional($reply->UserData)->avatar ?: url('HOME_PAGE/img/avatars/14.png') }}"
                                    alt="{{ optional($reply->UserData)->name ?? 'Default Name' }}"
                                    class="rounded-circle me-3 w-px-50" />
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <div class="col-8 user-info">
                                                <strong>{{ $reply->is_admin ? 'Admin' : $finder->name }}:</strong>
                                                <h6 class="mb-1">{!! $reply->response !!}</h6>
                                                <div class="user-status">
                                                    <span class="badge"></span>
                                                    <small>{{ $reply->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div class="col-4 add-btn">
                                                @if ($reply->response_attachment)
                                                    <span
                                                        class="badge bg-label-secondary">{{ basename($reply->response_attachment) }}</span>
                                                    <a class="btn btn-primary ti ti-download btn-sm"
                                                        href="{{ asset($reply->response_attachment) }}"
                                                        download></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endforeach
                        </div>


                        <!-- Reply form -->
                        @if ($ticket->status != 'Closed')
                        <form action="{{ route('PropertyFinder.tickets.addResponse', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mt-3">
                                <textarea name="response" class="form-control" placeholder="Type your reply..." required></textarea>
                            </div>

                            <div class="input-group mt-3">
                                <label for="response_attachment" class="form-label"></label>
                                <input type="file" name="response_attachment" id="response_attachment" class="form-control" accept=".jpeg,.png,.jpg,.gif,.pdf">
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">@lang('Add your comment')</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



<!-- Add Ticket Modal -->
<div class="modal fade" id="addTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTicketModalLabel">{{ __('Add New Ticket') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Your form goes here -->
                <form action="{{ route('PropertyFinder.create-ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="ticketType" class="form-label">{{ __('Ticket Type') }} <span class="required-color">*</span></label>
                        <select class="form-select" name="type" id="ticketType" required>
                            <option value="" selected disabled> @lang('Ticket Type') </option>
                            @foreach ($ticketTypes as $ticketType)
                                <option value="{{ $ticketType->id }}">{{ $ticketType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">@lang('Ticket Address') <span class="required-color">*</span></label>
                        <input type="text" required name="subject" id="subject" class="form-control" placeholder="@lang('Ticket Address')">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }} <span class="required-color">*</span></label>
                        <textarea id="textarea" class="form-control" name="content" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">@lang('Image')</label>
                        <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/gif,image/jpg">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    var chatBox = document.querySelector('.chat-box');
    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});

</script>
