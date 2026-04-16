<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = auth()->user()->budgets()->with('category')->get();
        $categories = \App\Models\Category::all();
        return view('budgets.index', compact('budgets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'amount_limit' => 'required|numeric|min:1',
        ]);

        \App\Models\Budget::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'amount_limit' => $request->amount_limit,
            'month_year' => now()->startOfMonth(), // Sets budget for current month
        ]);

        return back()->with('success', 'Monthly budget set!');
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);
        
        $categories = \App\Models\Category::all();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);

        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'amount_limit' => 'required|numeric|min:0',
        ]);

        $budget->update($request->only(['category_id', 'amount_limit']));

        return redirect()->route('budgets.index')->with('success', 'Budget updated!');
    }

    public function destroy(\App\Models\Budget $budget)
    {
        // Security check
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget removed!');
    }
}
