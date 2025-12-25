<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class VehicleClassificationController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    // List all vehicle classifications
    public function index()
    {
        $this->authorizeAdmin();

        $result = DB::table('vehicle_classification')
            ->orderByDesc('id')
            ->get();

        return view('backend.vehicle_classification.index', compact('result'))
            ->with([
                'page_title' => $this->page_title,
                'main_menu'  => 'admin',
                'page_header'=> 'Vehicle Classification',
            ]);
    }

    // Show form to add new classification
    public function create()
    {
        $this->authorizeAdmin();

        return view('backend.vehicle_classification.add')
            ->with([
                'page_title' => $this->page_title,
                'main_menu'  => 'admin',
                'page_header'=> 'Add New Vehicle Classification',
            ]);
    }

    // Store new classification
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'classification_name'       => 'required|unique:vehicle_classification,classification_name',
            'status'                    => 'required',
            'classification_badge_icon' => 'required|image|mimes:png,jpeg,jpg|max:500',
        ]);

        // Handle badge icon upload
        $badgeIconName = 'badge_icon_' . time() . '.' . $request->classification_badge_icon->extension();
        $request->classification_badge_icon->move(public_path('vehicle_classification'), $badgeIconName);

        $insertData = DB::table('vehicle_classification')->insert([
            'classification_name' => $validated['classification_name'],
            'status'              => $validated['status'],
            'badge_icon'          => $badgeIconName,
            'created_at'          => Carbon::now(),
        ]);

        return redirect()->back()->with([
            'status'     => $insertData ? 'Vehicle Classification Saved Successfully' : 'Failed to save Vehicle Classification',
            'alert-type' => $insertData ? 'success' : 'error',
        ]);
    }

    // Show form to edit classification
    public function edit($id)
    {
        $this->authorizeAdmin();

        $result = DB::table('vehicle_classification')->find($id);

        return view('backend.vehicle_classification.edit', compact('result'))
            ->with([
                'page_title' => $this->page_title,
                'main_menu'  => 'admin',
                'page_header'=> 'Update Vehicle Classification',
            ]);
    }

    // Update classification
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'classification_name' => 'required|unique:vehicle_classification,classification_name,' . $id,
            'status'              => 'required',
        ]);

        DB::table('vehicle_classification')
            ->where('id', $id)
            ->update([
                'classification_name' => $validated['classification_name'],
                'status'              => $validated['status'],
                'updated_at'          => Carbon::now(),
            ]);

        return redirect()->back()->with([
            'status'     => 'Vehicle Classification Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    // Delete classification
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $vehicleExists = DB::table('users_vehicle')
            ->where('vehicle_classification_id', $id)
            ->exists();

        if ($vehicleExists) {
            return redirect()->back()->with([
                'status'     => 'Some vehicles have this classification. Cannot delete.',
                'alert-type' => 'error',
            ]);
        }

        DB::table('vehicle_classification')->where('id', $id)->delete();

        return redirect()->back()->with([
            'status'     => 'Vehicle Classification Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }

    // Helper function to check admin
    private function authorizeAdmin()
    {
        if (!Auth::guard('admin')->check()) {
            redirect('adminLoginForm')->with([
                'status' => 'You are not allowed to access',
                'alert-type' => 'error',
            ])->send();
            exit;
        }
    }
}