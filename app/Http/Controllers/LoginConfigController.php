<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginConfigController extends Controller
{
    protected string $page_title = 'Admin Panel';

    /**
     * Show all login configurations
     */
    public function index()
    {
        $this->authorizeAdmin();

        $result = DB::table('login_config')->get();

        return view('admin.loginConfig.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin_settings',
            'page_header' => 'Login Configurations',
        ], compact('result'));
    }

    /**
     * Add a new login configuration
     */
    public function add(Request $request)
    {
        $this->authorizeAdmin();

        if ($request->isMethod('get')) {
            return view('admin.loginConfig.add', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin_settings',
                'page_header' => 'Add New Login Configuration',
            ]);
        }

        // Validate input
        $request->validate([
            'login_name'  => 'required|unique:login_config,login_name',
            'login_value' => 'required|unique:login_config,login_value',
            'status'      => 'required|in:Active,Inactive',
        ]);

        // Insert data
        DB::table('login_config')->insert([
            'login_name'  => $request->login_name,
            'login_value' => $request->login_value,
            'status'      => $request->status,
        ]);

        return redirect('admin/login-config')->with([
            'status'     => 'Login configuration saved successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Admin authorization helper
     */
    private function authorizeAdmin(): void
    {
        abort_if(!Auth::guard('admin')->check(), 403, 'You are not allowed to access this page.');
    }
}