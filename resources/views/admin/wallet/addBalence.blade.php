@extends('admin.layout.main')

@section('admin-page-title', ucfirst('Add Balence'))

@section('admin-main-section')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">{{ ucfirst('Add Balence') }} User</h1>
    </div>
</div>
<!-- PAGE-HEADER END -->

@php
$useroption = [];
foreach($users as $usr) {
$useroption[$usr->id] = $usr->name . ' , ' . $usr->email;
}
@endphp


<!-- Row -->
<div class="row row-sm container-fluid w-50 mx-auto">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ ucfirst('Add Balence') }}</h3>
            </div>
            <div class="card-body">
                <form method="POST"
                    action="{{ route('admin.wallet.addBalence') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">


                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label" for="user_id">Select user</label>
                                    <select class="form-control select2-show-search form-select dark-mode" name="user_id"
                                        id="user_id" required>
                                        <option value="" selected disabled>Select Customer</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name.'.,. '.$user->email }}</option>
                                        @endforeach
                                    </select>
                                    @error('select_user')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <x-inputs.input-field class="col-xl-12 mb-3" label="Amount" name="amount"
                                    type="text" :value="old('amount', $user->amount ?? '')" />

                            </div>

                        </div>

                    </div>

                    <center><x-buttons.simple-button class="btn btn-primary"
                            type="submit">Add Balence
                        </x-buttons.simple-button></center>

                </form>
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
<!-- <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script> -->
<!-- <script src="{{ asset('../assets/js/select2.js') }}"></script> -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- <script> $(document).ready(function() {
            $('.product-select').select2(); 
        });
</script> -->
<!-- use for multiple dropdowns -->
@endsection