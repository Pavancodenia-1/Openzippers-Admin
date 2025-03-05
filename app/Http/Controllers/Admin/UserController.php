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
        
        if ((int)Auth::user()->user_role >= (int)$user->user_role) {
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
            'role' => 'required|in:1,2,3',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_role = $request->role;

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
        
        if ((int)Auth::user()->user_role >= (int)$user->user_role) {
            abort(403, 'You cannot update users of equal or higher rank');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|in:1,2,3',
            'avatar' => 'mimes:png,jpg,jpeg,webp,svg,gif',
            'password' => 'nullable|min:4|confirmed',
            'password_confirmation' => 'nullable|min:4',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_role = $request->role;

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
        
        if ((int)Auth::user()->user_role >= (int)$user->user_role) {
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
            'status' => 'required|in:active,blocked',
        ]);

        $user = User::findOrFail($request->id);
        
        if ((int)Auth::user()->user_role >= (int)$user->user_role) {
            return response()->json(['warning' => 'You cannot change status of users with equal or higher rank']);
        }

        $user->update(['status' => $request->status]);
        return response()->json(['message' => 'User status updated successfully']);
    }
}
