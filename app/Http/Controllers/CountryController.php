<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\File;
use Auth;
use Session;

class CountryController extends Controller
{
  public function __construct()
  {
    $this->page_title = 'Admin Panel';
  }
  public function index()
  {
    if (Auth::guard('admin')->check()) {

      Paginator::useBootstrap();
      $result = DB::table('country')->orderBy('id', 'DESC')->get();
      return view('backend.country.index', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Country',

      ], with(compact('result')));
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect("adminLoginForm")->with($notification);
    }
  }

  /**
   * Add a New Country
   *
   * @param array $request  Input values
   * @return redirect     to Country view
   */
  public function add(Request $request)
  {
    if (!$_POST) {
      return view('backend.country.add', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add New Country',

      ]);
    } else if ($request->submit) {
      //  dd($request->all());
      //  exit;
      $validatedData = $request->validate([
        'short_name' => 'required|unique:country',
        'long_name'  => 'required|unique:country',
        'phone_code' => 'required',
      ]);

      $post = array();
      $post['short_name'] = $request->short_name;
      $post['long_name'] = $request->long_name;
      $post['iso3'] = $request->iso3;
      $post['num_code'] = $request->num_code;
      $post['phone_code'] = $request->phone_code;
      $insertData = DB::table('country')->insert($post);

      if ($insertData) {
        $notification = array(
          'status' => 'Country Information Saved Successfully',
          'alert-type' => 'success'
        );
        return redirect('admin/country')->with($notification);
      } else {
        $notification = array(
          'status' => 'Country Information Save failed',
          'alert-type' => 'error'
        );
        return redirect('admin/country')->with($notification);
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
   * Update Country Details
   *
   * @param array $request    Input values
   * @return redirect     to Country View
   */
  public function update(Request $request)
  {
    if (!$_POST) {

      if (Auth::guard('admin')->check()) {

        $result = DB::table('country')->where('id', $request->id)->first();

        return view('backend.country.edit', [
          'page_title' => $this->page_title,
          'main_menu' => 'admin',
          'page_header' => 'Update Country Information',
        ], with(compact('result')));
      }
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'short_name' => 'required',
        'long_name'  => 'required',
        'phone_code' => 'required',
      ]);

      //return response()->json( $validatedData );

      $id = $request->id;
      $post = array();
      $post['short_name'] = $request->short_name;
      $post['long_name'] = $request->long_name;
      $post['iso3'] = $request->iso3;
      $post['num_code'] = $request->num_code;
      $post['phone_code'] = $request->phone_code;
      $UpdateData = DB::table('country')->where('id', $id)->update($post);

      $notification = array(
        'status' => 'Data Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect('admin/country')->with($notification);
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect()->back()->with($notification);
    }
  }

  /**
   * Delete Country
   *
   * @param array $request    Input values
   * @return redirect     to Country View
   */
  public function delete(Request $request)
  {


    if (Auth::guard('admin')->check()) {

      $countryData = DB::table('country')->where('id', $request->id)->first();
      $country_code = $countryData->phone_code;

      $user = DB::table('users')->where('country_code', $country_code)->first();

      if ($user) {
        $notification = array(
          'status' => 'Some User have this Country. So, We cannot delete the country.',
          'alert-type' => 'error'
        );
      } else {
        $delete = DB::table('country')->where('id', $request->id)->delete();
        $notification = array(
          'status' => 'Country Information Deleted Successfully',
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