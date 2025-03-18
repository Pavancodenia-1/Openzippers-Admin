<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class transactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('admin.transaction.index', compact('transactions'));
    }

    // CREATE PAGE FOR A SPECIFIC USER 
    public function create()
    {
        $mode = 'create';
        return view('admin.transaction.edit', compact('mode'));
    }

    // FIND A SPECIFIC USER AND SHOW THE EDIT FORM

    public function edit($id)
    {
        $transactions = Transaction::findOrFail($id);

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot edit users of equal or higher rank');
        }

        $mode = 'edit';
        return view('admin.transaction.edit', compact('mode', 'transactions'));
    }

    // VIEW A SPECIFIC USER
    public function view($id)
    {
        $transactions = Transaction::findOrFail($id);
        $mode = 'view';
        return view('admin.transaction.edit', compact('mode', 'transactions'));
    }

    // VALIDATE AND STORE A NEW USER
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'price' => 'required|double',
            'title' => 'nullable',
            'text' => 'nullable',
            'status' => 'required|in:0,1',
            'type' => 'nullable',
            'is_certified' => 'required',
            'is_publish' => 'nullable',

        ]);

        $transaction = new Transaction();
        $transaction->name = $request->name;
        $transaction->username = $request->username;

        $transaction->save();

        return redirect()->route('admin.transaction.index')->with('success', 'User registered successfully!');
    }

    // UPDATE A USER'S DETAILS
    public function update(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);

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

        $transaction->update([
            'price' => $request->price,
            'title' => $request->title,
            'text' => $request->text,
            'status' => $request->status,
            'type' => $request->type,
            'is_certified' => $request->is_certified,
            'is_publish' => $request->is_publish,
        ]);

        return redirect()->route('admin.transaction.index')->with('success', 'User updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }

        $transaction->delete();

        return redirect()->route('admin.transaction.index')->with('success', 'User deleted successfully!');
    }
}
