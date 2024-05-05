<div class="row">

    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                @if (Auth::user()->hasPermission('create-interest-request-status'))
                    <div class="col-md-6">
                        <a href="{{ route('Admin.InterestTypes.create') }}"
                            class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light">
                            @lang('Add New Interest')
                        </a>
                    </div>
                @endif
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($interests as $index=> $interest)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $interest->name }} </td>
                                <td>
                                    @if (Auth::user()->hasPermission('update-interest-request-status'))
                                        <a href="{{ route('Admin.InterestTypes.edit', $interest->id) }}"
                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                    @endif
                                    @if (Auth::user()->hasPermission('delete-interest-request-status'))
                                        <a href="javascript:void(0);" onclick="handleDelete('{{ $interest->id }}')"
                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                            @lang('Delete')
                                        </a>
                                        <form id="delete-form-{{ $interest->id }}"
                                            action="{{ route('Admin.InterestTypes.destroy', $interest->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
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

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end col -->
