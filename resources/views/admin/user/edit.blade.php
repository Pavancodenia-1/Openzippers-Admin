@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'create') . ' User')

@section('admin-main-section')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">{{ ucfirst($mode ?? 'create') }} User</h1>
        </div>
    </div>
    <!-- PAGE-HEADER END -->


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
                            action="{{ $mode == 'create' ? route('admin.users.store') : route('admin.users.update', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($mode == 'edit')
                                @method('PUT')
                            @endif
                    @endif

                    <div class="form-row">

                        <div class="col-xl-4 mb-3">
                            @if ($mode == 'edit' || $mode == 'create')
                                <label class="form-label mt-0" for="image">Avatar</label>
                                <input type="file" class="dropify" name="avatar" data-bs-height="180"
                                    data-default-file="{{ $mode == 'edit' && isset($user) && $user->avatar ? asset($user->avatar) : '' }}" />
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="text-center">
                                    <img class="img-responsive br-5" style="height: 180px;"
                                        src="{{ file_exists(public_path($user->avatar)) && $user->avatar ? asset($user->avatar) : asset('assets/profile.svg') }}" alt="User Image">
                                </div>
                            @endif
                        </div>

                        <div class="col-xl-8">
                            <div class="row">
                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-6 mb-3" label="Full Name" name="name"
                                        type="text" :value="old('name', $mode == 'edit' ? $user->name : '')" />
                                @else
                                    <div class="col-xl-6 mb-3">
                                        <label class="form-label mt-0" for="name">Full Name</label>
                                        <p class="form-control">{{ $user->name }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-6 mb-3" label="Email" name="email" type="email"
                                        :value="old('email', $mode == 'edit' ? $user->email : '')" />
                                @else
                                    <div class="col-xl-6 mb-3">
                                        <label class="form-label mt-0" for="email">Email</label>
                                        <p class="form-control">{{ $user->email }}</p>
                                    </div>
                                @endif

                                <div class="col-xl-6 mb-3">
                                    <label class="form-label mt-0" for="role">User Role</label>
                                    @if ($mode == 'edit' || $mode == 'create')
                                        <select class="form-control select2 form-select" id="role_id" name="role_id">
                                            <option value="" disabled selected hidden>Select User Role</option>
                                            <option value="0"
                                                {{ old('role', $mode == 'edit' ? $user->role_id : '') == 0 ? 'selected' : '' }}>
                                                Administrator</option>
                                            <option value="1"
                                                {{ old('role', $mode == 'edit' ? $user->role_id : '') == 1 ? 'selected' : '' }}>
                                                Artist</option>
                                            <option value="2"
                                                {{ old('role', $mode == 'edit' ? $user->role_id : '') == 2 ? 'selected' : '' }}>
                                                Normal User</option>
                                        </select>
                                    @else
                                        <p class="form-control">
                                            @switch($user->role_id)
                                                @case(0)
                                                    Administrator
                                                @break

                                                @case(1)
                                                    Artist
                                                @break

                                                @case(2)
                                                    Normal User
                                                @break
                                            @endswitch
                                        </p>
                                    @endif
                                    @error('role')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-6 mb-3" label="User Name" name="username"
                                        type="text" :value="old('username', $mode == 'edit' ? $user->username : '')" />
                                @else
                                    <div class="col-xl-6 mb-3">
                                        <label class="form-label mt-0" for="username">User Name</label>
                                        <p class="form-control">{{ $user->username }}</p>
                                    </div>
                                @endif

                            </div>

                            @if ($mode == 'edit' || $mode == 'create')
                                <div class="row">
                                    <div class="col-xl-6 mb-3">
                                        <label class="form-label mt-0">New Password</label>
                                        <div class="input-group" id="Password-toggle1">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                            </a>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                type="password" name="password" placeholder="New Password"
                                                autocomplete="new-password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-6 mb-3">
                                        <label class="form-label mt-0">Confirm Password</label>
                                        <div class="input-group" id="Password-toggle2">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                            </a>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                                type="password" name="password_confirmation" placeholder="Confirm Password"
                                                autocomplete="new-password">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($mode == 'edit')
                                        <div class="text-center col-xl-12 mb-3">
                                            <small class="text-muted">Leave blank to keep the current password.</small>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>

                        <div class="col-xl-12">
                            <div class="row">
                                
                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Mobile" name="mobile"
                                        type="text" :value="old('mobile', $mode == 'edit' ? $user->mobile : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="name">Mobile</label>
                                        <p class="form-control">{{ $user->mobile }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Gender" name="gender"
                                        :options="['0' => 'Female', '1' => 'Male', '2' => 'Other']"
                                        :selected="old('gender', $mode == 'edit' ? ($user->gender ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="name">Gender</label>
                                        <p class="form-control">
                                            @switch($user->gender)
                                                @case(0)
                                                    Female
                                                    @break
                                                @case(1)
                                                    Male
                                                    @break
                                                @case(2)
                                                    Other
                                                    @break
                                                @default
                                                    Unknown
                                            @endswitch
                                        </p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Referral Code" name="referral_code"
                                        type="text" :value="old('referral_code', $mode == 'edit' ? $user->referral_code : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="referral_code">Referral Code</label>
                                        <p class="form-control">{{ $user->referral_code }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Bio" name="bio"
                                        type="text" :value="old('bio', $mode == 'edit' ? $user->bio : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="bio">Bio</label>
                                        <p class="form-control">{{ $user->bio }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Location" name="location"
                                        type="text" :value="old('location', $mode == 'edit' ? $user->location : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="location">Location</label>
                                        <p class="form-control">{{ $user->location }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="website" name="website"
                                        type="text" :value="old('website', $mode == 'edit' ? $user->website : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="website">Website</label>
                                        <p class="form-control">{{ $user->website }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Public Profile" name="public_profile"
                                        type="text" :value="old('public_profile', $mode == 'edit' ? $user->public_profile : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Public Profile" name="public_profile"
                                        :options="['1' => 'True', '0' => 'Flase']"
                                        :selected="old('public_profile', $mode == 'edit' ? ($user->public_profile ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="public_profile">Public Profile</label>
                                        <p class="form-control">{{ $user->public_profile }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Open Profile" name="open_profile"
                                        type="text" :value="old('open_profile', $mode == 'edit' ? $user->open_profile : '')" /> -->
                                    
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Open Profile" name="open_profile"
                                        :options="['1' => 'True', '0' => 'Flase']"
                                        :selected="old('open_profile', $mode == 'edit' ? ($user->open_profile ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="open_profile">Open Profile</label>
                                        <p class="form-control">{{ $user->open_profile }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Paid Profile" name="paid_profile"
                                        type="text" :value="old('paid_profile', $mode == 'edit' ? $user->paid_profile : '')" /> -->
                                    
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Paid Profile" name="paid_profile"
                                        :options="['1' => 'True', '0' => 'Flase']"
                                        :selected="old('paid_profile', $mode == 'edit' ? ($user->paid_profile ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="paid_profile">Paid Profile</label>
                                        <p class="form-control">{{ $user->paid_profile }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Profile Access Price" name="profile_access_price"
                                        type="text" :value="old('profile_access_price', $mode == 'edit' ? $user->profile_access_price : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="profile_access_price">Profile Access Price</label>
                                        <p class="form-control">{{ $user->profile_access_price }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Billing Address" name="billing_address"
                                        type="text" :value="old('billing_address', $mode == 'edit' ? $user->billing_address : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="billing_address">Billing Address</label>
                                        <p class="form-control">{{ $user->billing_address }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="First Name" name="first_name"
                                        type="text" :value="old('first_name', $mode == 'edit' ? $user->first_name : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="first_name">First Name</label>
                                        <p class="form-control">{{ $user->first_name }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Last Name" name="last_name"
                                        type="text" :value="old('last_name', $mode == 'edit' ? $user->last_name : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="last_name">Last Name</label>
                                        <p class="form-control">{{ $user->last_name }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Profile Access Price 3 Months" name="profile_access_price_3_months"
                                        type="text" :value="old('profile_access_price_3_months', $mode == 'edit' ? $user->profile_access_price_3_months : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="profile_access_price_3_months">Profile Access Price 3 Months</label>
                                        <p class="form-control">{{ $user->profile_access_price_3_months }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Profile Access Price 6 Months" name="profile_access_price_6_months"
                                        type="text" :value="old('profile_access_price_6_months', $mode == 'edit' ? $user->profile_access_price_6_months : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="profile_access_price_6_months">Profile Access Price 6 Months</label>
                                        <p class="form-control">{{ $user->profile_access_price_6_months }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Profile Access Price 12 Months" name="profile_access_price_12_months"
                                        type="text" :value="old('profile_access_price_12_months', $mode == 'edit' ? $user->profile_access_price_12_months : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="profile_access_price_12_months">Profile Access Price 12 Months</label>
                                        <p class="form-control">{{ $user->profile_access_price_12_months }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="City" name="city"
                                        type="text" :value="old('city', $mode == 'edit' ? $user->city : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="city">City</label>
                                        <p class="form-control">{{ $user->city }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="State" name="state"
                                        type="text" :value="old('state', $mode == 'edit' ? $user->state : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="state">State</label>
                                        <p class="form-control">{{ $user->state }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Country" name="country"
                                        type="text" :value="old('country', $mode == 'edit' ? $user->country : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="country">Country</label>
                                        <p class="form-control">{{ $user->country }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Postcode" name="postcode"
                                        type="text" :value="old('postcode', $mode == 'edit' ? $user->postcode : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="Postcode">Postcode</label>
                                        <p class="form-control">{{ $user->postcode }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Email Verified" name="email_verified_at"
                                        type="date" :value="old('email_verified_at', $mode == 'edit' ? $user->email_verified_at : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="email_verified_at">Email Verified</label>
                                        <p class="form-control">{{ $user->email_verified_at ?? ' ' }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Block Video Call" name="block_video_call"
                                        type="text" :value="old('block_video_call', $mode == 'edit' ? $user->block_video_call : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Block Video Call" name="block_video_call"
                                        :options="['1' => 'True', '0' => 'Flase']"
                                        :selected="old('block_video_call', $mode == 'edit' ? ($user->block_video_call ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="block_video_call">Block Video Call</label>
                                        <p class="form-control">{{ $user->block_video_call ?? ' '}}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Block Audio Call" name="block_audio_call"
                                        type="text" :value="old('block_audio_call', $mode == 'edit' ? $user->block_audio_call : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Block Audio Call" name="block_audio_call"
                                        :options="['1' => 'Flase', '0' => 'True']"
                                        :selected="old('block_audio_call', $mode == 'edit' ? ($user->block_audio_call ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="block_audio_call">Block Audio Call</label>
                                        <p class="form-control">{{ $user->block_audio_call }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Block Message" name="block_message"
                                        type="text" :value="old('block_message', $mode == 'edit' ? $user->block_message : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Block Message" name="block_message"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('block_message', $mode == 'edit' ? ($user->block_message ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="block_message">Block Message</label>
                                        <p class="form-control">{{ $user->block_message }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Birthdate" name="birthdate"
                                        type="date" :value="old('birthdate', $mode == 'edit' ? $user->birthdate : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="birthdate">Birthdate</label>
                                        <p class="form-control">{{ $user->birthdate }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Identity Verified" name="identity_verified_at"
                                        type="datetime-local" :value="old('identity_verified_at', $mode == 'edit' ? $user->identity_verified_at : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="identity_verified_at">Identity Verified</label>
                                        <p class="form-control">{{ $user->identity_verified_at }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="FCM Token" name="fcm_token"
                                        type="text" :value="old('fcm_token', $mode == 'edit' ? $user->fcm_token : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="fcm_token">FCM Token</label>
                                        <p class="form-control">{{ $user->fcm_token }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Auth Provider" name="auth_provider"
                                        type="text" :value="old('auth_provider', $mode == 'edit' ? $user->auth_provider : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="auth_provider">Auth Provider</label>
                                        <p class="form-control">{{ $user->auth_provider }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Auth Provider Id" name="auth_provider_id"
                                        type="text" :value="old('auth_provider_id', $mode == 'edit' ? $user->auth_provider_id : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="auth_provider_id">Auth Provider Id</label>
                                        <p class="form-control">{{ $user->auth_provider_id }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Enable 2fa" name="enable_2fa"
                                        type="text" :value="old('enable_2fa', $mode == 'edit' ? $user->enable_2fa : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Enable 2fa" name="enable_2fa"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('enable_2fa', $mode == 'edit' ? ($user->enable_2fa ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="enable_2fa">Enable 2fa</label>
                                        <p class="form-control">{{ $user->enable_2fa }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Enable Geoblocking" name="enable_geoblocking"
                                        type="text" :value="old('enable_geoblocking', $mode == 'edit' ? $user->enable_geoblocking : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Enable Geoblocking" name="enable_geoblocking"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('enable_geoblocking', $mode == 'edit' ? ($user->enable_geoblocking ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="enable_geoblocking">Enable Geoblocking</label>
                                        <p class="form-control">{{ $user->enable_geoblocking }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Enable Blur" name="enable_blur"
                                        type="text" :value="old('enable_blur', $mode == 'edit' ? $user->enable_blur : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Enable Blur" name="enable_blur"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('enable_blur', $mode == 'edit' ? ($user->enable_blur ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="enable_blur">Enable Blur</label>
                                        <p class="form-control">{{ $user->enable_blur }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Audio Download List" name="audio_download_list"
                                        type="text" :value="old('audio_download_list', $mode == 'edit' ? $user->audio_download_list : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="audio_download_list">Audio Download List</label>
                                        <p class="form-control">{{ $user->audio_download_list }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Artist Verify Status" name="artist_verify_status"
                                        type="text" :value="old('artist_verify_status', $mode == 'edit' ? $user->artist_verify_status : '')" /> -->
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Artist Verify Status" name="artist_verify_status"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('artist_verify_status', $mode == 'edit' ? ($user->artist_verify_status ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="artist_verify_status">Artist Verify Status</label>
                                        <p class="form-control">{{ $user->artist_verify_status }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Accept Term And Policy" name="accept_term_and_policy"
                                        type="text" :value="old('accept_term_and_policy', $mode == 'edit' ? $user->accept_term_and_policy : '')" /> -->

                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Accept Term And Policy" name="accept_term_and_policy"
                                        :options="['1' => 'Accept', '0' => 'Reject']"
                                        :selected="old('accept_term_and_policy', $mode == 'edit' ? ($user->accept_term_and_policy ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="accept_term_and_policy">Accept Term And Policy</label>
                                        <p class="form-control">{{ $user->accept_term_and_policy }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Plan id" name="plan_id"
                                        type="number" :value="old('plan_id', $mode == 'edit' ? $user->plan_id : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="plan_id">Plan Id</label>
                                        <p class="form-control">{{ $user->plan_id }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Purchased Plan Date" name="purchased_plan_date"
                                        type="date" :value="old('purchased_plan_date', $mode == 'edit' ? $user->purchased_plan_date : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="purchased_plan_date">Purchased Plan Date</label>
                                        <p class="form-control">{{ $user->purchased_plan_date }}</p>
                                    </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Dob" name="dob"
                                        type="date" :value="old('dob', $mode == 'edit' ? $user->dob : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="dob">Dob</label>
                                        <p class="form-control">{{ $user->dob }}</p>
                                    </div>
                                @endif

                                <!-- @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="image" name="image"
                                        type="file" :value="old('image', $mode == 'edit' ? $user->image : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="image">image</label>
                                        <p class="form-control">{{ $user->image }}</p>
                                    </div>
                                @endif -->

                                @if ($mode == 'edit' || $mode == 'create')
                                    <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Status" name="status"
                                        type="text" :value="old('status', $mode == 'edit' ? $user->status : '')" /> -->
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Status" name="status"
                                        :options="['1' => 'True', '0' => 'False']"
                                        :selected="old('status', $mode == 'edit' ? ($user->status ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="status">Status</label>
                                        <p class="form-control">{{ $user->status }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="address" name="address"
                                        type="text" :value="old('address', $mode == 'edit' ? $user->address : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="address">address</label>
                                        <p class="form-control">{{ $user->address }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Billing Detail" name="billing_detail"
                                        type="text" :value="old('billing_detail', $mode == 'edit' ? $user->billing_detail : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="billing_detail">Billing Detail</label>
                                        <p class="form-control">{{ $user->billing_detail }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Country Id" name="country_id"
                                        type="number" :value="old('country_id', $mode == 'edit' ? $user->country_id : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="country_id">Country Id</label>
                                        <p class="form-control">{{ $user->country_id }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="State Id" name="state_id"
                                        type="number" :value="old('state_id', $mode == 'edit' ? $user->state_id : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="state_id">State Id</label>
                                        <p class="form-control">{{ $user->state_id }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="City Id" name="city_id"
                                        type="number" :value="old('city_id', $mode == 'edit' ? $user->city_id : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="city_id">City Id</label>
                                        <p class="form-control">{{ $user->city_id }}</p>
                                    </div>
                                @endif

                                <!-- @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.dropdown-field class="col-xl-4 mb-3" label="orole" name="orole"
                                        :options="['0' => '0', '1' => '1', '2' => '2']"
                                        :selected="old('orole', $mode == 'edit' ? ($user->orole ?? '') : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="orole">orole</label>
                                        <p class="form-control">{{ $user->orole }}</p>
                                    </div>
                                @endif -->

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Pincode" name="pincode"
                                        type="text" :value="old('pincode', $mode == 'edit' ? $user->pincode : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="pincode">Pincode</label>
                                        <p class="form-control">{{ $user->pincode }}</p>
                                    </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                    <x-inputs.input-field class="col-xl-4 mb-3" label="Redirect Option" name="redirect_option"
                                        type="text" :value="old('redirect_option', $mode == 'edit' ? $user->redirect_option : '')" />
                                @else
                                    <div class="col-xl-4 mb-3">
                                        <label class="form-label mt-0" for="redirect_option">Redirect Option</label>
                                        <p class="form-control">{{ $user->redirect_option }}</p>
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
