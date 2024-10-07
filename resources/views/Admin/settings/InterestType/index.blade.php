<div class="row">

    <div class="col-12">

        @if (Auth::user()->hasPermission('create-interest-request-status'))
            <div class="col-md-12 mb-3">
                <a href="{{ route('Admin.create.interest-type') }}" class="btn btn-primary waves-effect waves-light">
                    @lang('Add New Interest')
                </a>
            </div>
        @endif

        <table class="table" id="table">
            <thead class="table-dark">
                <tr>
                    {{-- <th>#</th> --}}
                    <th>@lang('Name')</th>
                    <th>@lang('Default')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($interests as $index=> $interest)
                    <tr>
                        {{-- <th>{{ $index + 1 }}</th> --}}
                        <td>{{ $interest->name }} </td>
                        <td>{{ $interest->default ? __('Yes') : __('No') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                    @if (Auth::user()->hasPermission('update-interest-request-status'))
                                        <a class="dropdown-item"
                                            href="{{ route('Admin.edit.interest-type', $interest->id) }}">@lang('Edit')</a>
                                    @endif

                                    @if (Auth::user()->hasPermission('delete-interest-request-status'))
                                        <a href="javascript:void(0);" onclick="handleDelete('{{ $interest->id }}')"
                                            class="dropdown-item delete-btn">@lang('Delete')</a>
                                        <form id="delete-form-{{ $interest->id }}"
                                            action="{{ route('Admin.delete.interest-type', $interest->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Interests Types Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $interests->links() }}


    </div> <!-- end col -->
</div> <!-- end col -->
