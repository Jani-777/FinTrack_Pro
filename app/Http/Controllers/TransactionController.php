<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // READ (List)
    public function index()
    {
        $user = Auth::user();
        
        // RBAC: Admin sees all, User sees only theirs
        if ($user->isAdmin()) {
            $transactions = Transaction::with('user')->latest()->get();
        } else {
            $transactions = Transaction::where('user_id', $user->id)->latest()->get();
        }

        return view('transactions.index', compact('transactions'));
    }

    // CREATE (Show Form)
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('transactions.create', compact('categories'));
    }

    // CREATE (Save to DB)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|string',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'type' => $request->type,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Record added successfully.');
    }

    // UPDATE (Show Form)
    public function edit(Transaction $transaction)
    {
        if (!Auth::user()->isAdmin() && $transaction->user_id !== Auth::id()) abort(403);
        $categories = \App\Models\Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    // UPDATE (Save to DB)
    public function update(Request $request, Transaction $transaction)
    {
        if (!Auth::user()->isAdmin() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

       $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|string',
        ]);

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaction updated.');
    }

    // DELETE
    public function destroy(Transaction $transaction)
    {
        if (!Auth::user()->isAdmin() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted.');
    }
}