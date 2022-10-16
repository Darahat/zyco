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
use Carbon\Carbon;

class AccountClassificationController extends Controller
{
  public function __construct()
  {
    $this->page_title = 'Admin Panel';
  }
  public function index()
  {
    if (Auth::guard('admin')->check()) {

      Paginator::useBootstrap();
      $result = DB::table('account_classification_package')->orderBy('id', 'DESC')->get();
      return view('backend.account_classification_package.index', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Account Classification Package',

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
   * Add a New account_classification_package
   *
   * @param array $request  Input values
   * @return redirect     to account_classification_package view
   */
  public function add(Request $request)
  {

    if (!$_POST) {
      return view('backend.account_classification_package.add', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add New Account Classification Package',

      ]);
    } else if ($request->submit) {
      //  dd($request->all());
      //  exit;
      $validatedData = $request->validate([
        'classification_name' => 'required|unique:account_classification_package',
        'price'  => 'required|numeric',
      ]);

      $post = array();
      $post['classification_name'] = $request->classification_name;
      $post['price'] = $request->price;
      $post['features'] = $request->features;
      $post['created_at'] = Carbon::now();
      $insertData = DB::table('account_classification_package')->insert($post);

      if ($insertData) {
        $notification = array(
          'status' => 'account_classification_package Information Saved Successfully',
          'alert-type' => 'success'
        );
        return redirect('admin/account_classification_package')->with($notification);
      } else {
        $notification = array(
          'status' => 'account_classification_package Information Save failed',
          'alert-type' => 'error'
        );
        return redirect('admin/account_classification_package')->with($notification);
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
   * Update account_classification_package Details
   *
   * @param array $request    Input values
   * @return redirect     to account_classification_package View
   */
  public function update(Request $request)
  {
    if (!$_POST) {

      if (Auth::guard('admin')->check()) {

        $result = DB::table('account_classification_package')->where('id', $request->id)->first();

        return view('backend.account_classification_package.edit', [
          'page_title' => $this->page_title,
          'page_header' => 'Update account_classification_package Information',
        ], with(compact('result')));
      }
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'classification_name' => 'required',
        'price'  => 'required|numeric',
      ]);

      //return response()->json( $validatedData );

      $id = $request->id;
      $post = array();
      $post['classification_name'] = $request->classification_name;
      $post['price'] = $request->price;
      $post['features'] = $request->features;
      $post['updated_at'] = Carbon::now();
      $UpdateData = DB::table('account_classification_package')->where('id', $id)->update($post);

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
      return redirect()->route('adminLoginForm')->with($notification);
    }
  }

  /**
   * Delete account_classification_package
   *
   * @param array $request    Input values
   * @return redirect     to account_classification_package View
   */
  public function delete(Request $request)
  {


    if (Auth::guard('admin')->check()) {

      $account_classification_packageData = DB::table('account_classification_package')->where('id', $request->id)->first();
      $account_classification_package_code = $account_classification_packageData->classification_name;

      $user = DB::table('users_personalinfo')->where('account_classification', $account_classification_package_code)->first();

      if ($user) {
        $notification = array(
          'status' => 'Some User have this account_classification_package. So, We cannot delete the account_classification_package.',
          'alert-type' => 'error'
        );
      } else {
        $delete = DB::table('account_classification_package')->where('id', $request->id)->delete();
        $notification = array(
          'status' => 'account_classification_package Information Deleted Successfully',
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