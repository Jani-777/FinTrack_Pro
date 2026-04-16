<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users for the Admin
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
        abort(403); // Only Admins should see the User Management list
        }
        $users = \App\Models\User::all();
        return view('admin.users.index', compact('users'));
    }

    // The Toggle Logic
    public function toggleStatus(User $user)
    {
        // Flip the boolean: if 1 it becomes 0, if 0 it becomes 1
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User account has been {$status}.");
    }
}