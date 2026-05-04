<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // READ (List only the user's wallets)
    public function index()
    {
        // Load wallets with their latest 10 transactions and the category for each
        $wallets = Auth::user()->wallets()
            ->with(['transactions' => function($query) {
                $query->latest()->limit(10); // Limit to 10 for performance
            }, 'transactions.category'])
            ->get();

        return view('wallets.index', compact('wallets'));
    }

    // CREATE (Show form)
    public function create()
    {
        return view('wallets.create');
    }

    // CREATE (Save to DB)
    public function store(Request $request)
    {
        $request->validate([
            'wallet_name' => 'required|string|max:255',
            'current_balance' => 'required|numeric|min:0',
        ]);

        Wallet::create([
            'user_id' => Auth::id(),
            'wallet_name' => $request->wallet_name,
            'current_balance' => $request->current_balance,
        ]);

        return redirect()->route('wallets.index')->with('success', 'New wallet created!');
    }

    // UPDATE (Show Form)
    public function edit(Wallet $wallet)
    {
        // Security Check
        if ($wallet->user_id !== Auth::id()) abort(403);

        return view('wallets.edit', compact('wallet'));
    }

    // UPDATE (Save changes)
    public function update(Request $request, Wallet $wallet)
    {
        // Security Check
        if ($wallet->user_id !== Auth::id()) abort(403);

        $request->validate([
            'wallet_name' => 'required|string|max:255',
            'current_balance' => 'required|numeric|min:0',
        ]);

        $wallet->update($request->all());

        return redirect()->route('wallets.index')->with('success', 'Wallet updated successfully!');
    }

    // DELETE
    public function destroy(Wallet $wallet)
    {
        // Security Check
        if ($wallet->user_id !== Auth::id()) abort(403);

        // Optional: You might want to delete all transactions associated with this wallet first
        // $wallet->transactions()->delete();

        $wallet->delete();

        return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully!');
    }
}