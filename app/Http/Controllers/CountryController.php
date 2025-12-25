<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        // Global settings
        Paginator::useBootstrap();

        // Admin guard protection
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('admin')->check()) {
                return redirect('adminLoginForm')->with([
                    'status'     => 'You are not allowed to access',
                    'alert-type' => 'error',
                ]);
            }
            return $next($request);
        });
    }

    /**
     * Country list
     */
    public function index()
    {
        $result = DB::table('country')
            ->orderByDesc('id')
            ->get();

        return view('backend.country.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Country',
            'result'      => $result,
        ]);
    }

    /**
     * Add new country (GET + POST)
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('backend.country.add', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin',
                'page_header' => 'Add New Country',
            ]);
        }

        $validated = $request->validate([
            'short_name' => 'required|string|max:100|unique:country,short_name',
            'long_name'  => 'required|string|max:150|unique:country,long_name',
            'iso3'       => 'nullable|string|max:3',
            'num_code'   => 'nullable|numeric',
            'phone_code' => 'required|string|max:10',
        ]);

        DB::table('country')->insert($validated);

        return redirect('admin/country')->with([
            'status'     => 'Country information saved successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Update country (GET + POST)
     */
    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $result = DB::table('country')->find($request->id);

            if (!$result) {
                return redirect()->back()->with([
                    'status'     => 'Country not found',
                    'alert-type' => 'error',
                ]);
            }

            return view('backend.country.edit', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin',
                'page_header' => 'Update Country Information',
                'result'      => $result,
            ]);
        }

        $validated = $request->validate([
            'id' => ['required', 'exists:country,id'],
            'short_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('country', 'short_name')->ignore($request->id),
            ],
            'long_name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('country', 'long_name')->ignore($request->id),
            ],
            'iso3'       => 'nullable|string|max:3',
            'num_code'   => 'nullable|numeric',
            'phone_code' => 'required|string|max:10',
        ]);

        DB::table('country')
            ->where('id', $validated['id'])
            ->update([
                'short_name' => $validated['short_name'],
                'long_name'  => $validated['long_name'],
                'iso3'       => $validated['iso3'] ?? null,
                'num_code'   => $validated['num_code'] ?? null,
                'phone_code' => $validated['phone_code'],
            ]);

        return redirect('admin/country')->with([
            'status'     => 'Country information updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Delete country
     */
    public function delete(Request $request)
    {
        $country = DB::table('country')->find($request->id);

        if (!$country) {
            return redirect()->back()->with([
                'status'     => 'Country not found',
                'alert-type' => 'error',
            ]);
        }

        $userExists = DB::table('users')
            ->where('country_code', $country->phone_code)
            ->exists();

        if ($userExists) {
            return redirect()->back()->with([
                'status'     => 'Some users are using this country. Deletion not allowed.',
                'alert-type' => 'error',
            ]);
        }

        DB::table('country')->where('id', $country->id)->delete();

        return redirect()->back()->with([
            'status'     => 'Country information deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}