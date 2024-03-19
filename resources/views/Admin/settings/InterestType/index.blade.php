

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                            <div class="col-md-6" >
                                    <a href="{{ route('Admin.create.interest-type') }}"
                                        class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light">
                                        @lang('Add New Interest')
                                    </a>
                                </div>

                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
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

                                                    <a href="{{ route('Admin.edit.interest-type', $interest->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $interest->id }}')"
                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                        @lang('Delete')
                                                    </a>
                                                    <form id="delete-form-{{ $interest->id }}"
                                                        action="{{ route('Admin.delete.interest-type', $interest->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

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
