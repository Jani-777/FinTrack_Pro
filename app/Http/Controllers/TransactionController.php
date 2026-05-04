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
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            abort(403, 'Admins cannot view private transaction data.');
        }

        $query = Transaction::where('user_id', $user->id)
            ->with(['wallet', 'category']);

        if ($request->filled('wallet_id')) {
            $query->where('wallet_id', $request->wallet_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        $transactions = $query->latest()->get();
        $wallets = $user->wallets;
        $categories = Category::whereNull('user_id')->orWhere('user_id', $user->id)->get();
        
        return view('transactions.index', compact('transactions', 'wallets', 'categories'));
    }

    public function create()
    {
        $user = auth()->user();
        $wallets = $user->wallets;
        $categories = Category::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get();

        return view('transactions.create', compact('wallets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,wallet_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::find($request->wallet_id);
        $category = Category::find($request->category_id);

        // --- ERROR TRAPPING: Check for insufficient balance ---
        if (strtolower($category->type) === 'expense' && $request->amount > $wallet->current_balance) {
            return back()
                ->withInput()
                ->withErrors(['amount' => "Insufficient funds! Your current balance in '{$wallet->wallet_name}' is ₱" . number_format($wallet->current_balance, 2)]);
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $transaction = Transaction::create($data);

        if (strtolower($category->type) === 'income') {
            $wallet->increment('current_balance', $request->amount);
        } else {
            $wallet->decrement('current_balance', $request->amount);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded!');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);
        
        $user = auth()->user();
        $wallets = $user->wallets;
        $categories = Category::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get();
        
        return view('transactions.edit', compact('transaction', 'categories', 'wallets'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $request->validate([
            'wallet_id' => 'required|exists:wallets,wallet_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0.01', // Blocks negative and zero
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        // REVERSE old balance impact
        $oldWallet = $transaction->wallet;
        $oldCategory = $transaction->category;
        if (strtolower($oldCategory->type) === 'income') {
            $oldWallet->decrement('current_balance', $transaction->amount);
        } else {
            $oldWallet->increment('current_balance', $transaction->amount);
        }

        // Update Transaction
        $transaction->update($request->all());

        // APPLY new balance impact
        $newWallet = Wallet::find($request->wallet_id);
        $newCategory = Category::find($request->category_id);
        if (strtolower($newCategory->type) === 'income') {
            $newWallet->increment('current_balance', $request->amount);
        } else {
            $newWallet->decrement('current_balance', $request->amount);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $wallet = $transaction->wallet;
        $category = $transaction->category;

        if (strtolower($category->type) === 'income') {
            $wallet->decrement('current_balance', $transaction->amount);
        } else {
            $wallet->increment('current_balance', $transaction->amount);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }
}