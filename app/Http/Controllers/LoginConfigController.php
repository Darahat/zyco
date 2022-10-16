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

class LoginConfigController extends Controller
{
    public function __construct()
    {
        $this->page_title = 'Admin Panel';
    }
    public function index()
    {


        $result = DB::table('login_config')->get();

        return view('admin.loginConfig.index', [
            'page_title' => $this->page_title,
            'main_menu' => 'admin_settings',
            'page_header' => 'login config',
        ], with(compact('result')));
    }
    /**
     * Add a New language
     *
     * @param array $request  Input values
     * @return redirect     to language view
     */
    public function add(Request $request)
    {
        if (!$_POST) {
            return view('backend.language.add', [
                'page_title' => $this->page_title,
                'main_menu' => 'informations',
                'page_header' => 'Add New Language',
            ]);
        } else if ($request->submit) {
            $validatedData = $request->validate([
                'name' => 'required|unique:language',
                'value' => 'required|unique:language',
                'status' => 'required',
            ]);
            $post = array();
            $post['name'] = $request->name;
            $post['value'] = $request->value;
            $post['status'] = $request->status;
            $insertData = DB::table('language')->insert($post);
            if ($insertData) {
                $notification = array(
                    'status' => 'language Information Saved Successfully',
                    'alert-type' => 'success'
                );
                return redirect('admin/language')->with($notification);
            } else {
                $notification = array(
                    'status' => 'language Information Save failed',
                    'alert-type' => 'error'
                );
                return redirect('admin/language')->with($notification);
            }
        } else {
            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}