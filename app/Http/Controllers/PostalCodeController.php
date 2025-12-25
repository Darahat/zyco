<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class PostalCodeController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    /**
     * List all postal codes for the authenticated user
     */
    public function index()
    {
        $postalCodes = DB::table('users_postalcode')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('backend.postalCode.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Postal Information',
        ], compact('postalCodes'));
    }

    /**
     * Show form to add postal code
     */
    public function create()
    {
        return view('backend.postalCode.add', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Add Postal Information',
        ]);
    }

    /**
     * Store postal code using external API
     */
    public function store(Request $request)
    {
        $request->validate([
            'postcode' => 'required',
            'hnumber'  => 'required',
        ]);

        $userId = Auth::id();
        $postcode = $request->postcode;
        $hnumber  = $request->hnumber;

        // Check if postal code already exists
        $exists = DB::table('users_postalcode')
            ->where('user_id', $userId)
            ->where('postcode', $postcode)
            ->where('hnumber', $hnumber)
            ->exists();

        if ($exists) {
            return redirect()->route('postal_list')->with([
                'status' => 'Postal Information Already Exists',
                'alert-type' => 'error',
            ]);
        }

        // Call external API
        $tokenKey = "dbbb694d-13b6-4c9c-90be-10940e69fb39";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokenKey
        ])->get('https://postcode.tech/api/v1/postcode/full', [
            'postcode' => $postcode,
            'number'   => $hnumber,
        ]);

        if (!$response->successful() || empty($response->json())) {
            return redirect()->route('postal_list')->with([
                'status' => 'Invalid Postal Code or Number',
                'alert-type' => 'error',
            ]);
        }

        $data = $response->json();

        // Save to database
        DB::table('users_postalcode')->insert([
            'user_id'       => $userId,
            'postcode'      => $data['postcode'] ?? $postcode,
            'hnumber'       => $data['number'] ?? $hnumber,
            'street'        => $data['street'] ?? null,
            'city'          => $data['city'] ?? null,
            'municipality'  => $data['municipality'] ?? null,
            'province'      => $data['province'] ?? null,
            'geoLat'        => $data['geo']['lat'] ?? null,
            'geoLon'        => $data['geo']['lon'] ?? null,
        ]);

        return redirect()->route('postal_list')->with([
            'status' => 'Postal Information Saved Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $postal = DB::table('users_postalcode')->where('id', $id)->first();
        return view('backend.postalCode.edit', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Update Postal Information',
        ], compact('postal'));
    }

    /**
     * Update postal code
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'postcode' => 'required',
            'hnumber'  => 'required',
        ]);

        DB::table('users_postalcode')->where('id', $id)->update([
            'postcode'      => $request->postcode,
            'hnumber'       => $request->hnumber,
            'street'        => $request->street,
            'city'          => $request->city,
            'municipality'  => $request->municipality,
            'province'      => $request->province,
            'geoLat'        => $request->geoLat,
            'geoLon'        => $request->geoLon,
        ]);

        return redirect()->route('postal_list')->with([
            'status' => 'Postal Information Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Delete postal code
     */
    public function destroy($id)
    {
        DB::table('users_postalcode')->where('id', $id)->delete();

        return redirect()->back()->with([
            'status' => 'Postal Information Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }
}