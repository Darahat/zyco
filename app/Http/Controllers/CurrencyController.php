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

class CurrencyController extends Controller
{
	public function __construct()
	{
		$this->page_title = 'Admin Panel';
	}
	public function index()
	{
		if (Auth::guard('admin')->check()) {

			Paginator::useBootstrap();
			$result = DB::table('currency')->orderBy('id', 'DESC')->get();
			return view('backend.currency.index', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'currency',

			], with(compact('result')));
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect("adminLoginForm")->with($notification);
		}
	}

	/**
	 * Add a New currency
	 *
	 * @param array $request  Input values
	 * @return redirect     to currency view
	 */
	public function add(Request $request)
	{
		if (!$_POST) {
			return view('backend.currency.add', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Add New currency',

			]);
		} else if ($request->submit) {

			$validatedData = $request->validate([
				'name' => 'required|unique:currency',
				'code' => 'required|unique:currency',
				'symbol'  => 'required|unique:currency',
				'rate'  => 'required|unique:currency',
				'status' => 'required',
			]);

			$post = array();
			$post['name'] = $request->name;
			$post['code'] = $request->code;
			$post['symbol'] = $request->symbol;
			$post['rate'] = $request->rate;
			$post['status'] = $request->status;
			$insertData = DB::table('currency')->insert($post);

			if ($insertData) {
				$notification = array(
					'status' => 'Currency Information Saved Successfully',
					'alert-type' => 'success'
				);
				return redirect('admin/currency')->with($notification);
			} else {
				$notification = array(
					'status' => 'Currency Information Save failed',
					'alert-type' => 'error'
				);
				return redirect('admin/currency')->with($notification);
			}
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}

	/**
	 * Update currency Details
	 *
	 * @param array $request    Input values
	 * @return redirect     to currency View
	 */
	public function update(Request $request)
	{
		if (!$_POST) {

			if (Auth::guard('admin')->check()) {

				$result = DB::table('currency')->where('id', $request->id)->first();

				return view('backend.currency.edit', [
					'page_title' => $this->page_title,
					'main_menu' => 'admin',
					'page_header' => 'Update Currency Information',
				], with(compact('result')));
			}
		} else if ($request->submit) {

			$validatedData = $request->validate([
				'name' => 'required',
				'code' => 'required',
				'symbol'  => 'required',
				'rate'  => 'required',
				'status' => 'required',
			]);

			//return response()->json( $validatedData );

			$id = $request->id;
			$post = array();
			$post['name'] = $request->name;
			$post['code'] = $request->code;
			$post['symbol'] = $request->symbol;
			$post['rate'] = $request->rate;
			$post['status'] = $request->status;
			$UpdateData = DB::table('currency')->where('id', $id)->update($post);

			$notification = array(
				'status' => 'Data Updated Successfully',
				'alert-type' => 'success'
			);
			return redirect('admin/currency')->with($notification);
		} else {
			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}

	/**
	 * Delete currency
	 *
	 * @param array $request    Input values
	 * @return redirect     to currency View
	 */
	public function delete(Request $request)
	{


		if (Auth::guard('admin')->check()) {

			$currencyData = DB::table('currency')->where('id', $request->id)->first();
			$currency_code = $currencyData->code;

			$user = DB::table('users')->where('currency_code', $currency_code)->first();

			if ($user) {
				$notification = array(
					'status' => 'Some User have this currency. So, We cannot delete the currency.',
					'alert-type' => 'error'
				);
			} else {
				$delete = DB::table('currency')->where('id', $request->id)->delete();
				$notification = array(
					'status' => 'currency Information Deleted Successfully',
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
}