<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use App\Models\User;

class ProfileController extends Controller
{
    protected string $page_title = 'Dispatcher Panel | User Profile';

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    // Dashboard or profile index
    public function index()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect("adminLoginForm")->with([
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            ]);
        }

        $countries = DB::table('country')->orderByDesc('id')->get();

        return view('backend.country.index', [
            'page_title' => $this->page_title,
            'page_header' => 'Country',
            'main_menu' => 'dispatch',
            'countries' => $countries
        ]);
    }

    // Show basic info update form
    public function updateBasicInfoForm()
    {
        $userId = Auth::id();
        $basicInfo     = DB::table('users')->find($userId);
        $personalInfo  = DB::table('users_personalinfo')->where('user_id', $userId)->first();
        $languages     = DB::table('language')->get();
        $time_zones    = DB::table('timezones')->get();

        return view('backend.profile.basic_update', compact(
            'basicInfo', 'personalInfo', 'languages', 'time_zones'
        ))->with([
            'page_title' => $this->page_title,
            'page_header' => 'Basic Update',
            'main_menu' => 'dispatch'
        ]);
    }

    // Update personal info
    public function updatePersonal(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'sex'              => 'required|string',
            'street_name'      => 'required|string',
            'personal_number'  => 'required|string',
            'personal_email'   => 'required|email',
            'emergency_number' => 'required|string',
            'name_title'       => 'required|string',
        ]);

        $personalData = $validated;
        $personalData['date_of_birth'] = $request->date_of_birth;
        $personalData['note_area'] = $request->note_area;

        // Handle driving license upload
        if ($request->hasFile('driving_license')) {
            $filename = 'driving_license_' . time() . '.' . $request->driving_license->extension();
            $request->driving_license->move(public_path('driving_licence'), $filename);
            $personalData['driving_license'] = $filename;
        }

        // Update personal info
        DB::table('users_personalinfo')->updateOrInsert(
            ['user_id' => $userId],
            $personalData
        );

        // Update basic name in users table
        DB::table('users')->where('id', $userId)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        return redirect()->back()->with([
            'status' => 'Data Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    // Update user account info
    public function updateBasicInfo(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'username'      => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile_number' => 'required|string',
            'password'      => 'required|string|min:6',
            'base_city'     => 'required|string',
            'alt_email'     => 'nullable|email',
        ]);

        $data = [
            'username'      => $request->username,
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => Hash::make($request->password),
            'base_city'     => $request->base_city,
            'alt_email'     => $request->alt_email,
            'time_zone'     => $request->time_zone,
            'language'      => $request->language,
        ];

        if ($request->filled('can_speak')) {
            $data['can_speak'] = implode(',', $request->can_speak);
        }

        DB::table('users')->where('id', $userId)->update($data);

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            $filename = 'profile_' . time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile'), $filename);

            DB::table('users_personalinfo')->updateOrInsert(
                ['user_id' => $userId],
                ['profile_picture' => $filename]
            );
        }

        return redirect()->back()->with([
            'status' => 'Data Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    // Update bank info
    public function updateBank(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'IBAN'                => 'required|string',
            'BIC'                 => 'required|string',
            'account_holder_name' => 'required|string',
        ]);

        DB::table('users_bankinfo')->updateOrInsert(
            ['user_id' => $userId],
            array_merge($validated, ['note_area' => $request->note_area])
        );

        return redirect()->back()->with([
            'status' => 'Bank Information Saved Successfully',
            'alert-type' => 'success'
        ]);
    }

    // Delete a country safely
    public function deleteCountry(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->back()->with([
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            ]);
        }

        $country = DB::table('country')->find($request->id);
        if (!$country) {
            return redirect()->back()->with([
                'status' => 'Country not found',
                'alert-type' => 'error'
            ]);
        }

        $userExists = DB::table('users')->where('country_code', $country->phone_code)->exists();

        if ($userExists) {
            return redirect()->back()->with([
                'status' => 'Some users are associated with this country. Cannot delete.',
                'alert-type' => 'error'
            ]);
        }

        DB::table('country')->where('id', $request->id)->delete();

        return redirect()->back()->with([
            'status' => 'Country Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    // Autocomplete users
    public function autocomplete(Request $request)
    {
        $query = $request->get('query', '');
        $users = User::select('first_name', 'last_name')
            ->where('first_name', 'like', "%{$query}%")
            ->get();

        return response()->json($users->map(fn($u) => "{$u->first_name} {$u->last_name}"));
    }

    // Search users by name
    public function searchResult(Request $request)
    {
        $text = $request->search;
        $split = explode(' ', $text);
        $first_name = $split[0] ?? '';
        $last_name  = $split[1] ?? '';

        $results = User::select('id', 'first_name', 'last_name', 'mobile_number', 'email')
            ->where('first_name', 'like', "%{$first_name}%")
            ->orWhere('last_name', 'like', "%{$last_name}%")
            ->get();

        return view('backend.profile.profile_search_result', compact('results'))
            ->with([
                'page_title'  => $this->page_title,
                'page_header' => 'Search Result',
                'main_menu'   => 'dispatch'
            ]);
    }

    // View another user's profile
    public function others_profile($others_id)
    {
        $user           = DB::table('users')->find($others_id);
        $personalInfo   = DB::table('users_personalinfo')->where('user_id', $others_id)->first();
        $bankInfo       = DB::table('users_bankinfo')->where('user_id', $others_id)->first();
        $documents      = DB::table('users_documents')->where('user_id', $others_id)->get();

        return view('backend.common.others_profile', compact(
            'user', 'personalInfo', 'bankInfo', 'documents'
        ))->with([
            'page_title'  => $this->page_title,
            'page_header' => 'Profile',
            'main_menu'   => 'dispatch'
        ]);
    }
}