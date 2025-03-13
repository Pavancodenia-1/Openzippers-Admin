@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'Manage Posts'))

@section('admin-main-section')

<style>
    .truncate {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        position: relative;
        display: inline-block;
    }

    .truncate:hover {
        white-space: normal;
        overflow: visible;
        padding: 5px;
    }
</style>

<!-- PAGE-HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">{{ ucfirst($mode ?? 'Manage Posts') }}</h1>

        <!-- @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->user_role<= 1)
                <a href="{{ route('admin.posts.create') }}"><x-buttons.simple-button class="btn btn-primary" type="button">Add
                        Post</x-buttons.simple-button></a>
            @endif
             -->
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Posts</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottomm" id="file-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Username</th>
                                <th class="wd-20p border-bottom-0">Titile</th>
                                <th class="wd-15p border-bottom-0">User id</th>
                                <th class="wd-15p border-bottom-0">Users</th>
                                <th class="wd-15p border-bottom-0">Price</th>
                                <th class="wd-15p border-bottom-0">Text</th>
                                <th class="wd-15p border-bottom-0">Profile</th>
                                <th class="wd-15p border-bottom-0">Attachments</th>
                                <th class="wd-15p border-bottom-0">Status</th>
                                <th class="wd-15p border-bottom-0">Type</th>
                                <th class="wd-15p border-bottom-0">Created At</th>
                                <th class="wd-25p border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->username }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->user_id }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->price }}</td>
                                <!-- <td><textarea cols='30' rows='3' readonly>{{ $post->text }}</textarea> </td> -->
                                <td>
                                    <div class="truncate" title="{{ $post->text }}">
                                        {{ $post->text }}
                                    </div>
                                </td>
                                <td> <img class="img-responsive br-5 rounded-circle w-100"
                                        src="{{ file_exists(public_path($post->avatar)) && $post->avatar ? asset($post->avatar) : asset('assets/profile.svg') }}"
                                        alt="Image">
                                </td>
                                <td>{{ $post->filename }}</td>
                                <td>{{ $post->status }}</td>
                                <td>{{ $post->type }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td class="text-center">
                                    <x-buttons.action-pill-button iconClass="fa fa-eye" iconColor="secondary"
                                        href="{{ route('admin.posts.view', $post->id) }}" />

                                    @if (Auth::guard('admin')->user()->user_role
                                    <= 1)
                                        <x-buttons.action-pill-button
                                        href="{{ route('admin.posts.edit', $post->id) }}"
                                        iconClass="fa fa-pencil" iconColor="warning"
                                        modalTarget="editUserModal" />
                                    @endif

                                    @if (Auth::guard('admin')->user()->user_role <= 1)
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
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