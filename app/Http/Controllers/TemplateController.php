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



class TemplateController extends Controller

{

	public function __construct()
	{

		$this->page_title = 'Admin Panel';
	}

	public function templateType()
	{
		Paginator::useBootstrap();

		$result = DB::table('template_type')->orderBy('id', 'ASC')->get();

		return view('admin.templateType.index', [
			'page_title' => $this->page_title,
			'main_menu' => 'admin',
			'page_header' => 'Template Type',
		], with(compact('result')));
	}

	public function templateEmail()
	{
		Paginator::useBootstrap();
		$typeList = DB::table('template_type')->orderBy('id', 'ASC')->get();
		$result  = DB::table('template_email')
			->join('template_type', 'template_type.id', '=', 'template_email.type_id')
			->select('template_email.*', 'template_type.type_name')
			->orderBy('template_email.id', 'DESC')
			->get();

		return view('admin.templateEmail.index', [
			'page_title' => $this->page_title,
			'main_menu' => 'admin',
			'page_header' => 'Email Template',
		], with(compact('result', 'typeList')));
	}



	public function templateSms()
	{
		Paginator::useBootstrap();
		$typeList = DB::table('template_type')->orderBy('id', 'ASC')->get();
		$result  = DB::table('template_sms')
			->join('template_type', 'template_type.id', '=', 'template_sms.type_id')
			->select('template_sms.*', 'template_type.type_name')
			->orderBy('template_sms.id', 'DESC')
			->get();

		return view('admin.templateSms.index', [
			'page_title' => $this->page_title,
			'main_menu' => 'admin',
			'page_header' => 'SMS Template',
		], with(compact('result', 'typeList')));
	}


	public function templateEmailEdit(Request $request)

	{


		if (!$_POST) {
			//print_r($request->id); exit;
			$result = DB::table('template_email')->where('id', $request->id)->orderBy('id')->get();
			$codeList = DB::table('template_short_code')->where('template_id', $request->id)->orderBy('id', 'ASC')->get();

			return view('admin.templateEmail.edit', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Email Template Edit',
			], with(compact('result', 'codeList')));
		} else if ($request->submit) {

			$post = array();
			$id = $request->id;
			$post['subject'] = $request->subject;
			$post['message'] = $request->message;
			$UpdateData = DB::table('template_email')->where('id', $id)->update($post);
			$message = "Data Updated Successfully";
			$notification = array(
				'status'     => $message,
				'alert-type' => 'success'
			);
			return redirect('template-email')->with($notification);
		} else {

			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}


	public function templateSmsEdit(Request $request)

	{


		if (!$_POST) {
			//print_r($request->id); exit;
			$result = DB::table('template_sms')->where('id', $request->id)->orderBy('id', 'DESC')->get();
			$codeList = DB::table('template_short_code')->where('template_id', $request->id)->orderBy('id', 'ASC')->get();

			return view('admin.templateSms.edit', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'SMS Template Edit',
			], with(compact('result', 'codeList')));
		} else if ($request->submit) {

			$post = array();
			$id = $request->id;
			$post['subject'] = $request->subject;
			$post['message'] = $request->message;
			$UpdateData = DB::table('template_sms')->where('id', $id)->update($post);
			$message = "Data Updated Successfully";
			$notification = array(
				'status'     => $message,
				'alert-type' => 'success'
			);
			return redirect('template-sms')->with($notification);
		} else {

			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}

	public function personalConfig(Request $request)
	{

		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '8')->orderBy('id')->get();

			return view('admin.formConfig.personalp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Personal Form Configuration',
			], with(compact('result')));
		} else if ($request->submit) {

			$post = array();
			$id = $request->id;
			$post['form_id'] = 8;

			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;

			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;


			$notification = array(
				'status'     => $message,
				'alert-type' => 'success'
			);

			return redirect()->back()->with($notification);
		} else {

			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}

	public function basicConfig(Request $request)
	{

		if (!$_POST) {
			$result = DB::table('form_config')->where('form_id', '9')->orderBy('id')->get();

			return view('admin.formConfig.basicp', [
				'page_title' => $this->page_title,
				'main_menu' => 'admin',
				'page_header' => 'Basic Form Configuration',
			], with(compact('result')));
		} else if ($request->submit) {

			$post = array();
			$id = $request->id;
			$post['form_id'] = 9;

			if ($request->field_name) :
				$post['field_name']  = implode(',', $request->field_name);
			else :
				$post['field_name']  = "";
			endif;

			if (!empty($id)) :
				$UpdateData = DB::table('form_config')->where('id', $id)->update($post);
				$message = "Data Updated Successfully";
			else :
				$insertData = DB::table('form_config')->insert($post);
				$message = "Data Saved Successfully";
			endif;


			$notification = array(
				'status'     => $message,
				'alert-type' => 'success'
			);

			return redirect()->back()->with($notification);
		} else {

			$notification = array(
				'status' => 'You are not allowed to access',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}


	public function setConfigData(Request $request)
	{


		$post['field_name'] = implode(',', $request->field_value);
		if (!empty($request->id)) :
			$success = DB::table('form_config')->where('id', $request->id)->update($post);
			$status = 'Data Updated  Successfully';
		else :
			$post['form_id'] = $request->formId;
			$success = DB::table('form_config')->insert($post);
			$status = 'Data Saved  Successfully';
		endif;
		//return $success;
		if ($success) {

			$notification = array(
				'status' => $status,

				'alert-type' => 'success'
			);

			return redirect()->back()->with($notification);
		} else {

			$notification = array(

				'status' => 'Data Update Fail',

				'alert-type' => 'error'
			);
			return redirect()->back()->with($notification);
		}
	}
}