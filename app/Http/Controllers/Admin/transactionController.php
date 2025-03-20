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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'price' => 'required|double',
    //         'title' => 'nullable',
    //         'text' => 'nullable',
    //         'status' => 'required|in:0,1',
    //         'type' => 'nullable',
    //         'is_certified' => 'required',
    //         'is_publish' => 'nullable',

    //     ]);

    //     $transaction = new Transaction();
    //     $transaction->name = $request->name;
    //     $transaction->username = $request->username;

    //     $transaction->save();

    //     return redirect()->route('admin.transaction.index')->with('success', 'Transaction registered successfully!');
    // }


    // UPDATE A USER'S DETAILS
    public function update(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);

        // dd($request->all());

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot update users');
        }

        $validated = $request->validate([
            'subscription_id' => 'nullable|string|max:255',
            'post_id' => 'nullable|integer',
            'stripe_transaction_id' => 'nullable|string|max:255',
            'invoice_id' => 'nullable|string|max:255',
            'stream_id' => 'nullable|string|max:255',
            'message_id' => 'nullable|string|max:255',
            'unlock_type' => 'nullable|string|max:255',
            'status' => 'required|string|in:approved,canceled,declined,initiated',
            'video_call_id' => 'nullable|string|max:255',
            'audio_call_id' => 'nullable|string|max:255',
            'type' => 'required|string|in:deposite,message-unlock,one-month-subscription,stream-access,post-unlock,tip,withdrawal',
            'chat_id' => 'nullable|string|max:255',
            'payment_provider' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'nowpayments_payment_id' => 'nullable|string|max:255',
            'nowpayments_order_id' => 'nullable|string|max:255',
            'created_at' => 'nullable|date',
            'ccbill_payment_token' => 'nullable|string|max:255',
            'ccbill_transaction_id' => 'nullable|string|max:255',
            'ccbill_subscription_id' => 'nullable|string|max:255',
            'paystack_payment_token' => 'nullable|string|max:255',
        ]);


        $transaction->update($validated);

        return redirect()->route('admin.transaction.index')->with('success', 'Transaction updated successfully!');
    }

    // DELETE A USER
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ((int)Auth::guard('admin')->user()->user_role > 1) {
            abort(403, 'You cannot delete users of equal or higher rank');
        }

        $transaction->delete();

        return redirect()->route('admin.transaction.index')->with('success', 'Transaction deleted successfully!');
    }
}
