<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

				class CurrencyController extends Controller
				{
				    protected string $page_title = 'Admin Panel';

				    public function __construct()
				    {
				        Paginator::useBootstrap();
				    }

				    /**
				     * Currency list
				     */
				    public function index()
				    {
				        if (!Auth::guard('admin')->check()) {
				            return redirect('adminLoginForm')->with([
				                'status'     => 'You are not allowed to access',
				                'alert-type' => 'error',
				            ]);
				        }

				        $result = DB::table('currency')
				            ->orderByDesc('id')
				            ->get();

				        return view('backend.currency.index', [
				            'page_title'  => $this->page_title,
				            'main_menu'   => 'admin',
				            'page_header' => 'Currency',
				            'result'      => $result,
				        ]);
				    }

				    /**
				     * Add new currency (GET + POST)
				     */
				    public function add(Request $request)
				    {
				        if ($request->isMethod('get')) {
				            return view('backend.currency.add', [
				                'page_title'  => $this->page_title,
				                'main_menu'   => 'admin',
				                'page_header' => 'Add New Currency',
				            ]);
				        }

				        $validated = $request->validate([
				            'name'   => 'required|string|max:255|unique:currency,name',
				            'code'   => 'required|string|max:50|unique:currency,code',
				            'symbol' => 'required|string|max:20|unique:currency,symbol',
				            'rate'   => 'required|numeric',
				            'status' => 'required|in:0,1',
				        ]);

				        DB::table('currency')->insert($validated);

				        return redirect('admin/currency')->with([
				            'status'     => 'Currency information saved successfully',
				            'alert-type' => 'success',
				        ]);
				    }

				    /**
				     * Update currency (GET + POST)
				     */
				    public function update(Request $request)
				    {
				        if ($request->isMethod('get')) {
				            $result = DB::table('currency')->find($request->id);

				            if (!$result) {
				                return redirect()->back()->with([
				                    'status'     => 'Currency not found',
				                    'alert-type' => 'error',
				                ]);
				            }

				            return view('backend.currency.edit', [
				                'page_title'  => $this->page_title,
				                'main_menu'   => 'admin',
				                'page_header' => 'Update Currency Information',
				                'result'      => $result,
				            ]);
				        }

				        $validated = $request->validate([
				            'id'     => 'required|exists:currency,id',
				            'name'   => 'required|string|max:255',
				            'code'   => 'required|string|max:50',
				            'symbol' => 'required|string|max:20',
				            'rate'   => 'required|numeric',
				            'status' => 'required|in:0,1',
				        ]);

				        DB::table('currency')
				            ->where('id', $validated['id'])
				            ->update([
				                'name'   => $validated['name'],
				                'code'   => $validated['code'],
				                'symbol' => $validated['symbol'],
				                'rate'   => $validated['rate'],
				                'status' => $validated['status'],
				            ]);

				        return redirect('admin/currency')->with([
				            'status'     => 'Currency updated successfully',
				            'alert-type' => 'success',
				        ]);
				    }

				    /**
				     * Delete currency
				     */
				    public function delete(Request $request)
				    {
				        if (!Auth::guard('admin')->check()) {
				            return redirect()->back()->with([
				                'status'     => 'You are not allowed to access',
				                'alert-type' => 'error',
				            ]);
				        }

				        $currency = DB::table('currency')->find($request->id);

				        if (!$currency) {
				            return redirect()->back()->with([
				                'status'     => 'Currency not found',
				                'alert-type' => 'error',
				            ]);
				        }

				        $inUse = DB::table('users')
				            ->where('currency_code', $currency->code)
				            ->exists();

				        if ($inUse) {
				            return redirect()->back()->with([
				                'status'     => 'Some users are using this currency. Deletion not allowed.',
				                'alert-type' => 'error',
				            ]);
				        }

				        DB::table('currency')->where('id', $currency->id)->delete();

				        return redirect()->back()->with([
				            'status'     => 'Currency information deleted successfully',
				            'alert-type' => 'success',
				        ]);
				    }
				}