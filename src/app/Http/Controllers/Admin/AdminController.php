<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $owners = User::where('role', 'owner')->with('shop')->get();
        // $ownerCount = \App\Models\Owner::count();
        $userCount = \App\Models\User::count();

        return view('admin.index', compact('userCount', 'owners'));
    }
}