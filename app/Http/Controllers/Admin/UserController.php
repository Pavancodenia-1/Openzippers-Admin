<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // RETRIEVE ALL USERS AND DISPLAY THEM IN A VIEW
    public function index()
    {
        // $users = User::all();
        // $users = DB::table('users')
        //     ->leftjoin('posts', 'users.id', '=', 'posts.user_id')
        //     ->select('users.*', DB::raw('(SELECT COUNT(*) FROM posts WHERE posts.user_id = users.id) as posts_count'))
        //     ->groupBy('users.id')
        //     ->get();

        $users = User::withCount('posts')->get(); // added a post function for this in user model

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
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
            'role_id' => 'required|in:0,1,2',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
            'username' => 'required|string|unique:users,username',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:17',
            'gender' => 'required|in:0,1,2',
            'referral_code' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'public_profile' => 'required|in:0,1',
            'open_profile' => 'required|in:0,1',
            'paid_profile' => 'required|in:0,1',
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
            'plan_id' => 'required|integer',
            'purchased_plan_date' => 'required|date',
            'dob' => 'required|date',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
            'address' => 'nullable|string|max:255',
            'billing_detail' => 'nullable|string|max:255',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            // 'orole' => 'required|in:0,1,2',
            'pincode' => 'required|digits:6',
            'redirect_option' => 'nullable|string|max:10',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->status = (int) $request->status;
        $user->mobile = $request->mobile;
        $user->gender = $request->gender;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;
        $user->pincode = $request->pincode;
        $user->billing_address = $request->billing_address;
        $user->dob = $request->dob;
        $user->plan_id = $request->plan_id;
        $user->purchased_plan_date = $request->purchased_plan_date;
        $user->address = $request->address;
        $user->billing_detail = $request->billing_detail;



        if ($request->hasFile('avatar')) {
            $user->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar');
        }

        // if ($request->hasFile('image')) {
        //     $user->image = FileUploader::uploadFile($request->file('image'), 'images/admin-user_images');
        // }

        $user->fill($request->except([
            'password',
            'password_confirmation',
            'avatar'
        ]));


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
            'role_id' => 'required|in:0,1,2',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
            'password' => 'nullable|min:4|confirmed',
            'password_confirmation' => 'nullable|min:4',
            'username' => 'required|string|unique:users,username,' . $request->id,
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:17',
            'gender' => 'required|in:0,1,2',
            'referral_code' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'public_profile' => 'required|in:0,1',
            'open_profile' => 'required|in:0,1',
            'paid_profile' => 'required|in:0,1',
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
            'postcode' => 'nullable',
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
            'plan_id' => 'required|integer',
            'purchased_plan_date' => 'nullable|date',
            'dob' => 'required|date',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
            'address' => 'nullable|string|max:255',
            'billing_detail' => 'nullable|string|max:255',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            // 'orole' => 'required|in:0,1,2',
            'pincode' => 'required',
            'redirect_option' => 'nullable|string|max:10',

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update($request->except(['password', 'avatar']));

        if ($request->hasFile('avatar')) {
            $user->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar', $user->avatar);
        }

        // if ($request->hasFile('image')) {
        //     $user->image = FileUploader::uploadFile($request->file('image'), 'images/admin-user_images',$user->image);
        // }

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
