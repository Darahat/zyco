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



class VehicleController extends Controller

{

	public function __construct()
	{

		$this->page_title = 'Admin Panel';
	}

	public function index()
	{



		$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();

		$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();

		$vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();

		$vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderBy('id', 'DESC')->get();

		$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();


		$vehicleInfo = DB::table('users_vehicle')->orderBy('id', 'DESC')->get();

		Paginator::useBootstrap();
		if (Auth::guard('admin')->check()) {
			$vehicleInfo = DB::table('users_vehicle')->orderBy('id', 'DESC')->get();
		} else {
			$vehicleInfo = DB::table('users_vehicle')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		}
		return view('backend.drivers_vehicle.indexForAdmin', [

			'page_title' => $this->page_title,

			'page_header' => 'Vehicle',

			'main_menu' => 'settings',

		], with(compact('vehicleInfo', 'vehicle_type', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers')));
	}
	public function indexadmin()
	{



		$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();

		$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();

		$vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();

		$vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderBy('id', 'DESC')->get();

		$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();


		$vehicleInfo = DB::table('users_vehicle')->orderBy('id', 'DESC')->get();

		Paginator::useBootstrap();
		if (Auth::guard('admin')->check()) {
			$vehicleInfo = DB::table('users_vehicle')->orderBy('id', 'DESC')->get();
		} else {
			$vehicleInfo = DB::table('users_vehicle')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		}
		return view('backend.drivers_vehicle.indexForAdmin', [

			'page_title' => $this->page_title,

			'page_header' => 'Vehicle',

			'main_menu' => 'informations',

		], with(compact('vehicleInfo', 'vehicle_type', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers')));
	}
	public function getDetails(Request $request)
	{

		$data = array();



		$detailsData = DB::table($request->table_name)->where('id', $request->id)->get();



		$data['$detailsData'] = $detailsData;

		return $data;
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

	// public function imageChange(Request $request)
	// {

	// 	dd($request->all);
	// 	exit;

	// 	$validatedData = $request->validate([

	// 		'field'      => 'required',

	// 		'image' => 'required|image|mimes:png,jpeg,jpg|max:1000',

	// 		'table_name' => 'required',

	// 		'id'         => 'required'

	// 	]);


	// 	$imageName = $request->table_name . '' . time() . '.' . $request->image->extension();



	// 	$post[$request->field] = $imageName;



	// 	$UpdateData = DB::table($request->table_name)->where('id', $request->id)->update($post);



	// 	$request->image->move(public_path($request->table_name), $imageName);



	// 	if ($UpdateData) {

	// 		$notification = array(

	// 			'status' => 'Image Saved Successfully',

	// 			'alert-type' => 'success'

	// 		);

	// 		return redirect()->back()->with($notification);
	// 	} else {

	// 		$notification = array(

	// 			'status' => 'Image Save failed',

	// 			'alert-type' => 'error'

	// 		);

	// 		return redirect()->back()->with($notification);
	// 	}
	// }

	public function vehicle_setup(Request $request)
	{



		$vehicles_classification = DB::table('vehicle_classification')->orderBy('id', 'DESC')->get();

		$vehicles_make = DB::table('vehicle_make')->orderBy('make_vehicle_name')->get();

		$vehicles_model = DB::table('vehicle_model')->join('vehicle_make', 'vehicle_model.vehicle_make_id', '=', 'vehicle_make.id')->orderBy('model_name')->get(['vehicle_model.*', 'vehicle_make.make_vehicle_name']);

		$vehicles_type = DB::table('vehicle_type')->join('vehicle_classification', 'vehicle_classification.id', '=', 'vehicle_type.vehicle_classification_id')->orderBy('vehicle_type_name')->get(['vehicle_type.*', 'vehicle_classification.classification_name']);

		$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();



		return view('backend.vehicle_tab', [

			'page_title' => $this->page_title,

			'page_header' => 'Vehicle',

			'main_menu' => 'admin_settings',

		], with(compact('vehicles_classification', 'vehicles_make', 'vehicles_model', 'vehicles_type', 'drivers')));
	}

	/**
				
	 * Add a New Vehicle
				
	 *
				
	 * @param array $request  Input values
				
	 * @return redirect     to vehicle view
				
	 */

	public function add(Request $request)

	{



		if (!$_POST) {

			$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();

			$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();

			$vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();

			$vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderBy('id', 'DESC')->get();

			$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();



			return view('backend.drivers_vehicle.add', [

				'page_title' => $this->page_title,

				'page_header' => 'Add New Vehicle',

				'main_menu' => 'admin',

			], with(compact('vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers', 'vehicle_type')));
		} else if ($request->submit) {
			$validatedData = $request->validate([

				'license_plate' => 'required',

				'vehicle_type' => 'required',

				'make' => 'required',

				'trade_name' => 'required',

				'device' => 'required',

				'is_active' => 'required',

				'first_color' => 'required',

				'number_cylinders' => 'required',

				'number_doors' => 'required',

				'number_wheels' => 'required',

				'mass_empty_vehicle' => 'required',

				'mass_roadworthy' => 'required',

				'length' => 'required',

				'width' => 'required',

				'taxi_indicator' => 'required',

			]);

			if ($request) :

				$post['user_id'] = Auth::user()->id;
				$license_plate = $request->license_plate;

				$dataExist = DB::table('users_vehicle')->where('user_id', Auth::user()->id)->where('license_plate', $license_plate)->get();

				if (empty($dataExist)) :
					$notification = array(
						'status' => 'Vehicle Information Already Exist',
						'alert-type' => 'error'
					);
				else :
					$vehicle_type = $request->vehicle_type;
					$make         = $request->make;


					$post['license_plate'] = $license_plate;
					$post['vehicle_type'] = $vehicle_type;
					$post['make']         = $make;
					$post['trade_name']  = $request->trade_name;
					$post['date_name']   = $request->date_name;
					$post['device']      = $request->device;
					$post['first_color'] = $request->first_color;
					$post['second_color'] = $request->second_color;
					$post['number_cylinders'] = $request->number_cylinders;
					$post['mass_empty_vehicle'] = $request->mass_empty_vehicle;
					$post['mass_roadworthy'] = $request->mass_roadworthy;
					$post['date_first_admission'] = $request->date_first_admission;
					$post['date_first_name_in_the_netherlands'] = $request->date_first_name_in_the_netherlands;
					$post['waiting_for_approval'] = $request->waiting_for_approval;
					$post['wam_insured'] = $request->wam_insured;
					$post['number_doors'] = $request->number_doors;
					$post['number_wheels'] = $request->number_wheels;
					$post['distance_center_link_to_rear_vehicle'] = $request->distance_center_link_to_rear_vehicle;
					$post['distance_front_vehicle_to_centre_link'] = $request->distance_front_vehicle_to_centre_link;
					$post['length'] = $request->length;
					$post['width'] = $request->width;
					$post['european_vehicle_category'] = $request->european_vehicle_category;
					$post['technical_max_mass_vehicle'] = $request->technical_max_mass_vehicle;
					$post['sequential_number_change_eu_type_approval'] = $request->sequential_number_change_eu_type_approval;
					$post['power_mass_ready'] = $request->power_mass_ready;
					$post['wheelbase'] = $request->wheelbase;
					$post['export_indicator'] = $request->export_indicator;
					$post['pending_recall_indicator'] = $request->pending_recall_indicator;
					$post['taxi_indicator'] = $request->taxi_indicator;
					$post['maximum_mass_composition'] = $request->maximum_mass_composition;
					$post['year_last_registration_counter_reading'] = $request->year_last_registration_counter_reading;
					$post['counter_reading_judgment'] = $request->counter_reading_judgment;
					$post['code_explanation_counter_reading'] = $request->code_explanation_counter_reading;
					$post['name_possible'] = $request->name_possible;
					$post['date_name_dt'] = $request->date_name_dt;
					$post['date_first_admission_dt'] = $request->date_first_admission_dt;
					$post['date_first_name_in_nederland_dt'] = $request->date_first_name_in_nederland_dt;
					$post['date_first_name_in_the_netherlands'] = $request->date_first_name_in_the_netherlands;
					$post['api_gekentekende_mobielen_assen'] = $request->api_gekentekende_mobielen_assen;
					$post['api_gekentekende_mobielen_fuel'] = $request->api_gekentekende_mobielen_fuel;
					$post['api_gekentekende_mobielen_carrosserie'] = $request->api_gekentekende_mobielen_carrosserie;
					$post['api_gekentekende_mobielen_carrosserie_specific'] = $request->api_gekentekende_mobielen_carrosserie_specific;
					$post['api_gekentekende_mobielen_mobielklasse'] = $request->api_gekentekende_mobielen_mobielklasse;
					$vehicleMake = DB::table('vehicle_make')->where('make_vehicle_name', $make)->get();

					// $vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();
					$vehicleType = DB::table('vehicle_type')->where('vehicle_type_name', $vehicle_type)->get();

					if (empty($vehicleMake)) :
					else :
						$post2 = array();
						$post2['make_vehicle_name'] = $make;
						$post2['status'] = 'Active';
						$insert2Data = DB::table('vehicle_make')->insert($post2);
					endif;

					if ($vehicleType) :
					else :
						$post3 = array();
						$post3['vehicle_type_name'] = $vehicle_type;
						$post3['status'] = 'Active';
						$insert3Data = DB::table('vehicle_type')->insert($post3);
					endif;

					$insertData = DB::table('users_vehicle')->insert($post);


					$notification = array(
						'status' => 'Vehicle Information Saved Successfully',
						'alert-type' => 'success'
					);

				endif;
			else :
				$notification = array(
					'status' => 'Invalid Licence Plate Number',
					'alert-type' => 'error'
				);


			endif;
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
				
	 * Update vehicle Details
				
	 *
				
	 * @param array $request    Input values
				
	 * @return redirect     to vehicle View
				
	 */

	public function update(Request $request)

	{

		if (!$_POST) {

			$vehicle_make = DB::table('vehicle_make')->orderBy('id', 'DESC')->get();

			$vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();

			$vehicle_type = DB::table('vehicle_type')->orderBy('id', 'DESC')->get();



			$vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderBy('id', 'DESC')->get();

			$drivers = DB::table('users')->where('user_type', 'Driver')->orderBy('id', 'DESC')->get();

			$result = DB::table('users_vehicle')->where('id', $request->id)->first();



			return view('backend.drivers_vehicle.edit', [

				'page_title' => $this->page_title,

				'page_header' => 'Update Vehicle Information',
				'main_menu' => 'admin',

			], with(compact('result', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers', 'vehicle_type')));
		} else if ($request->submit) {

			dd($request->all());

			$validatedData = $request->validate([

				'vehicle_make_id' => 'required',

				'vehicle_model_id' => 'required',

				'vehicle_id' => 'required',

				'vehicle_type' => 'required',

				'vehicle_name' => 'required',

				'is_active' => 'required',

				'color' => 'required',

				'vehicle_Image' => 'required',

				'registration_mark' => 'required',

				'mot' => 'required',

				'mot_expire_date' => 'required',

				'vehicle_classification_id' => 'required',

				'reg_keeper_address' => 'required',

				'body_type' => 'required',

				'passenger_capacity' => 'required',

				'reg_keeper_name' => 'required',

			]);



			//return response()->json( $validatedData );



			$id = $request->id;

			$post = array();

			if (Auth::guard('admin')->check()) {

				$post['user_id '] = $request->user_id;
			} else {

				$post['user_id '] = Auth::user()->id;
			}



			$post['vehicle_make_id'] = $request->vehicle_make_id;

			$post['vehicle_model_id'] = $request->vehicle_model_id;

			$post['vehicle_id'] = $request->vehicle_id;

			$post['vehicle_type'] = $request->vehicle_type;

			$post['vehicle_name'] = $request->vehicle_name;

			$post['is_active'] = $request->is_active;

			$post['color'] = $request->color;

			$post['vehicle_image'] = $request->vehicle_image;

			$post['registration_mark'] = $request->registration_mark;

			$post['mot'] = $request->mot;

			$post['mot_expire_date'] = $request->mot_expire_date;

			$post['vehicle_classification_id'] = $request->vehicle_classification_id;

			$post['reg_keeper_address'] = $request->reg_keeper_address;

			$post['body_type'] = $request->body_type;

			$post['passenger_capacity'] = $request->passenger_capacity;

			$post['reg_keeper_name'] = $request->reg_keeper_name;

			$UpdateData = DB::table('users_vehicle')->where('id', $id)->update($post);



			$notification = array(

				'status' => 'Data Updated Successfully',

				'alert-type' => 'success'

			);

			return redirect()->route('vehicle_list')->with($notification);
		}
	}



	/**
				
	 * Delete vehicle
				
	 *
				
	 * @param array $request    Input values
				
	 * @return redirect     to vehicle View
				
	 */

	public function delete(Request $request)

	{









		$vehicleData = DB::table('users_vehicle')->where('id', $request->id)->first();



		// $user = DB::table('users')->where('vehicle_code',$vehicle_code)->first();



		// if($user){

		// $notification = array(

		// 	'status' => 'Some User have this Vehicle. So, We cannot delete the vehicle.',

		// 	'alert-type' => 'error'

		// );

		// }else{

		$delete = DB::table('users_vehicle')->where('id', $request->id)->delete();

		$notification = array(

			'status' => 'Vehicle Information Deleted Successfully',

			'alert-type' => 'success'

		);

		// }



		return redirect()->back()->with($notification);
	}

	public function vehicle_check(Request $request)
	{


		if (!$_POST) {
			return view('backend.drivers_vehicle.vehicle_check', [

				'page_title' => $this->page_title,
				'page_header' => 'Verify Vehicle Information',
				'main_menu' => 'admin',
			]);
		} else if ($request->submit) {

			$validatedData = $request->validate(['license_plate' => 'required']);
			$post['user_id'] = Auth::user()->id;
			$license_plate = $request->license_plate;
			$kenteken = str_replace(array(' ', '.', '-', ',', ', '), '', trim($license_plate));

			$contents = @file_get_contents('https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=' . $kenteken);
			$dataResult = json_decode($contents);


			if (count($dataResult)) :

				$license_plate2 = $dataResult[0]->kenteken;
				$dataExist = DB::table('users_vehicle')->where('user_id', Auth::user()->id)->where('license_plate', $license_plate2)->get();

				if (count($dataExist)) :
					$notification = array(
						'status' => 'Vehicle Information Already Exist',
						'alert-type' => 'error'
					);
				else :
					$vehicle_type = $dataResult[0]->voertuigsoort;
					$make         = $dataResult[0]->merk;


					$post['license_plate'] = $license_plate2;
					$post['vehicle_type'] = $vehicle_type;
					$post['make']         = $make;
					$post['trade_name']  = $dataResult[0]->handelsbenaming;
					$post['date_name']   = $dataResult[0]->datum_tenaamstelling;
					$post['device']      = $dataResult[0]->inrichting;
					$post['first_color'] = $dataResult[0]->eerste_kleur;
					$post['second_color'] = $dataResult[0]->tweede_kleur;
					$post['number_cylinders'] = $dataResult[0]->aantal_cilinders;
					$post['mass_empty_vehicle'] = $dataResult[0]->massa_ledig_voertuig;
					$post['mass_roadworthy'] = $dataResult[0]->massa_rijklaar;
					$post['date_first_admission'] = $dataResult[0]->datum_eerste_toelating;
					$post['date_first_name_in_the_netherlands'] = $dataResult[0]->datum_eerste_tenaamstelling_in_nederland;
					$post['waiting_for_approval'] = $dataResult[0]->wacht_op_keuren;
					$post['wam_insured'] = $dataResult[0]->wam_verzekerd;
					$post['number_doors'] = $dataResult[0]->aantal_deuren;
					$post['number_wheels'] = $dataResult[0]->aantal_wielen;
					$post['distance_center_link_to_rear_vehicle'] = $dataResult[0]->afstand_hart_koppeling_tot_achterzijde_voertuig;
					$post['distance_front_vehicle_to_centre_link'] = $dataResult[0]->afstand_voorzijde_voertuig_tot_hart_koppeling;
					$post['length'] = $dataResult[0]->lengte;
					$post['width'] = $dataResult[0]->breedte;
					$post['european_vehicle_category'] = $dataResult[0]->europese_voertuigcategorie;
					$post['technical_max_mass_vehicle'] = $dataResult[0]->technische_max_massa_voertuig;
					$post['sequential_number_change_eu_type_approval'] = $dataResult[0]->volgnummer_wijziging_eu_typegoedkeuring;
					$post['power_mass_ready'] = $dataResult[0]->vermogen_massarijklaar;
					$post['wheelbase'] = $dataResult[0]->wielbasis;
					$post['export_indicator'] = $dataResult[0]->export_indicator;
					$post['pending_recall_indicator'] = $dataResult[0]->openstaande_terugroepactie_indicator;
					$post['taxi_indicator'] = $dataResult[0]->taxi_indicator;
					$post['maximum_mass_composition'] = $dataResult[0]->maximum_massa_samenstelling;
					$post['year_last_registration_counter_reading'] = $dataResult[0]->jaar_laatste_registratie_tellerstand;
					$post['counter_reading_judgment'] = $dataResult[0]->tellerstandoordeel;
					$post['code_explanation_counter_reading'] = $dataResult[0]->code_toelichting_tellerstandoordeel;
					$post['name_possible'] = $dataResult[0]->tenaamstellen_mogelijk;
					$post['date_name_dt'] = $dataResult[0]->datum_tenaamstelling_dt;
					$post['date_first_admission_dt'] = $dataResult[0]->datum_tenaamstelling_dt;
					$post['date_first_name_in_nederland_dt'] = $dataResult[0]->datum_eerste_toelating_dt;
					$post['date_first_name_in_the_netherlands'] = $dataResult[0]->datum_eerste_tenaamstelling_in_nederland_dt;
					$post['api_gekentekende_mobielen_assen'] = $dataResult[0]->api_gekentekende_voertuigen_assen;
					$post['api_gekentekende_mobielen_fuel'] = $dataResult[0]->api_gekentekende_voertuigen_brandstof;
					$post['api_gekentekende_mobielen_carrosserie'] = $dataResult[0]->api_gekentekende_voertuigen_carrosserie;
					$post['api_gekentekende_mobielen_carrosserie_specific'] = $dataResult[0]->api_gekentekende_voertuigen_carrosserie_specifiek;
					$post['api_gekentekende_mobielen_mobielklasse'] = $dataResult[0]->api_gekentekende_voertuigen_voertuigklasse;

					$vehicleMake = DB::table('vehicle_make')->where('make_vehicle_name', $make)->get();
					// $vehicle_model = DB::table('vehicle_model')->orderBy('id', 'DESC')->get();
					$vehicleType = DB::table('vehicle_type')->where('vehicle_type_name', $vehicle_type)->get();
					if (count($vehicleMake)) :
					else :
						$post2 = array();
						$post2['make_vehicle_name'] = $make;
						$post2['status'] = 'Active';
						$insert2Data = DB::table('vehicle_make')->insert($post2);
					endif;

					if (count($vehicleType)) :
					else :
						$post3 = array();
						$post3['vehicle_type_name'] = $vehicle_type;
						$post3['status'] = 'Active';
						$insert3Data = DB::table('vehicle_type')->insert($post3);
					endif;

					$insertData = DB::table('users_vehicle')->insert($post);
					$notification = array(
						'status' => 'Vehicle Information Saved Successfully',
						'alert-type' => 'success'
					);

				endif;
			else :
				$notification = array(
					'status' => 'Invalid Licence Plate Number',
					'alert-type' => 'error'
				);

			endif;

			return redirect()->route('vehicle_list')->with($notification);
		}
	}


	public function vat_check(Request $request)
	{


		if (!$_POST) {
			return view('backend.drivers_vehicle.vat_check', [

				'page_title' => $this->page_title,
				'page_header' => 'Verify Vat Information',
				'main_menu' => 'admin',
			]);
		} else if ($request->submit) {

			$validatedData = $request->validate(['vatNumber' => 'required']);
			$post['user_id'] = Auth::user()->id;
			$vatNumber = $request->vatNumber;
			$vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
			$contents = @file_get_contents('https://controleerbtwnummer.eu/api/validate/' . $vatNumber . '.json');
			$dataResult = json_decode($contents);
			//print_r($dataResult); exit;
			if ($dataResult->valid) :

				$vatNumber2 = $dataResult->vatNumber;
				$dataExist = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->where('vatNumber', $vatNumber2)->get();

				if (count($dataExist)) :
					$notification = array(
						'status' => 'Vat Information Already Exist',
						'alert-type' => 'error'
					);
				else :

					$post['company_name'] = $dataResult->name;
					$post['address_street'] = $dataResult->address->street;
					$post['countryCode']  = $dataResult->countryCode;
					$post['vatNumber']   = $vatNumber2;
					$post['address_number']      = $dataResult->address->number;
					$post['address_zip_code'] = $dataResult->address->zip_code;
					$post['address_city'] = $dataResult->address->city;
					$post['address_country'] = $dataResult->address->country;
					$post['strAddress'] = $dataResult->strAddress;
					$post['isValid'] = $dataResult->valid;

					$insertData = DB::table('users_company_vat')->insert($post);
					$notification = array(
						'status' => 'Vat Information Saved Successfully',
						'alert-type' => 'success'
					);

				endif;
			else :
				$notification = array(
					'status' => 'Invalid Vat Number',
					'alert-type' => 'error'
				);

			endif;

			return redirect()->route('vat_list')->with($notification);
		}
	}

	public function vat_list()
	{


		Paginator::useBootstrap();
		$result = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

		return view('backend.drivers_vehicle.vat_list', [
			'page_title' => $this->page_title,
			'page_header' => 'Vat Information',


		], with(compact('result')));
	}
}