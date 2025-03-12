<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use App\Helpers\FileUploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::all();
        $mode = 'Manage Posts';
        $posts = DB::table('posts')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')  // Assuming 'posts.user_id' is the foreign key
        ->leftjoin('attachments', 'attachments.post_id', '=', 'posts.id')
        ->select('users.username','users.name','users.avatar', 'posts.*','attachments.filename','attachments.wfilename','attachments.type','attachments.id as attachment_id','attachments.user_id as attachment_user_id','attachments.post_id as attachment_post_id','attachments.message_id as attachment_message_id','attachments.payment_request_id as attachment_payment_request_id','attachments.mtype as attachment_mtype','attachments.attachmentscol as attachment_attachmentscol')
        ->get();

        return view('admin.posts.index', compact('mode','posts'));
    }

    // CREATE PAGE FOR A SPECIFIC USER 
    public function create()
    {
        $mode = 'create';
        return view('admin.posts.edit', compact('mode'));
    }

    // FIND A SPECIFIC USER AND SHOW THE EDIT FORM

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot edit users of equal or higher rank');
        }
        
        $mode = 'edit';
        return view('admin.posts.edit', compact('mode', 'post'));
    }

    // VIEW A SPECIFIC USER
    public function view($id)
    {
        // $post = Post::findOrFail($id);
        $post = DB::table('posts')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')
        ->leftjoin('attachments', 'attachments.post_id', '=', 'posts.id')
        ->select('users.username','users.name','posts.*','attachments.filename','attachments.wfilename','attachments.type','attachments.id as attachment_id','attachments.user_id as attachment_user_id','attachments.post_id as attachment_post_id','attachments.type as attachment_type')
        ->where('posts.id', $id)
        ->get();

        // $post = DB::table('posts')
        // ->leftJoin('users', 'users.id', '=', 'posts.user_id')
        // ->leftJoin('attachments', 'attachments.post_id', '=', 'posts.id')
        // ->select(
        //     'users.username',
        //     'users.name',
        //     'posts.*'
        // )
        // ->where('posts.id', $id)
        // ->groupBy('posts.id', 'users.username', 'users.name') // Grouping to avoid duplicate rows
        // ->get()
        // ->map(function ($post) {
        //     // Fetch attachments separately and attach them as an array
        //     $post->attachments = DB::table('attachments')
        //         ->where('post_id', $post->id)
        //         ->select('id', 'filename', 'wfilename', 'type', 'user_id as attachment_user_id', 'post_id as attachment_post_id')
        //         ->get();
        //     return $post;
        // });

        $mode = 'view';
        return view('admin.posts.edit', compact('mode', 'post'));
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

        $post = new Post();
        $post->name = $request->name;
        $post->username = $request->username;

        if ($request->hasFile('avatar')) {
            $post->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar');
        }
    
        
        $post->fill($request->except([
            'password', 'password_confirmation', 'avatar'
        ]));
        

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'User registered successfully!');
    }

    // UPDATE A USER'S DETAILS
    public function update(Request $request)
    {
        $post = Post::findOrFail($request->id);

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

        $post->name = $request->name;
        $post->email = $request->email;
        $post->role_id = $request->role_id;

        if ($request->filled('password')) {
            $post->password = Hash::make($request->password);
        }

        $post->update($request->except(['password', 'avatar']));

        if ($request->hasFile('avatar')) {
            $post->avatar = FileUploader::uploadFile($request->file('avatar'), 'images/admin-avatar', $post->avatar);
        }


        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'User updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'User deleted successfully!');
    }

    public function show($id){
        // $post = Post::findOrFail($id);

        $posts = DB::table('posts')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')  // Assuming 'posts.user_id' is the foreign key
        ->select('users.username','users.name', 'posts.*')
        ->where('posts.user_id', $id)
        ->get();

        $mode = $posts[0]->name . ' Posts';

        return view('admin.posts.index', compact('mode','posts'));
    }

}
