@extends('admin.layout.main')

@section('admin-page-title', 'Users')

@section('admin-main-section')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Manage Users</h1>

            @if (Auth::guard('admin')->user()->user_role<= 1)
                <a href="{{ route('admin.users.create') }}"><x-buttons.simple-button class="btn btn-primary" type="button">Add
                        User</x-buttons.simple-button></a>
            @endif
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Users</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottomm" id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Role</th>
                                    <th class="wd-20p border-bottom-0">Name</th>
                                    <th class="wd-15p border-bottom-0">Email</th>
                                    <th class="wd-15p border-bottom-0">Username</th>
                                    <th class="wd-15p border-bottom-0">Mobile</th>
                                    <th class="wd-15p border-bottom-0">Avtar</th>
                                    <th class="wd-15p border-bottom-0">Gender</th>
                                    <th class="wd-15p border-bottom-0">Total Posts Count</th>
                                    <th class="wd-15p border-bottom-0">Public Profile</th>
                                    <th class="wd-15p border-bottom-0">Open Profile</th>
                                    <th class="wd-15p border-bottom-0">Paid Verified</th>
                                    <th class="wd-15p border-bottom-0">Email Verified At</th>
                                    <th class="wd-15p border-bottom-0">ID Verified At</th>
                                    <th class="wd-25p border-bottom-0">Created At</th>
                                    <th class="wd-25p border-bottom-0">Updated At</th>
                                    @if (Auth::guard('admin')->user()->user_role <= 1)
                                        <th class="wd-25p border-bottom-0">Status</th>
                                    @endif
                                    <th class="wd-25p border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($user->role_id == 0)
                                                Administrator
                                            @elseif ($user->role_id == 1)
                                                Artist
                                            @elseif($user->role_id == 2)
                                                Normal User
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>
                                            <img class="img-responsive br-5 rounded-circle w-100"
                                                src="{{ file_exists(public_path($user->avatar)) && $user->avatar ? asset($user->avatar) : asset('assets/profile.svg') }}"
                                                alt="Image">
                                        </td>

                                        <td>
                                            @if($user->gender==1)
                                                Male
                                            @elseif($user->gender == 0)
                                                Female
                                            @else
                                                Other
                                            @endif
                                        </td>
                                        <td><a href="{{ route('admin.posts.show', ['id' => $user->id]) }}">{{ $user->posts_count }}</a></td>
                                        <td>{{ $user->public_profile }}</td>
                                        <td>{{ $user->open_profile }}</td>
                                        <td>{{ $user->paid_profile }}</td>
                                        <td>{{ $user->email_verified_at }}</td>
                                        <td>{{ $user->identity_verified_at }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        @if (Auth::guard('admin')->user()->user_role <= 1)
                                            <td class="text-center">
                                                @if (Auth::guard('admin')->user()->user_role <= 1)
                                                    <x-buttons.status-switch entityType="user"
                                                        entityId="{{ $user->id }}" status="{{ $user->status }}"
                                                        ajaxUrl="{{ route('admin.users.status') }}" />
                                                @else
                                                    <span class="badge bg-danger rounded-pill">Restricted</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            <x-buttons.action-pill-button iconClass="fa fa-eye" iconColor="secondary"
                                                href="{{ route('admin.users.view', $user->id) }}" />

                                            @if (Auth::guard('admin')->user()->user_role <= 1)
                                                <x-buttons.action-pill-button
                                                    href="{{ route('admin.users.edit', $user->id) }}"
                                                    iconClass="fa fa-pencil" iconColor="warning"
                                                    modalTarget="editUserModal" />
                                            @endif

                                            @if (Auth::guard('admin')->user()->user_role <= 1)
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-buttons.action-pill-button type="submit" iconClass="fa fa-trash"
                                                        iconColor="danger" />
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('custom-script')
    <!-- DATA TABLE JS-->
    <script src="{{ asset('../assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('../assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('../assets/js/table-data.js') }}"></script>
@endsection
