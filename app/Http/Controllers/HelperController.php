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



class HelperController extends Controller

{
	public function getDetails(Request $request)
	{

		$data = array();



		$detailsData = DB::table($request->table_name)->where('id', $request->id)->get();



		$data['$detailsData'] = $detailsData;

		return $data;
	}

	public function updateSingleArrayData(Request $request)
	{


		$post[$request->field] = implode(',', $request->value);

		$success = DB::table($request->table)->where('id', $request->id)->update($post);


		if ($success) {

			$notification = array(

				'status' => 'Data Updated  Successfully',

				'alert-type' => 'success'

			);

			$updatedData = DB::table($request->table)->get();

			// return $success;

			return redirect()->back()->with($notification);



			//  return json_encode($updatedData);

		} else {

			$notification = array(

				'status' => 'Data Update Fail',

				'alert-type' => 'error'

			);
			return redirect()->back()->with($notification);
		}
	}

	public function setCheckData(Request $request)
	{

		$post[$request->field] = implode(',', $request->value);
		if (!empty($request->id)) :
			$success = DB::table($request->table)->where('id', $request->id)->update($post);
		else :
			$post['form_id'] = $request->form_id;
			$success = DB::table($request->table)->insert($post);
		endif;
		if ($success) {
			$notification = array(
				'status' => 'Data Updated  Successfully',
				'alert-type' => 'success'
			);
			$updatedData = DB::table($request->table)->get();
			return redirect()->back()->with($notification);
		} else {
			$notification = array(
				'status' => 'Data Update Fail',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}
	public function updateSingleData(Request $request)
	{


		$post[$request->field] = $request->value;

		$success = DB::table($request->table)->where('id', $request->id)->update($post);



		if ($success) {

			$notification = array(

				'status' => 'Data Updated  Successfully',

				'alert-type' => 'success'

			);

			$updatedData = DB::table($request->table)->get();

			// return $success;

			return redirect()->back()->with($notification);



			//  return json_encode($updatedData);

		} else {

			$notification = array(

				'status' => 'Data Update Fail',

				'alert-type' => 'error'

			);
			return redirect()->back()->with($notification);
		}
	}

	public function deleteSingleData(Request $request)
	{
		$success = DB::table($request->table)->where('id', $request->id)->delete();
		if ($success) {
			$notification = array(
				'status' => 'Data Deleted  Successfully',
				'alert-type' => 'success'
			);

			$updatedData = DB::table($request->table)->get();
			// return $success;				
			return redirect()->back()->with($notification);

			//  return json_encode($updatedData);

		} else {

			$notification = array(
				'status' => 'Data Delete Fail',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}

	public function imageChange(Request $request)
	{



		$validatedData = $request->validate([

			'field'      => 'required',

			'image' => 'required|image|mimes:png,jpeg,jpg|max:500',

			'table_name' => 'required',

			'id'         => 'required'

		]);



		$imageName = $request->table_name . '' . time() . '.' . $request->image->extension();
		$post[$request->field] = $imageName;
		$UpdateData = DB::table($request->table_name)->where('id', $request->id)->update($post);
		$request->image->move(public_path($request->table_name), $imageName);
		if ($UpdateData) {
			$notification = array(
				'status' => 'Image Saved Successfully',
				'alert-type' => 'success'
			);
			return redirect()->back()->with($notification);
		} else {
			$notification = array(
				'status' => 'Image Save failed',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}
	public function commonUpdate(Request $request)
	{
		$fieldsarray = array();
		foreach ($request->except(array('_token', 'table', 'id')) as $key => $req) {
			array_push($fieldsarray, $key);
		}
		foreach ($fieldsarray as $field) {
			if (is_array($request->input($field))) {
				$post[$field] = implode(',', $request->input($field));
				$success = DB::table($request->table)->where('id', $request->id)->update($post);
			} else {
				$post[$field] = $request->input($field);
				$success = DB::table($request->table)->where('id', $request->id)->update($post);
			}
		}

		if ($success) {
			$notification = array(
				'status' => 'Data Updated Successfully',
				'alert-type' => 'success'
			);
			return redirect()->back()->with($notification);
		} else {
			$notification = array(
				'status' => 'Data Updated failed',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}


	public function redirectTosite()
	{
		return redirect()->away('https://zyco.nl/site');
	}
}