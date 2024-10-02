<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


use App\Models\User;

class userController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(5);

        return view('admin.users', compact('users'));
    }
    public function profileUser()
    {
        return view('users.profile');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'gender' => 'nullable|string|max:255',
             // Validation rule for the new attribute
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->gender = $request->get('gender'); // Handle the new attribute
        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
