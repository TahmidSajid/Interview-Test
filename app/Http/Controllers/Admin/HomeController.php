<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $users = User::withCount('tasks')->get();

        return view('admin.pages.home',compact('users'));
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return back();
    }
}
