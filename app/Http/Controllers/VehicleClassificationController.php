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

class VehicleClassificationController extends Controller
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
      $result = DB::table('vehicle_classification')->orderBy('id', 'DESC')->get();
      return view('backend.vehicle_classification.index', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Vehicle Classification',

      ], compact('result'));
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect("adminLoginForm")->with($notification);
    }
  }


  /**
   * Add a New vehicle_classification
   *
   * @param array $request  Input values
   * @return redirect     to vehicle_classification view
   */
  public function add(Request $request)
  {
    if (!$_POST) {

      return view('backend.vehicle_classification.add', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add New vehicle_classification',

      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'classification_name' => 'required|unique:vehicle_classification',
        'status' => 'required',
        'classification_badge_icon' => 'required|image|mimes:png,jpeg,jpg|max:500',

      ]);
      $badgeIcon = 'badgeIcon' . time() . '.' . $request->classification_badge_icon->extension();
      $post = array();
      $post['classification_name'] = $request->classification_name;
      $post['status'] = $request->status;
      $post['badge_icon'] = $badgeIcon;
      // $post['created_at'] = Carbon::now();

      $insertData = DB::table('vehicle_classification')->insert($post);
      $request->classification_badge_icon->move(public_path('vehicle_classification'), $badgeIcon);
      if ($insertData) {
        $notification = array(
          'status' => 'vehicle_classification Information Saved Successfully',
          'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
      } else {
        $notification = array(
          'status' => 'vehicle_classification Information Save failed',
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

  /**
   * Update vehicle_classification Details
   *
   * @param array $request    Input values
   * @return redirect     to vehicle_classification View
   */
  public function update(Request $request)
  {
    if (!$_POST) {

      if (Auth::guard('admin')->check()) {

        $result = DB::table('vehicle_classification')->where('id', $request->id)->first();

        return view('backend.vehicle_classification.edit', [
          'page_title' => $this->page_title,
          'main_menu' => 'admin',
          'page_header' => 'Update vehicle classification Information',
        ], compact('result'));
      }
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'classification_name' => 'required',
        'status' => 'required',
      ]);

      //return response()->json( $validatedData );

      $id = $request->id;
      $post = array();
      $post['classification_name'] = $request->classification_name;
      $post['status'] = $request->status;
      $UpdateData = DB::table('vehicle_classification')->where('id', $id)->update($post);

      $notification = array(
        'status' => 'Data Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect()->back()->with($notification);
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect()->back()->with($notification);
    }
  }

  /**
   * Delete vehicle_classification
   *
   * @param array $request    Input values
   * @return redirect     to vehicle_classification View
   */
  public function delete(Request $request)
  {


    if (Auth::guard('admin')->check()) {

      $vehicle_classificationData = DB::table('vehicle_classification')->where('id', $request->id)->first();
      $vehicle_classification_code = $vehicle_classificationData->id;

      $checkVehicleExist = DB::table('users_vehicle')->where('vehicle_classification_id', $vehicle_classification_code)->first();

      if (!empty($checkVehicleExist)) {
        $notification = array(
          'status' => 'Some vehicle have this classification. So, We cannot delete the classification.',
          'alert-type' => 'error'
        );
      } else {
        $delete = DB::table('vehicle_classification')->where('id', $request->id)->delete();
        $notification = array(
          'status' => 'Vehicle Classification Information Deleted Successfully',
          'alert-type' => 'success'
        );
      }

      return redirect()->back()->with($notification);
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect()->back()->with($notification);
    }
  }
}