<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Helpers\FileUploader;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::all();
        $posts = DB::table('posts')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')  // Assuming 'posts.user_id' is the foreign key
        ->select('users.username','users.name', 'posts.*')
        ->get();

        return view('admin.posts.index', compact('posts'));
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
        $user = Post::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot edit users of equal or higher rank');
        }
        
        $mode = 'edit';
        return view('admin.posts.edit', compact('mode', 'user'));
    }

    // VIEW A SPECIFIC USER
    public function view($id)
    {
        $user = Post::findOrFail($id);
        $mode = 'view';
        return view('admin.posts.edit', compact('mode', 'user'));
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

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;


        
        if ($request->hasFile('avatar')) {
            $user->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar');
        }
    
        
        $user->fill($request->except([
            'password', 'password_confirmation', 'avatar'
        ]));
        

        $user->save();

        return redirect()->route('admin.posts.index')->with('success', 'User registered successfully!');
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

        return redirect()->route('admin.posts.index')->with('success', 'User updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }
        
        $user->delete();

        return redirect()->route('admin.posts.index')->with('success', 'User deleted successfully!');
    }

    public function show($id){
        // $post = Post::findOrFail($id);
        $posts = DB::table('posts')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')  // Assuming 'posts.user_id' is the foreign key
        ->select('users.username','users.name', 'posts.*')
        ->where('posts.user_id', $id)
        ->get();
        return view('admin.posts.index', compact('posts'));
    }

}
