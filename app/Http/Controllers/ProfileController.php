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
use Hash;

class ProfileController extends Controller
{
	public $page_title;

	public function __construct()
	{
		$this->page_title = 'Dispatcher Panel | User Profile';
	}
	public function index()
	{
		if (Auth::guard('driver')->check()) {
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
	public function updateBasicInfoForm()
	{
		Paginator::useBootstrap();
		$basicInfo = DB::table('users')->where('id', Auth::user()->id)->first();
		$personalInfo = DB::table('users_personalinfo')->where('user_id', Auth::user()->id)->first();
		$languagelist     = DB::table('language')->get();
		$time_zones =  DB::table('timezones')->get();
		return view('backend.profile.basic_update', [
			'page_title' => $this->page_title,
			'page_header' => 'Basic Update',
			'main_menu' => 'dispatch',
		], with(compact('basicInfo', 'personalInfo', 'time_zones', 'languagelist')));
	}
	public function profileUpdate()
	{
		$user_id = Auth::user()->id;
		$personalInfo = DB::table('users_personalinfo')->where('user_id', $user_id)->first();
		$basicInfo    = DB::table('users')->where('id', $user_id)->first();
		$bankInfo     = DB::table('users_bankinfo')->where('user_id', $user_id)->first();
		$languagelist     = DB::table('language')->get();
		$documentInfo = DB::table('users_documents')->where('user_id', $user_id)->get();
		$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();
		$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();
		$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();
		$vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();
		$vehicleInfo  = DB::table('users_vehicle')->where('user_id', $user_id)->get();
		$companyInfo = DB::table('users_companyinfo')->where('user_id', $user_id)->first();
		$companyVatInfo  = DB::table('users_company_vat')->where('user_id', $user_id)->get();
		$time_zones =  DB::table('timezones')->get();
		return view('backend.profile.profile_update', [
			'page_title' => $this->page_title,
			'page_header' => '',
			'main_menu' => 'settings',
			'time_zones' => $time_zones,
		], with(compact('personalInfo', 'basicInfo', 'bankInfo', 'documentInfo', 'vehicleInfo', 'companyInfo', 'companyVatInfo', 'languagelist', 'vehicle_type', 'vehicle_make', 'vehicle_model', 'drivers')));
	}
	/**
	 * Update Country Details
	 *
	 * @param array $request    Input values
	 * @return redirect     to Country View
	 */
	public function updatePersonal(Request $request)
	{
		$validatedData = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'sex' => 'required',
			'street_name' => 'required',
			'personal_number' => 'required',
			'personal_email' => 'required',
			'emergency_number' => 'required',
			'name_title' => 'required',
		]);
		$id = Auth::user()->id;
		$post = array();
		$post['name_title'] = $request->name_title;
		$post['sex'] = $request->sex;
		$post['street_name'] = $request->street_name;
		$post['personal_number'] = $request->personal_number;
		$post['personal_email'] = $request->personal_email;
		$post['emergency_number'] = $request->emergency_number;
		$post['date_of_birth'] = $request->date_of_birth;
		$post['note_area'] = $request->note_area;
		if (!empty($request->driving_license)) :
			$driving_license = 'driving_license' . time() . '.' . $request->driving_license->extension();
			$post['driving_license'] = $driving_license;
			$request->driving_license->move(public_path('driving_licence'), $driving_license);
		endif;
		$post2['first_name'] = $request->first_name;
		$post2['last_name'] = $request->last_name;
		$UpdateData = DB::table('users_personalinfo')->where('user_id', $id)->update($post);
		$UpdateData2 = DB::table('users')->where('id', $id)->update($post2);
		$message = "Data Updated Successfully";
		$notification = array(
			'status' => $message,
			'alert-type' => 'success'
		);
		return redirect()->back()->with($notification);
	}
	public function updateBasicInfo(Request $request)
	{
		$validatedData = $request->validate([
			'username' => 'required',
			'email' => 'required',
			'mobile_number' => 'required',
			'password' => 'required',
			'base_city' => 'required',
			'alt_email' => 'required',
		]);
		//return response()->json( $validatedData );
		$id = Auth::user()->id;
		$post = array();
		$post2 = array();
		$post['username'] = $request->username;
		$post['email'] = $request->email;
		$post['mobile_number'] = $request->mobile_number;
		$post['password'] = Hash::make($request->password);
		$post['alt_email'] = $request->alt_email;
		if ($request->can_speak) {
			$can_speak = implode(",", $request->can_speak);
			$post['can_speak'] = $can_speak;
		}
		$post['base_city'] = $request->base_city;
		$post['time_zone'] = $request->time_zone;
		$post['language'] = $request->language;
		$UpdateData = DB::table('users')->where('id', $id)->update($post);
		$message = "error";
		if (!empty($request->profile_picture)) :
			$profileImage = 'profile_' . time() . '.' . $request->profile_picture->extension();
			$post2['profile_picture'] = $profileImage;
			$request->profile_picture->move(public_path('profile'), $profileImage);
			$isExistId = DB::table('users_personalinfo')->where("user_id", Auth::user()->id)->exists();
			if ($isExistId) :
				$UpdateData2 = DB::table('users_personalinfo')->where('user_id', $id)->update($post2);
				$message = "Data Updated Successfully";
			else :
				$post2['user_id'] = $id;
				$insertData = DB::table('users_personalinfo')->insert($post2);
				$message = "Data Saved Successfully";
			endif;
			$notification = array(
				'status' => $message,
				'alert-type' => 'success'
			);
			return redirect()->back()->with($notification);
		endif;
		$notification = array(
			'status' => "Updated",
			'alert-type' => 'success'
		);
		return redirect()->back()->with($notification);
	}
	public function updateBank(Request $request)
	{
		$validatedData = $request->validate([
			'IBAN' => 'required',
			'BIC'  => 'required',
			'account_holder_name' => 'required',
		]);
		//return response()->json( $validatedData );
		$id = $request->id;
		$post = array();
		$post['user_id'] = Auth::user()->id;
		$post['IBAN'] = $request->IBAN;
		$post['BIC'] = $request->BIC;
		$post['account_holder_name'] = $request->account_holder_name;
		$post['note_area'] = $request->note_area;
		if (!empty($id)) :
			$UpdateData = DB::table('users_bankinfo')->where('id', $id)->update($post);
			$message = "Data Updated Successfully";
		else :
			$insertData = DB::table('users_bankinfo')->insert($post);
			$message = "Data Saved Successfully";
		endif;
		$notification = array(
			'status' => $message,
			'alert-type' => 'success'
		);
		return redirect()->back()->with($notification);
	}
	/**
	 * Delete Country
	 *
	 * @param array $request    Input values
	 * @return redirect     to Country View
	 */
	public function delete(Request $request)
	{
		if (Auth::guard('driver')->check()) {
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
	public function autocomplete(Request $request)
	{
		$users = User::select("first_name", "last_name")
			->where("first_name", "LIKE", "%{$request->get('query')}%")
			->get();
		$data = array();
		foreach ($users as $user) {
			$data[] = $user->first_name . ' ' . $user->last_name;
		}
		return response()->json($data);
	}
	public function searchResult(Request $request)
	{
		$text = $request->search;
		// $split = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $text, -1, PREG_SPLIT_NO_EMPTY);
		$split = array();
		$split = explode(" ", $text);
		$first_name = $split[0];
		$last_name = $split[1];
		$results = User::select("id", "first_name", "last_name", "mobile_number", "email")
			->where('first_name', 'LIKE', "%{$first_name}%")
			->orWhere('last_name', 'LIKE', "%{$last_name}%")
			->get();
		return view('backend.profile.profile_search_result', [
			'page_title' => $this->page_title,
			'page_header' => 'Search Result',
			'main_menu' => 'dispatch',
		], with(compact('results')));
	}
	public function others_profile($others_id = null)
	{
		$result =	DB::table('users')->where('id', $others_id)->first();
		$user_profileInfo =	DB::table('users_personalinfo')->where('user_id', $others_id)->first();
		$users_bankinfo =	DB::table('users_bankinfo')->where('user_id', $others_id)->first();
		// ->leftJoin('users_personalinfo', 'users.id', '=', 'users_personalinfo.user_id')
		// ->leftJoin('users_bankinfo', 'users_personalinfo.user_id', '=', 'users_bankinfo.user_id')->where('users_bankinfo.user_id',Auth::user()->id)
		// ->first();
		$documents = 	DB::table('users_documents')->where('user_id', $others_id)->get();
		// $result = DB::table('users_personalinfo')->where('user_id',Auth::user()->id)->first();    
		return view('backend.common.others_profile', [
			'page_title' => $this->page_title,
			'page_header' => 'Profile',
			'main_menu' => 'dispatch',
		], with(compact('result', 'documents', 'user_profileInfo', 'users_bankinfo')));
	}
}