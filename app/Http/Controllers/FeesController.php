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

class FeesController extends Controller
{
  public function __construct()
  {
    $this->page_title = 'Admin Panel';
  }
  public function index()
  {


    Paginator::useBootstrap();
    $result = DB::table('fees')->orderBy('id', 'DESC')->get();
    return view('backend.fees.index', [
      'page_title' => $this->page_title,
      'main_menu' => 'admin',
      'page_header' => 'Fees',

    ], with(compact('result')));
  }

  /**
   * Add a New fees
   *
   * @param array $request  Input values
   * @return redirect     to fees view
   */
  public function add(Request $request)
  {
    if (!$_POST) {
      return view('backend.fees.add', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add New Fees',

      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'name' => 'required|unique:fees',
        'code' => 'required|unique:fees',
        'symbol'  => 'required|unique:fees',
        'rate'  => 'required|unique:fees',
        'status' => 'required',
      ]);

      $post = array();
      $post['name'] = $request->name;
      $post['code'] = $request->code;
      $post['symbol'] = $request->symbol;
      $post['rate'] = $request->rate;
      $post['status'] = $request->status;
      $insertData = DB::table('fees')->insert($post);

      if ($insertData) {
        $notification = array(
          'status' => 'fees Information Saved Successfully',
          'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
      } else {
        $notification = array(
          'status' => 'fees Information Save failed',
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
   * Update fees Details
   *
   * @param array $request    Input values
   * @return redirect     to fees View
   */
  public function update(Request $request)
  {
    if (!$_POST) {
      $result = DB::table('fees')->where('id', $request->id)->first();

      return view('backend.fees.edit', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Update Fees Information',
      ], with(compact('result')));
    } else {

      $validatedData = $request->validate([
        'value' => 'required',
        'fee_type' => 'required',
      ]);

      //return response()->json( $validatedData );

      $id = $request->id;
      $post = array();
      $post['value'] = $request->value;
      $post['fee_type'] = $request->fee_type;
      $UpdateData = DB::table('fees')->where('id', $id)->update($post);

      $notification = array(
        'status' => 'Data Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect()->back()->with($notification);
    }
  }

  /**
   * Delete fees
   *
   * @param array $request    Input values
   * @return redirect     to fees View
   */
  public function delete(Request $request)
  {


    if (Auth::guard('admin')->check()) {

      $feesData = DB::table('fees')->where('id', $request->id)->first();
      $fees_code = $feesData->code;

      $user = DB::table('users')->where('fees_code', $fees_code)->first();

      if ($user) {
        $notification = array(
          'status' => 'Some User have this fees. So, We cannot delete the fees.',
          'alert-type' => 'error'
        );
      } else {
        $delete = DB::table('fees')->where('id', $request->id)->delete();
        $notification = array(
          'status' => 'fees Information Deleted Successfully',
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