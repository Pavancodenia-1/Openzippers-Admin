<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = WalletHistory::with(['user', 'admin'])->orderBy('updated_at', 'desc')->get();
        return view('admin.wallet.index', compact('wallets'));
    }

    public function addBalenceForm()
    {
        $users = User::all();
        return view('admin.wallet.addBalence', compact('users'));
    }

    public function addBalence(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $user = User::findOrFail($validated['user_id']);
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['total' => 0]
            );

            $balanceBefore = $wallet->total ?? 0;

            $wallet->total += $validated['amount'];
            $wallet->save();


            WalletHistory::create([
                'user_id' => $user->id,
                'admin_id' => Auth::guard('admin')->id(),
                'wallet_id' => $wallet->id,
                'amount' => $validated['amount'],
                'balance_before' => $balanceBefore,
            ]);

            return redirect()
                ->route('admin.wallet.index')
                ->with('success', 'Balance added successfully!');
        } catch (\Exception $e) {
            Log::error('Wallet balance update failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to add balance. Please try again.');
        }
    }


    // DELETE A USER
    // public function destroy($id)
    // {
    //     $wallet = Wallet::findOrFail($id);

    //     if ((int)Auth::guard('admin')->user()->user_role > 1) {
    //         abort(403, 'You cannot delete users of equal or higher rank');
    //     }

    //     $wallet->delete();

    //     return redirect()->route('admin.wallet.index')->with('success', 'wallet deleted successfully!');
    // }
}
