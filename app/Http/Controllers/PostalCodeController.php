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



class PostalCodeController extends Controller

{

  public function __construct()
  {

    $this->page_title = 'Admin Panel';
  }

  public function index()
  {


    Paginator::useBootstrap();
    $result = DB::table('users_postalcode')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

    return view('backend.postalCode.index', [
      'page_title' => $this->page_title,
      'main_menu' => 'admin',
      'page_header' => 'Postal Information',

    ], compact('result'));
  }

  public function add(Request $request)
  {


    if (!$_POST) {
      return view('backend.postalCode.add', [

        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add Postal Information',
      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate(['postcode' => 'required', 'hnumber' => 'required']);
      $post['user_id'] = Auth::user()->id;
      $postcode = $request->postcode;
      $hnumber  = $request->hnumber;
      $tokenKey = "dbbb694d-13b6-4c9c-90be-10940e69fb39";

      $options = array('http' => array(
        'method'  => 'GET',
        'header' => 'Authorization: Bearer ' . $tokenKey
      ));
      $context  = stream_context_create($options);

      $contents = @file_get_contents('https://postcode.tech/api/v1/postcode/full?postcode=' . $postcode . '&number=' . $hnumber, false, $context);
      $dataResult = json_decode($contents);
      //print_r($dataResult); exit;

      if ($dataResult) :

        $postcode2 = $dataResult->postcode;
        $hnumber2 = $dataResult->number;

        $dataExist = DB::table('users_postalcode')->where('user_id', Auth::user()->id)->where('postcode', $postcode2)->where('hnumber', $hnumber2)->get();

        if (count($dataExist)) :
          $notification = array(
            'status' => 'Postal Information Already Exist',
            'alert-type' => 'error'
          );
        else :

          $post['postcode'] = $dataResult->postcode;
          $post['hnumber'] = $dataResult->number;
          $post['street']  = $dataResult->street;
          $post['city']   = $dataResult->city;
          $post['municipality']      = $dataResult->municipality;
          $post['province'] = $dataResult->province;
          $post['geoLat'] = $dataResult->geo->lat;
          $post['geoLon'] = $dataResult->geo->lon;

          $insertData = DB::table('users_postalcode')->insert($post);
          $notification = array(
            'status' => 'Postal Information Saved Successfully',
            'alert-type' => 'success'
          );

        endif;
      else :
        $notification = array(
          'status' => 'Invalid Postal Code or Number',
          'alert-type' => 'error'
        );

      endif;

      return redirect()->route('postal_list')->with($notification);
    }
  }

  public function add2(Request $request)
  {


    if (!$_POST) {
      return view('backend.postalCode.add2', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Add Postal Information',
      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'postcode'   => 'required',
        'hnumber'    => 'required',
      ]);


      $postcode2 = $request->postcode;
      $hnumber2 = $request->number;

      $dataExist = DB::table('users_postalcode')->where('user_id', Auth::user()->id)->where('postcode', $postcode2)->where('hnumber', $hnumber2)->get();

      if (count($dataExist)) :
        $notification = array(
          'status' => 'Postal Information Already Exist',
          'alert-type' => 'error'
        );
      else :

        $post = array();
        $post['user_id'] = Auth::user()->id;
        $post['postcode'] = $request->postcode;
        $post['hnumber'] = $request->hnumber;
        $post['street']  = $request->street;
        $post['city']   = $request->city;
        $post['municipality']      = $request->municipality;
        $post['province'] = $request->province;
        $post['geoLat'] = $request->geoLat;
        $post['geoLon'] = $request->geoLon;

        $insertData = DB::table('users_postalcode')->insert($post);
        $notification = array(
          'status' => 'Postal Information Saved Successfully',
          'alert-type' => 'success'
        );
      endif;

      return redirect()->route('postal_list')->with($notification);
    }
  }

  public function update(Request $request)

  {

    if (!$_POST) {

      $result = DB::table('users_postalcode')->where('id', $request->id)->first();

      return view('backend.postalCode.edit', [
        'page_title' => $this->page_title,
        'main_menu' => 'admin',
        'page_header' => 'Update Postal Information',
      ], compact('result'));
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'postcode'   => 'required',
        'hnumber'    => 'required',
      ]);



      $id = $request->id;

      $post = array();
      $post['postcode'] = $request->postcode;
      $post['hnumber'] = $request->hnumber;
      $post['street']  = $request->street;
      $post['city']   = $request->city;
      $post['municipality']      = $request->municipality;
      $post['province'] = $request->province;
      $post['geoLat'] = $request->geoLat;
      $post['geoLon'] = $request->geoLon;

      $updateData = DB::table('users_postalcode')->where('id', $id)->update($post);



      $notification = array(
        'status' => 'Data Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect()->route('postal_list')->with($notification);
    }
  }

  /**

   * Delete 

   *

   * @param array $request    Input values
 
   * @return redirect     to View

   */

  public function delete(Request $request)

  {
    $delete = DB::table('users_postalcode')->where('id', $request->id)->delete();
    $notification = array(
      'status' => 'Postal Information Deleted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }
}