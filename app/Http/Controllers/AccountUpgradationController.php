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

class AccountUpgradationController extends Controller
{
	public function __construct()
	{
		$this->page_title = 'Admin Panel';
	}
	public function index()
	{
		if (Auth::guard('admin')->check()) {

			Paginator::useBootstrap();
			$result = DB::table('users_personalinfo')->whereColumn('account_classification', '!=', 'application_for_account_upgrade')->orderBy('id', 'DESC')->get();
			$package_name = DB::table('account_classification_package')->where('status', 'Active')->orderBy('id', 'DESC')->get();
			return view('backend.account_upgradation_application.index', [
				'page_title' => $this->page_title,
				'page_header' => 'Account upgradation application',
				'main_menu' => 'admin',

			], with(compact('result', 'package_name')));
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
			$users_personalinfo =  DB::table('users_personalinfo')->where('account_classification', '!=', 'Enterprise')->get();
			return view('backend.account_upgradation_application.add', [
				'page_title' => $this->page_title,
				'page_header' => 'Add New Account Upgradation Application',
				'main_menu' => 'dispatch',

			], with(compact('users_personalinfo')));
		} else if ($request->submit) {
			//  dd($request->all());
			//  exit;
			$validatedData = $request->validate([
				'user_id' => 'required|unique:users_personalinfo',
				'classification_name'  => 'required',

			]);

			$post = array();
			$post['user_id'] = $request->user_id;
			$post['classification_name'] = $request->classification_name;

			$insertData = DB::table('users_personalinfo')->insert($post);

			if ($insertData) {
				$notification = array(
					'status' => 'Account Upgradation Application Information Saved Successfully',
					'alert-type' => 'success'
				);
				return redirect()->back()->with($notification);
			} else {
				$notification = array(
					'status' => 'Account Upgradation Application Information Save failed',
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

				return view('backend.account_upgradation_application.edit', [
					'page_title' => $this->page_title,
					'page_header' => 'Update Account Upgradation Application Information',
					'main_menu' => 'dispatch',
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

	public function upgrade_profile_packages()
	{


		Paginator::useBootstrap();
		$personalInfo = DB::table('users_personalinfo')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();

		$account_classification_package = DB::table('account_classification_package')->where('status', 'Active')->orderBy('id', 'ASC')->get();
		return view('backend.profile.upgrade_profile_packages', [
			'page_title' => $this->page_title,
			'page_header' => 'Profile Upgradation Packages',
			'main_menu' => 'dispatch',

		], with(compact('personalInfo', 'account_classification_package')));
	}
}