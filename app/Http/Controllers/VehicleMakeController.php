<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class VehicleMakeController extends Controller
{

    public $page_title;

    public function __construct()
    {
        $this->page_title = 'Admin Panel';
    }
    public function index()
    {
        if (Auth::guard('admin')->check()) {

            Paginator::useBootstrap();
            $vehicles = DB::table('vehicle_make')->orderBy('make_vehicle_name')->get();

            //return response()->json($notice );
            return view('backend.vehicle.vehicle_make', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Vechile Make',

            ], with(compact('vehicles')));
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("adminLoginForm")->with($notification);
        }
    }

    public function vehicle_make_form()
    {
        // print_r(Auth::guard('admin')); exit;
        if (Auth::guard('admin')->check()) {

            return view('backend.vehicle.vehicle_make_form', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Manage Vehicle Type',

            ]);
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("adminLoginForm")->with($notification);
        }
    }


    public function add_vehicle_make(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validatedData = $request->validate([
                'make_vehicle_name' => 'required',
                'status' => 'required',
            ]);

            $post = array();
            $post['make_vehicle_name'] = $request->make_vehicle_name;
            $post['status'] = $request->status;
            $post['created_at'] = Carbon::now();

            $add_car_type = DB::table('vehicle_make')->insert($post);

            if ($add_car_type) {
                $notification = array(
                    'status' => 'Data Successfully Added',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'status' => 'Data Successfully Adding failed',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit_form($id)
    {

        if (Auth::guard('admin')->check()) {

            $row = DB::table('vehicle_make')->where('id', $id)->first();
            //return response()->json($post_list );
            return view('backend.vehicle.vehicle_make_edit', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Vechile Make',
            ], with(compact('row')));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("adminLoginForm")->with($notification);
    }

    public function update(Request $request)
    {

        if (Auth::guard('admin')->check()) {
            $validatedData = $request->validate([
                'make_vehicle_name' => 'required',
                'status' => 'required',

            ]);

            //return response()->json( $validatedData );

            $id = $request->id;
            $post = array();
            $post['make_vehicle_name'] = $request->make_vehicle_name;
            $post['status'] = $request->status;
            $post['updated_at'] = Carbon::now();


            $postdata = DB::table('vehicle_make')->where('id', $id)->update($post);

            $notification = array(
                'status' => 'Data successfully updated',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function delete_vehicle_make($id)
    {

        if (Auth::guard('admin')->check()) {

            $delete = DB::table('vehicle_make')->where('id', $id)->delete();
            if ($delete) {
                $notification = array(
                    'status' => 'Data successfully deleted',
                    'alert-type' => 'success'
                );
            }

            return redirect()->back()->with($notification);
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );


        return redirect("adminLoginForm")->with($notification);
    }
}