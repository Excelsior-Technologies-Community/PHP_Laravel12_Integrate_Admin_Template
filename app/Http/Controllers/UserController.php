<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Dashboard page
    public function dashboard()
    {
        return view('dashboard');
    }

    // Users list page
    public function users()
    {
        $users = User::latest()->get(); // Fetch users
        return view('users', compact('users'));
    }
}
