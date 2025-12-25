<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();

        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect()->route('login')->with([
                    'status' => 'You are not allowed to access',
                    'alert-type' => 'error',
                ]);
            }
            return $next($request);
        });
    }

    /* ===================== COMPANY LIST ===================== */
    public function index()
    {
        $result = DB::table('users_companyinfo')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('backend.company.index', [
            'page_title'  => $this->page_title,
            'page_header' => 'Company Info',
            'result'      => $result,
        ]);
    }

    /* ===================== ADD COMPANY ===================== */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('backend.company.add', [
                'page_title' => $this->page_title,
                'page_header' => 'Add New Company',
            ]);
        }

        $request->validate([
            'kvkNumber' => 'required|string|max:50',
        ]);

        $kvkNumber = preg_replace('/[^0-9]/', '', $request->kvkNumber);

        // API call (SAFE)
        $response = Http::timeout(10)->get(
            "https://developers.kvk.nl/test/api/v1/basisprofielen/{$kvkNumber}",
            ['geoData' => 'true']
        );

        if (!$response->successful()) {
            return back()->with([
                'status' => 'Invalid KVK number',
                'alert-type' => 'error',
            ]);
        }

        $data = $response->object();

        $exists = DB::table('users_companyinfo')
            ->where('user_id', Auth::id())
            ->where('kvkNumber', $kvkNumber)
            ->exists();

        if ($exists) {
            return back()->with([
                'status' => 'Company information already exists',
                'alert-type' => 'error',
            ]);
        }

        DB::table('users_companyinfo')->insert([
            'user_id' => Auth::id(),
            'kvkNumber' => $data->kvkNummer ?? null,
            'name' => $data->naam ?? null,
            'indNonMailing' => $data->indNonMailing ?? null,
            'uniqueCompanyId' => Auth::id() . random_int(100, 999),
            'formalRegistrationDate' => $data->formeleRegistratiedatum ?? null,
            'totalEmployedPersons' => $data->totaalWerkzamePersonen ?? null,
        ]);

        return back()->with([
            'status' => 'Company information saved successfully',
            'alert-type' => 'success',
        ]);
    }

    /* ===================== UPDATE COMPANY ===================== */
    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $result = DB::table('users_companyinfo')->find($request->id);

            if (!$result) {
                return back()->with([
                    'status' => 'Company not found',
                    'alert-type' => 'error',
                ]);
            }

            return view('backend.company.edit', [
                'page_title' => $this->page_title,
                'page_header' => 'Update Company Information',
                'result' => $result,
            ]);
        }

        $validated = $request->validate([
            'id' => 'required|exists:users_companyinfo,id',
            'kvkNumber' => 'required',
            'company_name' => 'required',
        ]);

        DB::table('users_companyinfo')
            ->where('id', $validated['id'])
            ->update([
                'kvkNumber' => $request->kvkNumber,
                'name' => $request->company_name,
                'email' => $request->email,
                'notes' => $request->notes,
            ]);

        return back()->with([
            'status' => 'Data updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /* ===================== DELETE COMPANY ===================== */
    public function delete(Request $request)
    {
        $row = DB::table('users_companyinfo')->find($request->id);

        if (!$row) {
            return back()->with([
                'status' => 'Company info not found',
                'alert-type' => 'error',
            ]);
        }

        DB::table('users_companyinfo')->where('id', $row->id)->delete();

        return back()->with([
            'status' => 'Company information deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /* ===================== VAT LIST ===================== */
    public function vat_list()
    {
        $result = DB::table('users_company_vat')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('backend.company.vat_list', [
            'page_title' => $this->page_title,
            'page_header' => 'VAT Information',
            'result' => $result,
        ]);
    }

    /* ===================== DELETE VAT ===================== */
    public function delete_vat(Request $request)
    {
        $vat = DB::table('users_company_vat')->find($request->id);

        if (!$vat) {
            return back()->with([
                'status' => 'VAT record not found',
                'alert-type' => 'error',
            ]);
        }

        DB::table('users_company_vat')->where('id', $vat->id)->delete();

        return back()->with([
            'status' => 'VAT information deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}