<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the form to upgrade a user to an expert.
     */
    public function verifyExpert($userId) {
        $user = User::findOrFail($userId);
        $user->role = 'expert';
        $user->save();

        return redirect()->route('admin.users');
    }

    // Show all users
    public function showUsers() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
}