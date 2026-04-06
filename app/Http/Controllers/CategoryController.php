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
        if (!Auth::user()->isAdmin()) abort(403);
        $request->validate(['name' => 'required|string|max:255|unique:categories']);
        Category::create($request->all());
        return back()->with('success', 'Category added successfully.');
    }

    public function destroy(Category $category)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}