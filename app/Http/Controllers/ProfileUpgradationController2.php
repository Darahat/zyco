<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProfileUpgradationController extends Controller
{
    public $page_title;

    public function __construct(){
        $this->page_title = 'Admin Panel';
        $this->middleware('auth:admin'); // ensures only admin can access
    }

    // List all profile upgrade applications
    public function index(){
        Paginator::useBootstrap();
        $applications = DB::table('users_personalinfo')
            ->whereColumn('classification', '!=', 'application_for_upgrade')
            ->orderBy('id', 'DESC')
            ->get();

        $packages = DB::table('account_classification_package')
            ->where('status', 'Active')
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.profile_upgradation_application.index', compact('applications', 'packages'))
            ->with([
                'page_title' => $this->page_title,
                'page_header' => 'Users Upgradation Application'
            ]);
    }

    // Add a new profile upgrade application
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $users = DB::table('users_personalinfo')
                ->where('classification', '!=', 'Enterprise')
                ->get();

            return view('backend.profile_upgradation_application.add', compact('users'))
                ->with([
                    'page_title' => $this->page_title,
                    'page_header' => 'Add New Profile Upgradation Application'
                ]);
        } 

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'user_id' => 'required|unique:users_personalinfo',
                'classification_name' => 'required',
            ]);

            $insertData = DB::table('users_personalinfo')->insert([
                'user_id' => $request->user_id,
                'classification_name' => $request->classification_name,
            ]);

            $notification = $insertData 
                ? ['status' => 'Profile Upgradation Application Saved Successfully', 'alert-type' => 'success']
                : ['status' => 'Profile Upgradation Application Save Failed', 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }
    }

    // Edit / Update profile upgrade application
    public function update(Request $request, $id)
    {
        $application = DB::table('users_personalinfo')->where('id', $id)->first();

        if (!$application) {
            return redirect()->back()->with([
                'status' => 'Application not found',
                'alert-type' => 'error'
            ]);
        }

        if ($request->isMethod('get')) {
            return view('backend.profile_upgradation_application.edit', compact('application'))
                ->with([
                    'page_title' => $this->page_title,
                    'page_header' => 'Update Profile Upgradation Application'
                ]);
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'classification_name' => 'required',
            ]);

            DB::table('users_personalinfo')->where('id', $id)->update([
                'classification_name' => $request->classification_name
            ]);

            return redirect()->route('profile_upgradation.index')
                ->with(['status' => 'Application Updated Successfully', 'alert-type' => 'success']);
        }
    }

    // Delete a profile upgrade application
    public function delete(Request $request, $id)
    {
        $application = DB::table('users_personalinfo')->where('id', $id)->first();

        if (!$application) {
            return redirect()->back()->with([
                'status' => 'Application not found',
                'alert-type' => 'error'
            ]);
        }

        DB::table('users_personalinfo')->where('id', $id)->delete();

        return redirect()->back()->with([
            'status' => 'Application Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    // Show profile upgrade packages to a user
    public function upgradeProfilePackages()
    {
        Paginator::useBootstrap();

        $personalInfo = DB::table('users_personalinfo')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->first();

        $packages = DB::table('account_classification_package')
            ->where('status', 'Active')
            ->orderBy('id', 'ASC')
            ->get();

        return view('backend.profile.upgrade_profile_packages', compact('personalInfo', 'packages'))
            ->with([
                'page_title' => $this->page_title,
                'page_header' => 'Profile Upgradation Packages'
            ]);
    }
}