<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Country;
use App\Models\User;
use App\Models\CustomDatatableColumn;
use Illuminate\Http\File;
use Auth;
use Validator;
use Session;
use App\Models\Role;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function index()
    {



        $admins = DB::table('admins')->orderBy('created_at', 'desc')->get();
        $countries = Country::select('long_name', 'phone_code', 'id')->get();
        return view('backend.admin.adminList', [
            'page_title' => 'Taxi Plaza',
            'main_menu' => 'admin',
            'page_header' => 'Admin List'
        ], with(compact('admins', 'countries')));
    }

    public function getAdminDetails(Request $request)
    {
        $data = array();
        $adminDetailsData = DB::table('admins')->where('id', $request->admin_id)->get();
        $data['$adminDetailsData'] = $adminDetailsData;
        // $country_id = DB::table('admins')->where('id',$request->admin_id)->select('country_id')->first();
        // $getCountryName = Country::where('country_id',$country_id)->select('long_name')->first();
        // $data['$getCountryName'] = $getCountryName;
        return $data;
        // $admins= DB::table('admins')->where('id',$id)->get();
    }
    public function dashboard()
    {
        return view('backend.dashboard', [
            'page_title' => 'Taxi Plaza',
            'main_menu' => 'admin',
            'page_header' => 'Dashboard',

        ]);
    }

    // public function forget_password(){

    //     return view('auth.forget_password');
    // }  
    public function adminLoginForm()
    {


        return view('auth.admin_login');
    }
    public function authenticate(Request $request)
    {
        //        $admin = Admin::where('email', $request->email)->orWhere('mobile_number', $request->email)->first();
        //        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        //        if(Auth::guard('admin')->attempt([$fieldType => $request->email, 'password' => $request->password])) {

        //             if(isset($admin) && $admin->status != 'Inactive') {

        //                 $notification = array(
        //                     'status' => 'Login Successfull',
        //                     'alert-type' => 'success'
        //                 );
        //             $mobile_number = Auth::guard('admin')->user()->mobile_number;
        //             return $mobile_number;

        //         }else{
        //             $notification = array(
        //                 'status' => 'Log In Failed. You are Blocked by Admin.',
        //                 'alert-type' => 'error'
        //             );
        //             return redirect()->back()->with($notification);
        //          } 
        //    }else{
        //      $notification = array(
        //         'status' => 'Username/Password is incorrect',
        //         'alert-type' => 'error'
        //     );
        //      return null;
        //   }

        $credentials =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // dd($request->all());
        // exit;
        if (auth()->guard('admin')->attempt($credentials)) {

            // $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

            //    if(auth()->guard('admin')->attempt([$fieldType => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            // $user_type = strtolower(Auth::user()->user_type);
            $notification = array(
                'status' => 'Login Successfull',
                'alert-type' => 'success'
            );
            $user_type = "Admin";
            // if($user_type == 'driver'): $user_type = "dispatch"; endif;
            $mobile_no = Auth::guard('admin')->user()->mobile_number;

            return $mobile_no;
            //    }
        } else {
            $notification = array(
                'status' => 'Login Failed',
                'alert-type' => 'error'
            );
            return null;
        }
    }
    public function forget_password_admin()
    {
        return view('auth.forget_password_admin');
    }
    public function signin_option_admin()
    {
        return view('auth.signin_option_admin');
    }
    public function forget_email_admin()
    {
        return view('auth.forget_email_admin');
    }

    public function addAdmin(Request $request)
    {

        // Add Admin User Validation Rules
        $rules = array(
            'username'      => 'required|unique:admins',
            'first_name'      => 'required',
            'last_name'      => 'required',
            'email'         => 'required|email|unique:admins',
            'password'      => 'required',
            'status'        => 'required',
            'country_code'  => 'required',
            'mobile_number' => 'required|numeric|unique:admins',
        );

        // Add Admin User Validation Custom Names
        $attributes = array(
            'username'      => 'Username',
            'first_name'      => 'First Name',
            'last_name'      => 'Last Name',
            'email'         => 'Email',
            'password'      => 'Password',
            'status'        => 'Status',
            'country_code'  => 'Country Code',
            'mobile_number' => 'Mobile Number',
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
        }
        $role = 1;
        $admin = new Admin;
        $admin->username = $request->username;
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email    = $request->email;
        $admin->password = $request->password;
        $admin->status   = $request->status;
        $admin->country_code = Country::find($request->country_code)->phone_code;
        $admin->country_id = $request->country_code;
        $admin->mobile_number   = $request->mobile_number;
        $success = $admin->save();
        $custom_datatable_column = array();
        if ($success) {

            $notification = array(
                'status' => 'Admin Added Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin_list')->with($notification);
        } else {
            $notification = array(
                'status' => 'Admin Adding Failed',
                'alert-type' => 'error'
            );
            return redirect()->route('admin_list')->with($notification);
        }
    }

    // public function adminStatusChange($id,$status){
    //     $post['status'] = $status;
    //     $success = DB::table('admins')->where('id',$id)->update($post);
    //     if($success){
    //         $notification = array(
    //             'status' => 'Admin Status Changed Successfully',
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->route('admin_list')->with($notification);
    //     }else{
    //         $notification = array(
    //             'status' => 'Admin Status Changed Failed',
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->route('admin_list')->with($notification);
    //     }
    // }

    public function editAdminForm($id)
    {
        $Admindata = Admin::where('id', $id)->first();
        $countries = Country::select('long_name', 'phone_code', 'id')->get();

        return view('backend.admin.adminEditForm', [
            'page_title' => 'Taxi Plaza',
            'main_menu' => 'admin',
            'page_header' => 'Edit Form'
        ], with(compact('Admindata', 'countries')));
    }
    public function editAdmin(Request $request)
    {

        // if($request->isMethod("GET")) {
        //     $data['result']  = Admin::find($request->id);
        //     $data['roles'] = Role::all()->pluck('name','id');
        //     $data['countries'] = Country::codeSelect();
        //     if($data['result']) {
        //         return view('admin.admin_users.edit', $data);    
        //     }
        //     flashMessage('danger', 'Invalid ID');
        //     return redirect('admin/admin_user');
        // }

        // Edit Admin User Validation Rules
        $rules = array(
            'username'   => 'required|unique:admins,username,' . $request->id,
            'email'      => 'required|email|unique:admins,email,' . $request->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code'     => 'required',
            'mobile_number'     => 'required|numeric',
            // 'role'       => 'required',
            'status'     => 'required'
        );

        // Edit Admin User Validation Custom Fields Name
        $attributes = array(
            'username'   => 'Username',
            'email'      => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'country_code' => 'Country Code',
            'mobile_number' => 'Mobile Number',
            // 'role'       => 'Role',
            'status'     => 'Status'
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $admins = Admin::active()->count();
        if ($admins == 1 && $request->status == 'Inactive') {
            flashMessage('danger', 'You can\'t inactive the last one. Atleast one should be available.');
            return back();
        }

        $admin = Admin::find($request->id);
        $admin->username = $request->username;
        $admin->email    = $request->email;
        $admin->first_name    = $request->first_name;
        $admin->last_name    = $request->last_name;
        $admin->country_code = Country::find($request->country_code)->phone_code;
        $admin->country_id = $request->country_code;
        $admin->mobile_number = $request->mobile_number;
        $admin->status   = $request->status;
        if ($request->filled("password")) {
            $admin->password = $request->password;
        }
        $success = $admin->save();

        //    $role = 1;
        //     $role_id = Role::role_user($request->id)->role_id;

        // if($role_id!=$role) {
        //     $admin->detachRole($role_id);
        //     $admin->attachRole($role);
        // }


        // Redirect to dashboard when current user not have a permission to view admin users

        if ($success) {
            $notification = array(
                'status' => 'Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin_list')->with($notification);
        } else {
            $notification = array(
                'status' => 'Update Failed',
                'alert-type' => 'error'
            );
            return redirect()->route('admin_list')->with($notification);
        }
    }
    public function deleteAdmin($id)
    {
        $admins = Admin::active()->count();
        if ($admins == 1) {
            flashMessage('danger', 'You can\'t delete the last one. Atleast one should be available.');
            return back();
        }

        $admin = Admin::where('id', $id)->first();
        if ($admin) {
            $roles_user = DB::table('role_user')->where('user_id', $id)->delete();
            $success = $admin->delete();

            if ($success) {
                $notification = array(
                    'status' => 'Admin Delete Successfull',
                    'alert-type' => 'success'
                );
                return redirect()->route('admin_list')->with($notification);
            } else {
                $notification = array(
                    'status' => 'Admin Not Deleted',
                    'alert-type' => 'error'
                );
                return redirect()->route('admin_list')->with($notification);
            }
        }
    }
}