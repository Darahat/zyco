<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AccountUpgradationController extends Controller
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
                        'alert-type' => 'error',
                    ]);
            }
            return $next($request);
        })->except(['upgrade_profile_packages']);
    }

    /**
     * Admin: List account upgradation applications
     */
    public function index()
    {
        $result = DB::table('users_personalinfo')
            ->whereColumn('account_classification', '!=', 'application_for_account_upgrade')
            ->orderByDesc('id')
            ->get();

        $package_name = DB::table('account_classification_package')
            ->where('status', 'Active')
            ->orderByDesc('id')
            ->get();

        return view('backend.account_upgradation_application.index', [
            'page_title'  => $this->page_title,
            'page_header' => 'Account Upgradation Applications',
            'main_menu'   => 'admin',
            'result'      => $result,
            'package_name'=> $package_name,
        ]);
    }

    /**
     * Admin: Create account upgradation request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {

            $users_personalinfo = DB::table('users_personalinfo')
                ->where('account_classification', '!=', 'Enterprise')
                ->get();

            return view('backend.account_upgradation_application.add', [
                'page_title'  => $this->page_title,
                'page_header' => 'Add Account Upgradation Application',
                'main_menu'   => 'admin',
                'users_personalinfo' => $users_personalinfo,
            ]);
        }

        $validated = $request->validate([
            'user_id'              => 'required|exists:users,id',
            'classification_name'  => 'required|exists:account_classification_package,classification_name',
        ]);

        DB::table('users_personalinfo')
            ->where('user_id', $validated['user_id'])
            ->update([
                'application_for_account_upgrade' => $validated['classification_name'],
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->back()->with([
            'status' => 'Account upgradation request submitted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Admin: Approve / Update account upgradation
     */
    public function update(Request $request)
    {
        $personalInfo = DB::table('users_personalinfo')->find($request->id);

        if (!$personalInfo) {
            return redirect()->back()->with([
                'status' => 'Record not found',
                'alert-type' => 'error',
            ]);
        }

        if ($request->isMethod('get')) {
            return view('backend.account_upgradation_application.edit', [
                'page_title'  => $this->page_title,
                'page_header' => 'Update Account Upgradation',
                'main_menu'   => 'admin',
                'result'      => $personalInfo,
            ]);
        }

        $validated = $request->validate([
            'account_classification' => 'required|exists:account_classification_package,classification_name',
        ]);

        DB::table('users_personalinfo')
            ->where('id', $personalInfo->id)
            ->update([
                'account_classification' => $validated['account_classification'],
                'application_for_account_upgrade' => null,
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->back()->with([
            'status' => 'Account upgraded successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * User: View upgrade packages
     */
    public function upgrade_profile_packages()
    {
        Paginator::useBootstrap();

        $personalInfo = DB::table('users_personalinfo')
            ->where('user_id', Auth::id())
            ->first();

        $account_classification_package = DB::table('account_classification_package')
            ->where('status', 'Active')
            ->orderBy('price', 'ASC')
            ->get();

        return view('backend.profile.upgrade_profile_packages', [
            'page_title'  => $this->page_title,
            'page_header' => 'Profile Upgradation Packages',
            'main_menu'   => 'dispatch',
            'personalInfo'=> $personalInfo,
            'account_classification_package' => $account_classification_package,
        ]);
    }
}