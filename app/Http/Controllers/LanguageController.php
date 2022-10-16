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

class LanguageController extends Controller
{
  public function __construct()
  {
    $this->page_title = 'Admin Panel';
  }
  public function index()
  {
    if (Auth::guard('admin')->check()) {
      Paginator::useBootstrap();
      $result = DB::table('language')->orderBy('id', 'DESC')->get();
      return view('backend.language.index', [
        'page_title' => $this->page_title,
        'main_menu' => 'informations',
        'page_header' => 'Language',
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
   * Add a New language
   *
   * @param array $request  Input values
   * @return redirect     to language view
   */
  public function add(Request $request)
  {
    if (!$_POST) {
      return view('backend.language.add', [
        'page_title' => $this->page_title,
        'main_menu' => 'informations',
        'page_header' => 'Add New Language',
      ]);
    } else if ($request->submit) {
      $validatedData = $request->validate([
        'name' => 'required|unique:language',
        'value' => 'required|unique:language',
        'status' => 'required',
      ]);
      $post = array();
      $post['name'] = $request->name;
      $post['value'] = $request->value;
      $post['status'] = $request->status;
      $insertData = DB::table('language')->insert($post);
      if ($insertData) {
        $notification = array(
          'status' => 'language Information Saved Successfully',
          'alert-type' => 'success'
        );
        return redirect('admin/language')->with($notification);
      } else {
        $notification = array(
          'status' => 'language Information Save failed',
          'alert-type' => 'error'
        );
        return redirect('admin/language')->with($notification);
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
   * Update language Details
   *
   * @param array $request    Input values
   * @return redirect     to language View
   */
  public function update(Request $request)
  {
    if (!$_POST) {
      if (Auth::guard('admin')->check()) {
        $result = DB::table('language')->where('id', $request->id)->first();
        return view('backend.language.edit', [
          'page_title' => $this->page_title,
          'main_menu' => 'informations',
          'page_header' => 'Update Language Information',
        ], with(compact('result')));
      }
    } else if ($request->submit) {
      $validatedData = $request->validate([
        'name' => 'required',
        'value' => 'required',
        'status' => 'required',
      ]);
      //return response()->json( $validatedData );
      $id = $request->id;
      $post = array();
      $post['name'] = $request->name;
      $post['value'] = $request->value;
      $post['status'] = $request->status;
      $UpdateData = DB::table('language')->where('id', $id)->update($post);
      $notification = array(
        'status' => 'Data Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect('admin/language')->with($notification);
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );
      return redirect()->back()->with($notification);
    }
  }
  /**
   * Delete language
   *
   * @param array $request    Input values
   * @return redirect     to language View
   */
  public function delete(Request $request)
  {

    if (Auth::guard('admin')->check()) {
      $languageData = DB::table('language')->where('id', $request->id)->first();
      $language_code = $languageData->value;
      $user = DB::table('users')->where('language', $language_code)->first();
      if ($user) {
        $notification = array(
          'status' => 'Some User have this language. So, We cannot delete the language.',
          'alert-type' => 'error'
        );
      } else {
        $delete = DB::table('language')->where('id', $request->id)->delete();
        $notification = array(
          'status' => 'language Information Deleted Successfully',
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