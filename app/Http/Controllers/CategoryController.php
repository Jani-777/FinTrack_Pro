<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) abort(403, 'Admins only.');
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Change 'name' to 'category_name' here
            'category_name' => 'required|string|max:255|unique:categories,category_name',
            'type' => 'required|string', // Income or Expense
        ]);

        \App\Models\Category::create([
            // Ensure the key matches your database column exactly
            'category_name' => $request->category_name,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|in:Income,Expense',
        ]);

        $category->update($request->all());

        return back()->with('success', 'Category updated successfully!');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}