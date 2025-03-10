<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // RETRIEVE ALL USERS AND DISPLAY THEM IN A VIEW
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    // CREATE PAGE FOR A SPECIFIC USER 
    public function create()
    {
        $mode = 'create';
        return view('admin.user.edit', compact('mode'));
    }

    // FIND A SPECIFIC USER AND SHOW THE EDIT FORM
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot edit users of equal or higher rank');
        }
        
        $mode = 'edit';
        return view('admin.user.edit', compact('mode', 'user'));
    }

    // VIEW A SPECIFIC USER
    public function view($id)
    {
        $user = User::findOrFail($id);
        $mode = 'view';
        return view('admin.user.edit', compact('mode', 'user'));
    }

    // VALIDATE AND STORE A NEW USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
            'role' => 'required|in:0,1,2',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'gender' => 'required|in:0,1,2',
            'referral_code' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'public_profile' => 'nullable|string|max:255',
            'open_profile' => 'nullable|string|max:255',
            'paid_profile' => 'nullable|string|max:255',
            'profile_access_price' => 'nullable|numeric|min:0',
            'billing_address' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'profile_access_price_3_months' => 'nullable|numeric|min:0',
            'profile_access_price_6_months' => 'nullable|numeric|min:0',
            'profile_access_price_12_months' => 'nullable|numeric|min:0',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postcode' => 'nullable|regex:/^\d{5}$/',
            'email_verified_at' => 'nullable|date',
            'block_video_call' => 'nullable|boolean',
            'block_audio_call' => 'nullable|boolean',
            'block_message' => 'nullable|boolean',
            'birthdate' => 'nullable|date|before:today',
            'identity_verified_at' => 'nullable|date|before:today',
            'fcm_token' => 'nullable|string|max:255',
            'auth_provider' => 'nullable|string|max:50',
            'auth_provider_id' => 'nullable|string|max:255',
            'enable_2fa' => 'nullable|boolean',
            'enable_geoblocking' => 'nullable|boolean',
            'enable_blur' => 'nullable|boolean',
            'audio_download_list' => 'nullable|string|max:255',
            'artist_verify_status' => 'nullable|boolean',
            'accept_term_and_policy' => 'nullable|boolean',

            'plan_id' => 'required|integer|exists:plans,id',
            'purchased_plan_date' => 'required|date',
            'Dob' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string',
            'address' => 'nullable|string|max:255',
            'billing_detail' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'orole' => 'nullable|string|max:255',
            'pincode' => 'required|digits:6',
            'redirect_option' => 'nullable|string|max:255',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;

        if ($request->hasFile('avatar')) {
            $user->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar');
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User registered successfully!');
    }

    // UPDATE A USER'S DETAILS
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        // dd($request->all());
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot update users');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|in:0,1,2',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
            'password' => 'nullable|min:4|confirmed',
            'password_confirmation' => 'nullable|min:4',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar', $user->avatar);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    // UPDATE USER'S STATUS (ACTIVE OR BLOCKED)
    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'status' => 'required|in:1,0',
        ]);


        $user = User::findOrFail($request->id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            return response()->json(['warning' => 'You cannot change status of users with equal or higher rank']);
        }

        $user->update(['status' => $request->status]);
        return response()->json(['message' => 'User status updated successfully']);
    }
}
