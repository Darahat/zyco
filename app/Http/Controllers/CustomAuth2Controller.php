<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CustomAuth2Controller extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
}
