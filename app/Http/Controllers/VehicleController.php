<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VehicleController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    /** List all vehicles */
    public function index()
    {
        $vehicles = Auth::guard('admin')->check()
            ? DB::table('users_vehicle')->orderByDesc('id')->get()
            : DB::table('users_vehicle')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();

        $vehicle_type = DB::table('vehicle_type')->orderByDesc('id')->get();
        $vehicle_make = DB::table('vehicle_make')->orderByDesc('id')->get();
        $vehicle_model = DB::table('vehicle_model')->orderByDesc('id')->get();
        $vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderByDesc('id')->get();
        $drivers = DB::table('users')->where('user_type', 'Driver')->orderByDesc('id')->get();

        return view('backend.drivers_vehicle.indexForAdmin', compact(
            'vehicles', 'vehicle_type', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers'
        ))->with([
            'page_title' => $this->page_title,
            'page_header'=> 'Vehicle',
            'main_menu'  => 'settings',
        ]);
    }

    /** Show create vehicle form */
    public function create()
    {
        $vehicle_type = DB::table('vehicle_type')->orderByDesc('id')->get();
        $vehicle_make = DB::table('vehicle_make')->orderByDesc('id')->get();
        $vehicle_model = DB::table('vehicle_model')->orderByDesc('id')->get();
        $vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderByDesc('id')->get();
        $drivers = DB::table('users')->where('user_type', 'Driver')->orderByDesc('id')->get();

        return view('backend.drivers_vehicle.add', compact(
            'vehicle_type', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers'
        ))->with([
            'page_title' => $this->page_title,
            'page_header'=> 'Add New Vehicle',
            'main_menu'  => 'admin',
        ]);
    }

    /** Store a new vehicle */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|unique:users_vehicle,license_plate',
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

        $license_plate = $validated['license_plate'];

        // Prevent duplicate per user
        if (DB::table('users_vehicle')->where('user_id', Auth::user()->id)->where('license_plate', $license_plate)->exists()) {
            return redirect()->back()->with([
                'status' => 'Vehicle Information Already Exists',
                'alert-type' => 'error'
            ]);
        }

        $post = $validated;
        $post['user_id'] = Auth::user()->id;
        $post['created_at'] = Carbon::now();

        // Ensure make/type exist
        if (!DB::table('vehicle_make')->where('make_vehicle_name', $post['make'])->exists()) {
            DB::table('vehicle_make')->insert(['make_vehicle_name' => $post['make'], 'status' => 'Active']);
        }
        if (!DB::table('vehicle_type')->where('vehicle_type_name', $post['vehicle_type'])->exists()) {
            DB::table('vehicle_type')->insert(['vehicle_type_name' => $post['vehicle_type'], 'status' => 'Active']);
        }

        DB::table('users_vehicle')->insert($post);

        return redirect()->route('vehicle_list')->with([
            'status' => 'Vehicle Information Saved Successfully',
            'alert-type' => 'success'
        ]);
    }

    /** Show edit vehicle form */
    public function edit($id)
    {
        $vehicle = DB::table('users_vehicle')->find($id);
        $vehicle_type = DB::table('vehicle_type')->orderByDesc('id')->get();
        $vehicle_make = DB::table('vehicle_make')->orderByDesc('id')->get();
        $vehicle_model = DB::table('vehicle_model')->orderByDesc('id')->get();
        $vehicle_classifications = DB::table('vehicle_classification')->where('status', 'Active')->orderByDesc('id')->get();
        $drivers = DB::table('users')->where('user_type', 'Driver')->orderByDesc('id')->get();

        return view('backend.drivers_vehicle.edit', compact(
            'vehicle', 'vehicle_type', 'vehicle_make', 'vehicle_model', 'vehicle_classifications', 'drivers'
        ))->with([
            'page_title' => $this->page_title,
            'page_header'=> 'Update Vehicle Information',
            'main_menu'  => 'admin',
        ]);
    }

    /** Update vehicle */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'vehicle_make_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_type' => 'required',
            'vehicle_name' => 'required',
            'is_active' => 'required',
            'color' => 'required',
            'registration_mark' => 'required',
            'mot' => 'required',
            'mot_expire_date' => 'required',
            'vehicle_classification_id' => 'required',
        ]);

        $validated['updated_at'] = Carbon::now();

        DB::table('users_vehicle')->where('id', $id)->update($validated);

        return redirect()->route('vehicle_list')->with([
            'status' => 'Vehicle Information Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /** Delete vehicle */
    public function destroy($id)
    {
        DB::table('users_vehicle')->where('id', $id)->delete();

        return redirect()->back()->with([
            'status' => 'Vehicle Information Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    /** Verify vehicle via RDW API */
    public function vehicle_check(Request $request)
    {
        $request->validate(['license_plate' => 'required']);

        $license_plate = str_replace([' ', '.', '-', ',', ', '], '', trim($request->license_plate));
        $contents = @file_get_contents("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=$license_plate");
        $dataResult = json_decode($contents);

        if (empty($dataResult)) {
            return redirect()->back()->with(['status' => 'Invalid License Plate Number', 'alert-type' => 'error']);
        }

        $vehicleData = (array)$dataResult[0];
        $vehicleData['user_id'] = Auth::user()->id;
        $vehicleData['created_at'] = Carbon::now();

        if (DB::table('users_vehicle')->where('user_id', Auth::user()->id)->where('license_plate', $vehicleData['kenteken'])->exists()) {
            return redirect()->back()->with(['status' => 'Vehicle Information Already Exists', 'alert-type' => 'error']);
        }

        DB::table('users_vehicle')->insert($vehicleData);

        return redirect()->route('vehicle_list')->with(['status' => 'Vehicle Information Saved Successfully', 'alert-type' => 'success']);
    }

    /** Verify VAT */
    public function vat_check(Request $request)
    {
        $request->validate(['vatNumber' => 'required']);

        $vatNumber = str_replace([' ', '.', '-', ',', ', '], '', trim($request->vatNumber));
        $contents = @file_get_contents("https://controleerbtwnummer.eu/api/validate/$vatNumber.json");
        $dataResult = json_decode($contents);

        if (!$dataResult->valid) {
            return redirect()->back()->with(['status' => 'Invalid VAT Number', 'alert-type' => 'error']);
        }

        $vatData = [
            'user_id' => Auth::user()->id,
            'company_name' => $dataResult->name,
            'vatNumber' => $dataResult->vatNumber,
            'address_street' => $dataResult->address->street,
            'address_number' => $dataResult->address->number,
            'address_zip_code' => $dataResult->address->zip_code,
            'address_city' => $dataResult->address->city,
            'address_country' => $dataResult->address->country,
            'countryCode' => $dataResult->countryCode,
            'strAddress' => $dataResult->strAddress,
            'isValid' => $dataResult->valid,
            'created_at' => Carbon::now()
        ];

        if (DB::table('users_company_vat')->where('user_id', Auth::user()->id)->where('vatNumber', $vatData['vatNumber'])->exists()) {
            return redirect()->back()->with(['status' => 'VAT Information Already Exists', 'alert-type' => 'error']);
        }

        DB::table('users_company_vat')->insert($vatData);

        return redirect()->route('vat_list')->with(['status' => 'VAT Information Saved Successfully', 'alert-type' => 'success']);
    }

    /** List VAT */
    public function vat_list()
    {
        $result = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();

        return view('backend.drivers_vehicle.vat_list', compact('result'))->with([
            'page_title' => $this->page_title,
            'page_header'=> 'VAT Information',
        ]);
    }
}