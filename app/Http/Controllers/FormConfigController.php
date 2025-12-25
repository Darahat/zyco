<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormConfigController extends Controller
{
    public $page_title;

    public function __construct()
    {
        $this->page_title = 'Admin Panel';
    }

    // Generic form config handler
    public function formConfig(Request $request, $formId, $view)
    {
        if ($request->isMethod('get')) {
            $result = DB::table('form_config')->where('form_id', $formId)->orderBy('id')->get();
            
            $extraData = [];
            if ($formId == 4) { // vehicle
                $extraData['vehicle_type'] = DB::table('vehicle_type')->latest()->get();
                $extraData['vehicle_make'] = DB::table('vehicle_make')->latest()->get();
                $extraData['drivers'] = DB::table('users')->where('user_type', 'Driver')->latest()->get();
            }

            return view($view, array_merge([
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => $this->getPageHeader($formId),
            ], compact('result'), $extraData));

        } else if ($request->isMethod('post')) {
            $post = [
                'form_id' => $formId,
                'field_name' => $request->field_name ? implode(',', $request->field_name) : ''
            ];

            if (!empty($request->id)) {
                DB::table('form_config')->where('id', $request->id)->update($post);
                $message = "Data Updated Successfully";
            } else {
                DB::table('form_config')->insert($post);
                $message = "Data Saved Successfully";
            }

            return redirect()->back()->with([
                'status' => $message,
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        ]);
    }

    // Special handler for site config (logo upload)
    public function siteConfig(Request $request)
    {
        if ($request->isMethod('get')) {
            $result = DB::table('site_config')->orderBy('id')->first();
            return view('admin.formConfig.site_config', [
                'page_title' => $this->page_title,
                'main_menu' => 'admin',
                'page_header' => 'Site Configuration',
                'result' => $result
            ]);
        } else if ($request->isMethod('post')) {
            $post = $request->only([
                'brand_name', 'address', 'invoice_email', 'support_email', 
                'registration_number', 'telephone', 'vat_number'
            ]);

            if ($request->hasFile('site_logo')) {
                $fileName = 'logo_' . time() . '.' . $request->site_logo->extension();
                $request->site_logo->move(public_path('site_pic'), $fileName);
                $post['site_logo'] = $fileName;
            }

            if (!empty($request->id)) {
                DB::table('site_config')->where('id', $request->id)->update($post);
                $message = "Data Updated Successfully";
            } else {
                DB::table('site_config')->insert($post);
                $message = "Data Saved Successfully";
            }

            return redirect()->back()->with([
                'status' => $message,
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        ]);
    }

    private function getPageHeader($formId)
    {
        return match($formId) {
            1 => 'Bank Form Configuration',
            2 => 'Company Form Configuration',
            3 => 'VAT Form Configuration',
            4 => 'Vehicle Form Configuration',
            5 => 'Group Form Configuration',
            6 => 'Postal Form Configuration',
            7 => 'Document Form Configuration',
            8 => 'Personal Form Configuration',
            9 => 'Basic Form Configuration',
            default => 'Form Configuration'
        };
    }
}