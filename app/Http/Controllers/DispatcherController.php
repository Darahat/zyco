<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
 
class DispatcherController extends Controller
{
	
	protected $page_title;

	public function __construct()
	{
		$this->page_title = 'Dispatcher Panel';
	}
	public function index()
	{
		if (Auth::guard('web')->check()) {

			Paginator::useBootstrap();
			$result = DB::table('country')->orderBy('id', 'DESC')->get();
			return view('backend.country.index', [
				'page_title' => $this->page_title,
				'page_header' => 'Country',

				'main_menu' => 'dispatch',

			], with(compact('result')));
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect("adminLoginForm")->with($notification);
		}
	}
	public function my_profile()
	{
		// dd(Auth::user()->id);
		// exit;
		if (Auth::guard('admin')->check()) {
			$result = DB::table('admins')->where('id', Auth::guard('admin')->user()->id)->first();
			$basicInfo = $result; // For admin, basicInfo is same as result
			$personalInfo = (object)['profile_picture' => null, 'street_name' => null]; // Empty object for admin
			$documents = array();
			$user_profileInfo = null;
			$users_bankinfo = null;
		} else if (Auth::user()->id != null) {

			$result =	DB::table('users')->where('id', Auth::user()->id)->first();
			$basicInfo = $result;
			$user_profileInfo =	DB::table('users_personalinfo')->where('user_id', Auth::user()->id)->first();
			$personalInfo = $user_profileInfo;
			$users_bankinfo =	DB::table('users_bankinfo')->where('user_id', Auth::user()->id)->first();
			// ->leftJoin('users_personalinfo', 'users.id', '=', 'users_personalinfo.user_id')
			// ->leftJoin('users_bankinfo', 'users_personalinfo.user_id', '=', 'users_bankinfo.user_id')->where('users_bankinfo.user_id',Auth::user()->id)
			// ->first();
			$documents = 	DB::table('users_documents')->where('user_id', Auth::user()->id)->get();
			// $result = DB::table('users_personalinfo')->where('user_id',Auth::user()->id)->first();    

		}

		return view('backend.common.my_profile2', [
			'page_title' => $this->page_title,
			'page_header' => 'My Profile',
			'main_menu' => 'profile',

		], with(compact('result', 'documents', 'user_profileInfo', 'users_bankinfo', 'basicInfo', 'personalInfo')));
	}
	public function dispatch_form()
	{
		return view('backend.dispatcher.dispatch_form', [
			'page_title' => $this->page_title,
			'page_header' => 'Booking Add',
			'main_menu' => 'dispatch',

		]);
	}

	public function dispatch_map()
	{
		return view('backend.dispatcher.dispatch_map', [
			'page_title' => $this->page_title,
			'page_header' => 'dispatch_map',
			'main_menu' => 'dispatch',

		]);
	}


	public function dispatch_list()
	{
		return view('backend.dispatcher.dispatch_list', [
			'page_title' => $this->page_title,
			'page_header' => 'dispatch_list',
			'main_menu' => 'dispatch',

		]);
	}

	/**
	 * Add a New Booking
	 *
	 * @param Request $request  Input values
	 * @return redirect     to Country view
	 */
	public function add(Request $request)
	{
		if (!request()->isMethod('post')) {
			$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'ASC')->get();
			$rider_info = DB::table('users')->where('user_type', 'Rider')->orderBy('id', 'ASC')->get();
			$language_info = DB::table('language')->where('status', 'Active')->orderBy('id', 'ASC')->get();

			return view('backend.dispatcher.add', [
				'page_title' => $this->page_title,
				'page_header' => 'Booking Add',
				'main_menu' => 'dispatch',

			], with(compact('vehicle_type', 'rider_info', 'language_info')));
		} else if (request()->has('submit')) {

			$validatedData = request()->validate([
				'short_name' => 'required|unique:country',
				'long_name'  => 'required|unique:country',
				'phone_code' => 'required',
			]);

			$post = array();
			$post['short_name'] = request()->input('short_name');
			$post['long_name'] = request()->input('long_name');
			$post['iso3'] = request()->input('iso3');
			$post['num_code'] = request()->input('num_code');
			$post['phone_code'] = request()->input('phone_code');
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
		if (!request()->isMethod('post')) {

			if (Auth::guard('admin')->check()) {

				$result = DB::table('country')->where('id', request()->input('id'))->first();

				return view('backend.country.edit', [
					'page_title' => $this->page_title,
					'page_header' => 'Update Country Information',
					'main_menu' => 'dispatch',
				], with(compact('result')));
			}
		} else if (request()->has('submit')) {

			$validatedData = request()->validate([
				'short_name' => 'required',
				'long_name'  => 'required',
				'phone_code' => 'required',
			]);

			//return response()->json( $validatedData );

			$id = request()->input('id');
			$post = array();
			$post['short_name'] = request()->input('short_name');
			$post['long_name'] = request()->input('long_name');
			$post['iso3'] = request()->input('iso3');
			$post['num_code'] = request()->input('num_code');
			$post['phone_code'] = request()->input('phone_code');
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

			$countryData = DB::table('country')->where('id', request()->input('id'))->first();
			$country_code = $countryData->phone_code;

			$user = DB::table('users')->where('country_code', $country_code)->first();

			if ($user) {
				$notification = array(
					'status' => 'Some User have this Country. So, We cannot delete the country.',
					'alert-type' => 'error'
				);
			} else {
				$delete = DB::table('country')->where('id', request()->input('id'))->delete();
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
 // ← Creates array
// Later: $request->only(...) // ← Tries to use as object