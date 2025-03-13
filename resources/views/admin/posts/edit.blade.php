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

{{--
@php
dd($post);
@endphp
--}}



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

                        @if ($mode == 'view')
                        <div class="container-fluid text-center">
                            <div class="card mx-auto" style="max-width: 600px;">
                                <div class="card-body">
                                    <div class="col-xl-12 mb-3">
                                        @if ($post->attachments && $post->attachments->count() == 1)
                                        @if($post->attachments[0]->type == 'mp4')
                                        <div class="mb-3">
                                            <label class="form-label mt-0" for="video">Video</label>
                                            <video width="100%" controls class="br-5">
                                                <source src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        @elseif($post->attachments[0]->type == 'mp3')
                                        <div class="mb-3">
                                            <label class="form-label mt-0" for="audio">Audio</label>
                                            <div class="text-center mb-2">
                                                <img src="{{ $post->audio_image_url }}" alt="Audio Thumbnail"
                                                    class="img-fluid br-5" style="max-height: 180px; width: auto;">
                                            </div>
                                            <audio controls class="w-100">
                                                <source src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments->filename) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                        @elseif(in_array($post->attachments[0]->type, ['jpg', 'jpeg', 'png', 'gif']))
                                        <div class="mb-3">
                                            <label class="form-label mt-0" for="image">Image</label>
                                            <div class="text-center">
                                                <img class="img-fluid br-5" style="max-height: 180px; width: auto;"
                                                    src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}"
                                                    alt="Post Image">
                                            </div>
                                        </div>
                                        @elseif($post->attachments[0]->type == 'pdf')
                                        <div class="mb-3">
                                            <label class="form-label mt-0" for="pdf">PDF</label>
                                            <div class="text-center" style="max-height: 180px;">
                                                <embed src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}" download
                                                    type="application/pdf" width="100%" height="600px" />

                                                <a href="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}" download>
                                                    <embed src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}" type="application/pdf" width="100%" height="600px" />
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @elseif ($post->attachments && $post->attachments->count() > 1)
                                        @if($post->attachments[0]->type == 'mp3')
                                        <div class="mb-3">
                                            <!-- <label class="form-label mt-0" for="image">Image</label> -->
                                            <div class="text-center">
                                                <img class="img-fluid br-5" style="max-height: 180px; width: auto;"
                                                    src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[1]->filename) }}"
                                                    alt="Post Image">
                                            </div>

                                            <audio controls class="w-100">
                                                <source src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>

                                        @else
                                        <div class="mb-3">
                                            <!-- <label class="form-label mt-0" for="image">Image</label> -->
                                            <div class="text-center">
                                                <img class="img-fluid br-5" style="max-height: 180px; width: auto;"
                                                    src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[0]->filename) }}"
                                                    alt="Post Image">
                                            </div>

                                            <audio controls class="w-100">
                                                <source src="{{ asset('https://openzippers.s3.amazonaws.com/' . $post->attachments[1]->filename) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>

                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <p>No Attachments Found</p>
                                        </div>
                                        @endif

                                        <!-- @if($mode == 'edit')
                                        <div class="mt-3">
                                            <label class="form-label mt-0" for="new_media">Upload New Media</label>
                                            <input type="file" class="dropify" name="media" data-bs-height="180" />
                                            @error('media')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endif -->
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
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Name" name="name"
                                    type="text" :value="old('name', $mode == 'edit' ? $post->name : '')" />
                                @elseif($mode == 'view')
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="name">Name</label>
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
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Price" name="price" type="number"
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
                                <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Status" name="status" type="text"
                                    :value="old('status', $mode == 'edit' ? $post->status : '')" /> -->
                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Status" name="status"
                                    :options="[ 1 => 'Active', 0 => 'Inactive']"
                                    :selected="old('status', $mode == 'edit' ? ($post->status ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="status">Status</label>
                                    <p class="form-control">{{ $post->status }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Type" name="type" type="text"
                                    :value="old('type', $mode == 'edit' ? $post->type : '')" /> -->
                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Type" name="type"
                                    :options="[
                                        'post' => 'Post',
                                        'literature' => 'Literature',
                                        'video' => 'Video',
                                        'audio' => 'Audio'
                                    ]"
                                    :selected="old('type', $mode == 'edit' ? ($post->type ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="type">Type</label>
                                    <p class="form-control">{{ $post->type }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="isCertified" name="is_certified" type="text"
                                    :value="old('is_certified', $mode == 'edit' ? $post->is_certified : '')" /> -->

                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="isCertified" name="is_certified"
                                    :options="[
                                    'yes' => 'Yes',
                                    'no' => 'No'
                                ]"
                                    :selected="old('is_certified', $mode == 'edit' ? ($post->is_certified ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="is_certified">isCertified</label>
                                    <p class="form-control">{{ $post->is_certified }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="isPublish" name="is_publish" type="text"
                                    :value="old('is_publish', $mode == 'edit' ? $post->is_publish : '')" /> -->

                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="isPublish" name="is_publish"
                                    :options="[
                                        'yes' => 'Yes',
                                        'no' => 'No'
                                    ]"
                                    :selected="old('is_publish', $mode == 'edit' ? ($post->is_publish ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="is_publish">isPublish</label>
                                    <p class="form-control">{{ $post->is_publish }}</p>
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