<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $budgets = $user->budgets()->with('category')->get();
        
        $categories = \App\Models\Category::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get();

        foreach ($budgets as $budget) {
            $budget->total_spent = Transaction::where('user_id', $user->id)
                ->where('category_id', $budget->category_id)
                ->whereMonth('transaction_date', \Carbon\Carbon::parse($budget->month_year)->month)
                ->whereYear('transaction_date', \Carbon\Carbon::parse($budget->month_year)->year)
                ->sum('amount');
        }

        return view('budgets.index', compact('budgets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'amount_limit' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255', // Added
        ]);

        \App\Models\Budget::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'amount_limit' => $request->amount_limit,
            'description' => $request->description, // Added
            'month_year' => now()->startOfMonth(),
        ]);

        return back()->with('success', 'Monthly budget set!');
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);
        
        $categories = \App\Models\Category::whereNull('user_id')
            ->orWhere('user_id', auth()->id())
            ->get();
            
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);

        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'amount_limit' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255', // Added
        ]);

        $budget->update($request->only(['category_id', 'amount_limit', 'description']));

        return redirect()->route('budgets.index')->with('success', 'Budget updated!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget removed!');
    }
}