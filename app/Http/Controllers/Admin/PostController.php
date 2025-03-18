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
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            // ->leftjoin('attachments', 'attachments.post_id', '=', 'posts.id')
            ->select('users.username', 'users.name', 'users.avatar', 'posts.*')
            ->get();

        return view('admin.posts.index', compact('mode', 'posts'));
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
        $post = DB::table('posts')
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('attachments', 'attachments.post_id', '=', 'posts.id')
            ->select(
                'users.username',
                'users.name',
                'posts.*'
            )
            ->where('posts.id', $id)
            ->first(); // Use first() instead of get() to fetch a single record

        if ($post) {
            // Fetch attachments separately and attach them as an array
            $post->attachments = DB::table('attachments')
                ->where('post_id', $post->id)
                ->select('id', 'filename', 'wfilename', 'type', 'user_id as attachment_user_id', 'post_id as attachment_post_id')
                ->get();
        }

        $mode = 'view';
        return view('admin.posts.edit', compact('mode', 'post'));
    }

    // VALIDATE AND STORE A NEW USER
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'price' => 'required|double',
    //         'title' => 'nullable',
    //         'text' => 'nullable',
    //         'status' => 'required|in:0,1',
    //         'type' => 'nullable',
    //         'is_certified' => 'required',
    //         'is_publish' => 'nullable',

    //     ]);

    //     $post = new Post();
    //     $post->name = $request->name;
    //     $post->username = $request->username;

    //     $post->save();

    //     return redirect()->route('admin.posts.index')->with('success', 'Post registered successfully!');
    // }

    // UPDATE A USER'S DETAILS
    public function update(Request $request)
    {
        $post = Post::findOrFail($request->id);

        // dd($request->all());

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot update users');
        }

        $request->validate([
            'price' => 'required|numeric',
            'title' => 'nullable|string',
            'text' => 'nullable|string',
            'status' => 'required|in:0,1',
            'type' => 'required|in:post,literature,video,audio',
            'is_certified' => 'required|in:yes,no',
            'is_publish' => 'nullable|in:yes,no',
        ]);

        $post->update([
            'price' => $request->price,
            'title' => $request->title,
            'text' => $request->text,
            'status' => $request->status,
            'type' => $request->type,
            'is_certified' => $request->is_certified,
            'is_publish' => $request->is_publish,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }

    public function show($id)
    {
        // $post = Post::findOrFail($id);

        $posts = DB::table('posts')
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')  // Assuming 'posts.user_id' is the foreign key
            ->select('users.username', 'users.name', 'users.avatar', 'posts.*')
            ->where('posts.user_id', $id)
            ->get();

        $mode = $posts[0]->name . ' Posts';

        return view('admin.posts.index', compact('mode', 'posts'));
    }
}
