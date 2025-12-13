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

class VehicleTypeController extends Controller
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
			// $vehicles = DB::table('vehicle_model')->join('vehicle_make','vehicle_model.vehicle_make_id','=','vehicle_make.id')->orderBy('model_name')->get(['vehicle_model.*','vehicle_make.make_vehicle_name']);  

			$vehicles = DB::table('vehicle_type')->join('vehicle_classification', 'vehicle_classification.id', '=', 'vehicle_type.vehicle_classification_id')->orderBy('vehicle_type_name')->get(['vehicle_type.*', 'vehicle_classification.classification_name']);

			//return response()->json($notice );
			return view('backend.vehicle.vehicle_type', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Manage Vechile Type',

			], with(compact('vehicles')));
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect("adminLoginForm")->with($notification);
		}
	}

	public function vehicleTypeForm()
	{
		// print_r(Auth::guard('admin')); exit;
		if (Auth::guard('admin')->check()) {
			$classification = DB::table('vehicle_classification')->orderBy('classification_name')->get();
			return view('backend.vehicle.vehicle_type_form', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Manage Vehicle Type',

			], with(compact('classification')));
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect("adminLoginForm")->with($notification);
		}
	}


	public function add_vehicle_type(Request $request)
	{

		if (Auth::guard('admin')->check()) {
			$validatedData = $request->validate([
				'vehicle_type_name' => 'required',
				'description' => 'required',
				'classification_name' => 'required',
				'vehicle_type_image' => 'required|image|mimes:png,jpeg,jpg|max:500',
				'active_image' => 'required|image|mimes:png,jpeg,jpg|max:500',
				'status' => 'required',
			]);

			$vehicleImage = 'vehicle_type_image_' . time() . '.' . $request->vehicle_type_image->extension();
			$vehicleActiveImage = 'vehicle_active_image_' . time() . '.' . $request->active_image->extension();

			$post = array();
			$post['vehicle_type_name'] = $request->vehicle_type_name;
			$post['description'] = $request->description;
			$post['vehicle_type_image'] = $vehicleImage;
			$post['active_image'] = $vehicleActiveImage;
			$post['vehicle_classification_id'] = $request->classification_name;
			$post['status'] = $request->status;

			$request->vehicle_type_image->move(public_path('vehicle_type_image'), $vehicleImage);
			$request->active_image->move(public_path('vehicle_active_image'), $vehicleActiveImage);

			$add_vehicle_type = DB::table('vehicle_type')->insert($post);

			if ($add_vehicle_type) {
				$notification = array(
					'status' => 'Car Type Successfully Added',
					'alert-type' => 'success'
				);
				return redirect()->back()->with($notification);
			} else {
				$notification = array(
					'status' => 'Car Type Successfully Adding failed',
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

			$row = DB::table('vehicle_type')->where('id', $id)->first();
			//return response()->json($post_list );
			return view('backend.vehicle.vehicle_type_edit', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Manage Vehicle Type',
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
				'vehicle_type_name' => 'required',
				'description' => 'required',
				'vehicle_type_image' => 'image|mimes:png,jpeg,jpg|max:500',
				'vehicle_active_image' => 'image|mimes:png,jpeg,jpg|max:500',
				'is_pool' => 'required',
				'status' => 'required',

			]);

			//return response()->json( $validatedData );

			$id = $request->id;
			$post = array();
			$post['vehicle_type_name'] = $request->vehicle_type_name;
			$post['description'] = $request->description;
			$post['is_pool'] = $request->is_pool;
			$post['status'] = $request->status;


			if ($request->vehicle_type_image) {
				$vehicleImage = 'vehicle_type_image_' . time() . '.' . $request->vehicle_type_image->extension();
				$post['vehicle_type_image'] = $vehicleImage;
				$request->vehicle_type_image->move(public_path('vehicle_type_image'), $vehicleImage);
				if (file_exists(public_path('vehicle_type_image/') . $request->old_vehicle_type_image) && !empty($request->old_vehicle_type_image)) {
					unlink(public_path('vehicle_type_image/') . $request->old_vehicle_type_image);
				}
			}
			if ($request->vehicle_active_image) {
				$vehicleActiveImage = 'vehicle_active_image_' . time() . '.' . $request->vehicle_active_image->extension();
				$post['active_image'] = $vehicleActiveImage;
				$request->vehicle_active_image->move(public_path('vehicle_active_image'), $vehicleActiveImage);
				if (file_exists(public_path('vehicle_active_image/') . $request->old_vehicle_active_image) && !empty($request->old_vehicle_active_image)) {
					unlink(public_path('vehicle_active_image/') . $request->old_vehicle_active_image);
				}
			}

			$postdata = DB::table('vehicle_type')->where('id', $id)->update($post);

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

	public function delete_vehicle_type($id)
	{

		if (Auth::guard('admin')->check()) {

			$posts = DB::table('vehicle_type')->where('id', $id)->first();

			if (file_exists(public_path('vehicle_type_image/') . $posts->vehicle_type_image) && !empty($posts->vehicle_type_image)) {
				unlink(public_path('vehicle_type_image/') . $posts->vehicle_type_image);
			}

			if (file_exists(public_path('vehicle_active_image/') . $posts->active_image) && !empty($posts->active_image)) {
				unlink(public_path('vehicle_active_image/') . $posts->active_image);
			}



			$delete = DB::table('vehicle_type')->where('id', $id)->delete();
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