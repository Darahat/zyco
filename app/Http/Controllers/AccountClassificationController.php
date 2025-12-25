<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AccountClassificationController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();

        $this->middleware(function ($request, $next) {
            if (!Auth::guard('admin')->check()) {
                return redirect()
                    ->route('adminLoginForm')
                    ->with([
                        'status' => 'You are not allowed to access',
                        'alert-type' => 'error'
                    ]);
            }
            return $next($request);
        });
    }

    /**
     * List all packages
     */
    public function index()
    {
        $result = DB::table('account_classification_package')
            ->orderByDesc('id')
            ->get();

        return view('backend.account_classification_package.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Account Classification Package',
            'result'      => $result,
        ]);
    }

    /**
     * Create package (GET + POST)
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('backend.account_classification_package.add', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin',
                'page_header' => 'Add New Account Classification Package',
            ]);
        }

        $validated = $request->validate([
            'classification_name' => 'required|unique:account_classification_package,classification_name',
            'price'               => 'required|numeric|min:0',
            'features'            => 'nullable|string',
        ]);

        DB::table('account_classification_package')->insert([
            'classification_name' => $validated['classification_name'],
            'price'               => $validated['price'],
            'features'            => $validated['features'] ?? null,
            'created_at'          => Carbon::now(),
        ]);

        return redirect()
            ->route('admin.account_classification_package.index')
            ->with([
                'status' => 'Account classification package created successfully',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Update package (GET + POST)
     */
    public function update(Request $request)
    {
        $package = DB::table('account_classification_package')->find($request->id);

        if (!$package) {
            return redirect()->back()->with([
                'status' => 'Package not found',
                'alert-type' => 'error'
            ]);
        }

        if ($request->isMethod('get')) {
            return view('backend.account_classification_package.edit', [
                'page_title'  => $this->page_title,
                'page_header' => 'Update Account Classification Package',
                'result'      => $package,
            ]);
        }

        $validated = $request->validate([
            'classification_name' => 'required|unique:account_classification_package,classification_name,' . $package->id,
            'price'               => 'required|numeric|min:0',
            'features'            => 'nullable|string',
        ]);

        DB::table('account_classification_package')
            ->where('id', $package->id)
            ->update([
                'classification_name' => $validated['classification_name'],
                'price'               => $validated['price'],
                'features'            => $validated['features'] ?? null,
                'updated_at'          => Carbon::now(),
            ]);

        return redirect()->back()->with([
            'status' => 'Data updated successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Delete package
     */
    public function delete(Request $request)
    {
        $package = DB::table('account_classification_package')->find($request->id);

        if (!$package) {
            return redirect()->back()->with([
                'status' => 'Package not found',
                'alert-type' => 'error'
            ]);
        }

        $isUsed = DB::table('users_personalinfo')
            ->where('account_classification', $package->classification_name)
            ->exists();

        if ($isUsed) {
            return redirect()->back()->with([
                'status' => 'This package is already assigned to users and cannot be deleted',
                'alert-type' => 'error'
            ]);
        }

        DB::table('account_classification_package')->where('id', $package->id)->delete();

        return redirect()->back()->with([
            'status' => 'Account classification package deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}