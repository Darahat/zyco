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

class VehicleModelController extends Controller
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
            $vehicles = DB::table('vehicle_model')->join('vehicle_make', 'vehicle_model.vehicle_make_id', '=', 'vehicle_make.id')->orderBy('model_name')->get(['vehicle_model.*', 'vehicle_make.make_vehicle_name']);

            //return response()->json($notice );
            return view('backend.vehicle.vehicle_model', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Vechile Model',

            ], with(compact('vehicles')));
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("adminLoginForm")->with($notification);
        }
    }

    public function vehicle_model_form()
    {
        // print_r(Auth::guard('admin')); exit;
        if (Auth::guard('admin')->check()) {
            $vehicles_make = DB::table('vehicle_make')->orderBy('make_vehicle_name')->get();
            return view('backend.vehicle.vehicle_model_form', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Vehicle Model',

            ], with(compact('vehicles_make')));
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("adminLoginForm")->with($notification);
        }
    }


    public function add_vehicle_model(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validatedData = $request->validate([
                'make_vehicle_name' => 'required',
                'model_name' => 'required',
                'status' => 'required',
            ]);

            $post = array();
            $post['vehicle_make_id'] = $request->make_vehicle_name;
            $post['model_name'] = $request->model_name;
            $post['status'] = $request->status;
            $post['created_at'] = Carbon::now();

            $add_car_type = DB::table('vehicle_model')->insert($post);

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
            $vehicles_make = DB::table('vehicle_make')->orderBy('make_vehicle_name')->get();
            $row = DB::table('vehicle_model')->where('id', $id)->first();
            //return response()->json($post_list );
            return view('backend.vehicle.vehicle_model_edit', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Vechile Model',
            ], with(compact('row', 'vehicles_make')));
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
                'vehicle_make_id' => 'required',
                'model_name' => 'required',
                'status' => 'required',

            ]);

            //return response()->json( $validatedData );

            $id = $request->id;
            $post = array();
            $post['vehicle_make_id'] = $request->vehicle_make_id;
            $post['model_name'] = $request->model_name;
            $post['status'] = $request->status;
            $post['updated_at'] = Carbon::now();


            $postdata = DB::table('vehicle_model')->where('id', $id)->update($post);

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

    public function delete_vehicle_model($id)
    {

        if (Auth::guard('admin')->check()) {

            $delete = DB::table('vehicle_model')->where('id', $id)->delete();
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