<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // Show categories where user_id is NULL (System) OR user_id is the logged-in user
        $categories = Category::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->latest()
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'type' => $request->type,
            'user_id' => Auth::user()->isAdmin() ? null : Auth::id(), // Admin makes system cats, User makes personal
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        // Security Check: Users can only edit their own categories. Admins can edit anything.
        if (!Auth::user()->isAdmin() && $category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|in:Income,Expense',
        ]);

        $category->update($request->all());
        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Security Check: Prevent users from deleting system categories or other people's categories
        if (!Auth::user()->isAdmin() && $category->user_id !== Auth::id()) {
            abort(403);
        }

        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}