<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class FeesController extends Controller
{
    protected string $page_title = 'Admin Panel';

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    /**
     * Fees list
     */
    public function index()
    {
        $result = DB::table('fees')
            ->orderByDesc('id')
            ->get();

        return view('backend.fees.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'admin',
            'page_header' => 'Fees',
            'result'      => $result,
        ]);
    }

    /**
     * Add new fees (GET + POST)
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('backend.fees.add', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin',
                'page_header' => 'Add New Fees',
            ]);
        }

        $validated = $request->validate([
            'name'   => 'required|string|max:255|unique:fees,name',
            'code'   => 'required|string|max:50|unique:fees,code',
            'symbol' => 'required|string|max:20|unique:fees,symbol',
            'rate'   => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        DB::table('fees')->insert($validated);

        return redirect()->back()->with([
            'status'     => 'Fees information saved successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Update fees (GET + POST)
     */
    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $result = DB::table('fees')->find($request->id);

            if (!$result) {
                return redirect()->back()->with([
                    'status'     => 'Fees not found',
                    'alert-type' => 'error',
                ]);
            }

            return view('backend.fees.edit', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'admin',
                'page_header' => 'Update Fees Information',
                'result'      => $result,
            ]);
        }

        $validated = $request->validate([
            'id'       => 'required|exists:fees,id',
            'rate'     => 'required|numeric',
            'fee_type' => 'required|string|max:50',
            'status'   => 'required|in:0,1',
        ]);

        DB::table('fees')
            ->where('id', $validated['id'])
            ->update([
                'rate'     => $validated['rate'],
                'fee_type' => $validated['fee_type'],
                'status'   => $validated['status'],
            ]);

        return redirect()->back()->with([
            'status'     => 'Fees updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Delete fees
     */
    public function delete(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->back()->with([
                'status'     => 'You are not allowed to access',
                'alert-type' => 'error',
            ]);
        }

        $fees = DB::table('fees')->find($request->id);

        if (!$fees) {
            return redirect()->back()->with([
                'status'     => 'Fees not found',
                'alert-type' => 'error',
            ]);
        }

        $userExists = DB::table('users')
            ->where('fees_code', $fees->code)
            ->exists();

        if ($userExists) {
            return redirect()->back()->with([
                'status'     => 'Some users are using this fees. Deletion not allowed.',
                'alert-type' => 'error',
            ]);
        }

        DB::table('fees')->where('id', $fees->id)->delete();

        return redirect()->back()->with([
            'status'     => 'Fees information deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}