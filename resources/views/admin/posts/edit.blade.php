@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'create') . ' Post')

@section('admin-main-section')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">{{ ucfirst($mode ?? 'create') }} Post</h1>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
@php
dd($post);
@endphp

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ ucfirst($mode ?? 'create') }} User</h3>
                </div>
                <div class="card-body">
                    @if ($mode == 'edit' || $mode == 'create')
                        <form method="POST"
                            action="{{ $mode == 'create' ? route('admin.posts.store') : route('admin.posts.update', $post->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($mode == 'edit')
                                @method('PUT')
                            @endif
                    @endif

                    <div class="form-row">

                        @if ($mode == 'edit' || $mode == 'view')
                            <div class="container-fluid text-center">
                                <div class="card mx-auto" style="max-width: 600px;">

                                    <div class="card-body">
                                        <!-- Media Input Field (For 'edit' or 'create' modes) -->
                                        <div class="col-xl-12 mb-3">
                                            @if ($post->attachment_type == 'mp4')
                                                <label class="form-label mt-0" for="video">Video</label>
                                                <input type="file" class="dropify" name="media" data-bs-height="180"
                                                    data-default-file="{{ $mode == 'edit' && isset($post) && $post->media ? asset($post->avatar) : '' }}" />
                                                @error('video')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @else if($post->attachment_type == 'mp3')

                                                <img src="your-image-url.jpg" alt="Click to play audio" id="image" style="width: 300px; cursor: pointer;">
                                                <audio id="audio" src="your-audio-url.mp3" controls style="display: none;"></audio>

                                                <div class="text-center">
                                                    <img class="img-fluid br-5" style="max-height: 180px; width: auto;"
                                                        src="{{ file_exists(public_path($post->media)) && $post->media ? asset($post->media) : asset('assets/profile.svg') }}" alt="User Image">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                                                
                        <div class="col-xl-12">
                            <div class="row">
                                @if ($mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Username" name="username"
                                        type="text" :value="old('username', $mode == 'edit' ? $post->username : '')" />
                                @elseif($mode == 'view')
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="username">Username</label>
                                        <p class="form-control">{{ $post->username }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Name" name="username"
                                        type="text" :value="old('name', $mode == 'edit' ? $post->name : '')" />
                                @elseif($mode == 'view')
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="username">Name</label>
                                        <p class="form-control">{{ $post->name }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="User Id" name="user_id" type="text"
                                        :value="old('user_id', $mode == 'edit' ? $post->user_id : '')" />
                                @elseif($mode == 'view')
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="user_id">User Id</label>
                                        <p class="form-control">{{ $post->user_id }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Price" name="price" type="text"
                                        :value="old('price', $mode == 'edit' ? $post->price : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="price">Price</label>
                                        <p class="form-control">{{ $post->price }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Title" name="title" type="title"
                                        :value="old('title', $mode == 'edit' ? $post->email : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="title">Title</label>
                                        <p class="form-control">{{ $post->title }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Text" name="text" type="text"
                                        :value="old('text', $mode == 'edit' ? $post->text : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="text">Text</label>
                                        <p class="form-control">{{ $post->text }}</p>
                                    </div>
                                @endif 


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Status" name="status" type="text"
                                        :value="old('status', $mode == 'edit' ? $post->status : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="status">Status</label>
                                        <p class="form-control">{{ $post->status }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Type" name="type" type="text"
                                        :value="old('type', $mode == 'edit' ? $post->type : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="type">Type</label>
                                        <p class="form-control">{{ $post->type }}</p>
                                    </div>
                                @endif


                            </div>

                        </div>


                    </div>

                    @if ($mode == 'edit' || $mode == 'create')
                        <center><x-buttons.simple-button class="btn btn-primary"
                                type="submit">{{ $mode == 'edit' ? 'Update' : 'Create' }}
                                User</x-buttons.simple-button></center>
                    @endif

                    @if ($mode == 'edit' || $mode == 'create')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('custom-script')
    <!-- INPUT MASK JS-->
    <script src="{{ asset('assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

    <!-- FORMVALIDATION JS -->
    <script src="{{ asset('assets/js/form-validation.js') }}"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="{{ asset('../assets/js/show-password.min.js') }}"></script>

    <!-- FILE UPLOADES JS -->
    <script src="{{ asset('../assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('../assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <!-- SELECT2 JS -->
    <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('../assets/js/select2.js') }}"></script>
@endsection
