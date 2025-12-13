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

class FormConfigController extends Controller
{
	public $page_title;

	public function __construct()
	{
		$this->page_title = 'Admin Panel';
	}
	public function siteConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('site_config')->orderBy('id')->limit(1)->get();
			return view('admin.formConfig.site_config', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Site Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['brand_name']     = $request->brand_name;
			$post['address']        = $request->address;
			$post['invoice_email']  = $request->invoice_email;
			$post['support_email']  = $request->support_email;
			$post['registration_number'] = $request->registration_number;
			$post['telephone']  = $request->telephone;
			$post['vat_number'] = $request->vat_number;
			if (!empty($request->site_logo)) :
				$docFile = 'logo_' . time() . '.' . $request->site_logo->extension();
				$post['site_logo'] = $docFile;
				$request->site_logo->move(public_path('site_pic'), $docFile);
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('site_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('site_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function bankConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '1')->orderBy('id')->get();
			return view('admin.formConfig.bankp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Bank Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 1;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	 * vehicleConfig
	 *
	 * @param array $request  Input values
	 * @return redirect     to Country view
	 */
	public function vehicleConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '4')->orderBy('id')->get();
			$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();
			$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();
			$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();
			return view('admin.formConfig.vehiclep', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Vehicle Form Configuration',
			], compact('result', 'vehicle_type', 'vehicle_make', 'drivers'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 4;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function groupConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '5')->orderBy('id')->get();
			return view('admin.formConfig.groupp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Group Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 5;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function companyConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '2')->orderBy('id')->get();
			return view('admin.formConfig.companyp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Company Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 2;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function vatConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '3')->orderBy('id')->get();
			return view('admin.formConfig.vatp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Vat Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 3;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function postalConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '6')->orderBy('id')->get();
			return view('admin.formConfig.postalp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Postal Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 6;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function documentConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '7')->orderBy('id')->get();
			return view('admin.formConfig.documentp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Document Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 7;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function personalConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '8')->orderBy('id')->get();
			return view('admin.formConfig.personalp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Personal Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 8;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function basicConfig(Request $request)
	{
		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '9')->orderBy('id')->get();
			return view('admin.formConfig.basicp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Basic Form Configuration',
			], compact('result'));
		} else if ($request->submit) {
			$post = array();
			$id = $request->id;
			$post['form_id'] = 9;
			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;
			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status'     => $message,
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
	public function setConfigData(Request $request)
	{
		$post['field_name'] = implode(',', $request->field_value);
		if (!empty($request->id)) :
			$success = DB::table('form_config')->where('id', $request->id)->update($post);
			$status = 'Data Updated  Successfully';
		else :
			$post['form_id'] = $request->formId;
			$success = DB::table('form_config')->insert($post);
			$status = 'Data Saved  Successfully';
		endif;
		//return $success;
		if ($success) {
			$notification = array(
				'status' => $status,
				'alert-type' => 'success'
			);
			return redirect()->back()->with($notification);
		} else {
			$notification = array(
				'status' => 'Data Update Fail',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}
}