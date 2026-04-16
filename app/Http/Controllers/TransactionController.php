<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // READ (List)
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            abort(403, 'Admins cannot view private transaction data.');
        }

        // Get transactions through the user's wallets
        $transactions = Transaction::whereIn('wallet_id', $user->wallets->pluck('wallet_id'))
            ->with(['wallet', 'category'])
            ->latest()
            ->get();
        
        return view('transactions.index', compact('transactions'));
    }

    // CREATE (Show Form)
    public function create()
    {
        $user = auth()->user();
        $wallets = $user->wallets;
        $categories = Category::all();

        return view('transactions.create', compact('wallets', 'categories'));
    }

    // CREATE (Save to DB)
    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,wallet_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        // 1. Create the transaction
        $transaction = Transaction::create($request->all());

        // 2. Update Wallet Balance 
        $wallet = Wallet::find($request->wallet_id);
        $category = Category::find($request->category_id);

        if (strtolower($category->type) === 'income') {
            $wallet->increment('current_balance', $request->amount);
        } else {
            $wallet->decrement('current_balance', $request->amount);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded and wallet updated!');
    }

    // UPDATE (Show Form)
    public function edit(Transaction $transaction)
    {
        // Security: Ensure user owns the wallet associated with this transaction
        if ($transaction->wallet->user_id !== Auth::id()) abort(403);
        
        $user = auth()->user();
        $wallets = $user->wallets;
        $categories = Category::all();
        
        return view('transactions.edit', compact('transaction', 'categories', 'wallets'));
    }

    // UPDATE (Save to DB)
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->wallet->user_id !== Auth::id()) abort(403);

        $request->validate([
            'wallet_id' => 'required|exists:wallets,wallet_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        // 1. REVERSE old balance impact
        $oldWallet = $transaction->wallet;
        $oldCategory = $transaction->category;
        if (strtolower($oldCategory->type) === 'income') {
            $oldWallet->decrement('current_balance', $transaction->amount);
        } else {
            $oldWallet->increment('current_balance', $transaction->amount);
        }

        // 2. Update Transaction
        $transaction->update($request->all());

        // 3. APPLY new balance impact
        $newWallet = Wallet::find($request->wallet_id);
        $newCategory = Category::find($request->category_id);
        if (strtolower($newCategory->type) === 'income') {
            $newWallet->increment('current_balance', $request->amount);
        } else {
            $newWallet->decrement('current_balance', $request->amount);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated and balance adjusted!');
    }

    // DELETE
    public function destroy(Transaction $transaction)
    {
        if ($transaction->wallet->user_id !== Auth::id()) abort(403);

        // Reverse the impact on the wallet balance before deleting
        $wallet = $transaction->wallet;
        $category = $transaction->category;

        if (strtolower($category->type) === 'income') {
            $wallet->decrement('current_balance', $transaction->amount);
        } else {
            $wallet->increment('current_balance', $transaction->amount);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted and balance restored!');
    }
}