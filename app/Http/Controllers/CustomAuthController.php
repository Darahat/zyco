<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Hashing\BcryptHasher;
use App\Http\Controllers\MyTestMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CustomAuthController extends Controller
{
    private $my_test_mail;

    public function __construct(MyTestMail $myTestMail)
    {
        $this->my_test_mail = $myTestMail;
    }
    public function index()
    {
        $result = DB::table('login_config')->where('login_type', 'User')->first();
        return view('auth.login', with(compact('result')));
    }
    public function customLogin(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user_type = strtolower($user->user_type);
            
            \Log::info('User login successful', [
                'user_id' => $user->id,
                'user_type' => $user->user_type,
                'session_id' => session()->getId(),
            ]);

            // For AJAX requests, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Successful',
                    'user_type' => $user_type,
                    'redirect_url' => match($user_type) {
                        'driver' => route('driver.dashboard'),
                        'rider' => route('rider.dashboard'),
                        default => route('dashboard')
                    }
                ]);
            }
            
            // For form submissions, redirect
            $dashboard_route = match($user_type) {
                'driver' => 'driver.dashboard',
                'rider' => 'rider.dashboard',
                default => 'dashboard'
            };

            return redirect()->route($dashboard_route)->with([
                'status' => 'Login Successful',
                'alert-type' => 'success'
            ]);
        } else {
            // For AJAX requests, return JSON error
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email/phone or password'
                ]);
            }
            
            return redirect()->back()->withInput()->with([
                'status' => 'Invalid email/phone or password',
                'alert-type' => 'error'
            ]);
        }
    }

    public function checkEmail(Request $request)
    {
        $input = $request->only(['email']);
        $request_data = [
            'email' => 'required|email|unique:users,email',
        ];

        $validator = Validator::make($input, $request_data);

        // json is null
        if ($validator->fails()) {
            $errors = json_decode(json_encode($validator->errors()), 1);
            return response()->json([
                'success' => false,
                'message' => array_reduce($errors, 'array_merge', array()),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'The email is available'
            ]);
        }
    }
    public function checkMobileNumber(Request $request)
    {
        // dd($request->mobile_number);
        $input = $request->only(['mobile_number']);
        //      $validated = $request->validate([
        // 'mobile_number' => 'required'
        // ]);
        $request_data = [
            'mobile_number' => 'required|unique:users,mobile_number',
        ];

        $validator = Validator::make($input, $request_data);
        // json is null
        if ($validator->fails()) {
            $errors = json_decode(json_encode($validator->errors()), 1);
            return response()->json([
                'success' => false,
                'message' => array_reduce($errors, 'array_merge', array()),
            ]);
        } else {

            return response()->json([
                'success' => true,
                'message' => 'The phone number is available'
            ]);
        }
    }
    public function forget_password()
    {
        return view('auth.forget_password');
    }
    public function signin_option()
    {
        return view('auth.signin_option');
    }
    public function forget_email()
    {
        return view('auth.forget_email');
    }

    public function check_user_exist(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $value = $request->input('value');
        $need = $request->input('need');

        // Validate required parameters
        if (!$table || !$field || !$value || !$need) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $check = DB::table($table)->where($field, '=', $value)->value($need);

        if ($check) {
            return $check;
        } else {
            return null;
        }
    }

    public function check_user_exist2(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $value = $request->input('value');

        if (!$table || !$field || !$value) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $check = DB::table($table)->where($field, '=', $value)->orWhere('mobile_number', '=', $value)->first();
        if ($check) {
            return $check->mobile_number;
        } else {
            return null;
        }
    }
    public function check_user_exist3(Request $request)
    {
        $table = $request->input('table');
        $field1 = $request->input('field1');
        $value1 = $request->input('value1');
        $value2 = $request->input('value2');

        if (!$table || !$field1 || !$value1 || !$value2) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $check = DB::table($table)->where($field1, '=', $value1)->first();

        if ($check) {
            if (Hash::check($value2, $check->password)) {
                return $check->mobile_number;
            } else {
                return null;
            }
        }
        
        return null;
    }

    public function check_data_exist(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $value = $request->input('value');

        if (!$table || !$field || !$value) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $check = DB::table($table)->where($field, '=', $value)->first();
        if ($check) {
            return $check->id;
        } else {
            return null;
        }
    }
    public function check_data_exist2(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $value = $request->input('value');

        if (!$table || !$field || !$value) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $check = DB::table($table)->where($field, '=', $value)->first();
        if ($check) {
            return $check->mobile_number;
        } else {
            return null;
        }
    }
    public function user_registration()
    {
        return view('auth.registration');
    }
    // public function registration_rider()
    // {
    //         $user_type = 'Rider';
    //         return view('auth.registration',[
    //             'user_type' => $user_type    
    //        ]);
    // }

    public function updateAuthData(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $value = $request->input('value');
        $mobileNumber = $request->input('mobile_number');

        if (!$table || !$field || !$value || !$mobileNumber) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        if ($field == 'password') {
            $post[$field] = Hash::make($value);
        } else {
            $post[$field] = $value;
        }
        $success = DB::table($table)->where('mobile_number', $mobileNumber)->update($post);
        if ($success) {
            $notification = array(
                'status' => 'Data Updated  Successfully',
                'alert-type' => 'success'
            );
            $updatedData = DB::table($table)->where('mobile_number', $mobileNumber)->get();
            // return $success;
            // dd($updatedData);
            return redirect()->back()->with($notification);
            // return redirect()->route("login")->with($notification);
            // return $updatedData;
            //  return json_encode($updatedData);
        } else {
            $notification = array(
                'status' => 'Data Update Fail',
                'alert-type' => 'error'
            );
            return null;
        }
    }
    public function customRegistration(Request $request)
    {

        $validation = $request->validate([
            'user_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'base_city' => 'required',
            'password' => 'required|min:6',
            'mobile_number' => 'required|unique:users',
            // 'country_code' => 'required',
            'base_city' => 'required',
        ]);
        $country_code = substr("$request->mobile_number", 0, 3);
        $data = $request->all();
        $post = array();
        if ($validation) {
            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'user_type' => $data['user_type'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'mobile_number' => $data['mobile_number'],
                'country_code' =>  $country_code,
                'password' => bcrypt($data['password']),
                'base_city' => $data['base_city'],
            ]);
            if ($user) {
                $post['user_id'] =  $user->id;
                $createUserProfile =  DB::table('users_personalinfo')->insert($post);
            }
            $notification = array(
                'status' => 'Registration Success',
                'alert-type' => 'success'
            );
            Auth::login($user);

            return $data;
            // return redirect()->route("my_profile")->with($notification);
        } else {
            $notification = array(
                'status' => 'Registration Failed',
                'alert-type' => 'error'
            );
            return redirect("user_registration")->withSuccess('Registration Failed');
        }
    }



    public function create(array $data)
    {

        $success = User::create([
            'user_type' => $data['user_type'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'country_code' => $data['country_code'],
            'password' => Hash::make($data['password'])
        ]);
        if ($success) {
            $notification = array(
                'status' => '' . $data['user_type'] . 'Registration Successful',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'status' => 'Registration Failed',
                'alert-type' => 'error'
            );
        }

        if ($success) {
            // Send registration email
            $mailRequest = new Request([
                'table' => 'users',
                'field' => 'email',
                'value' => $data['email']
            ]);
            $this->my_test_mail->RegistrationComplete($mailRequest);

            // Attempt to login after registration
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $notification = array(
                    'status' => 'Signed in',
                    'alert-type' => 'Success'
                );

                //return redirect()->intended('admin/dashboard')->withSuccess('Signed in');
                return redirect()->intended('admin/dashboard')->with($notification);
                # code...
            }
            // return $success;
            // exit;
            // return redirect("login")->with($notification);

        }
    }


    public function dashboard()
    {
        //print_r(Auth::user()->id);
        // exit;
        if (Auth::guard('admin')) {
            return view('backend.dashboard', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Dashboard',
                'main_menu' => 'dashboard'
            ]);
        }

        $notification = array(
            'status' => 'You are not allowed to accesdds',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function signOut()
    {

        if (!Auth::guard('admin')->check()) {
            Session::flush();
            Auth::logout();

            $notification = array(
                'status' => 'You are successfully logout',
                'alert-type' => 'info'
            );

            return Redirect()->route('login')->with($notification);
        } else {
            Session::flush();
            Auth::logout();

            $notification = array(
                'status' => 'You are successfully logout',
                'alert-type' => 'info'
            );
            return Redirect()->route('adminLoginForm')->with($notification);
        }
    }

    public function menu()
    {
        if (Auth::check()) {
            $menu_list = DB::table('menus')->where('menu_type', 'top')->orderBy('menu_order')->get();

            return view('backend.menu', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Menu'
            ], compact('menu_list'));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }
    public function submenu()
    {
        if (Auth::check()) {
            $menu_list = DB::table('menus')->where('menu_type', 'sub')->orderBy('menu_order')->get();

            return view('backend.menu_sub', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Sub Menu'
            ], compact('menu_list'));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }
    public function childmenu()
    {
        if (Auth::check()) {
            $menu_list = DB::table('menus')->where('menu_type', 'child')->orderBy('menu_order')->get();

            return view('backend.menu_child', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Child Menu'
            ], compact('menu_list'));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function addmenu(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'menu_name' => 'required',
                'menu_type' => 'required',
                'slug' => 'required|unique:menus',
                'menu_order' => 'required',
                'has_submenu' => 'required',
                'has_hyperlink' => 'required',
                'has_hyperlink_internal' => 'required',
            ]);


            //return response()->json($request->category );
            $post = array();
            $post['menu_name'] = $request->menu_name;
            $post['menu_type'] = $request->menu_type;
            $post['slug'] = $request->slug;
            $post['menu_order'] = $request->menu_order;
            $post['has_submenu'] = $request->has_submenu;
            $post['has_hyperlink'] = $request->has_hyperlink;
            $post['has_hyperlink_internal'] = $request->has_hyperlink_internal;
            $post['description'] = $request->description;
            $post['created_at'] = Carbon::now();

            $postdata = DB::table('menus')->insert($post);
            return redirect('admin/menu')->with('status', 'Data successfully saved');
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }



    public function updatepost(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'title' => 'required',
                'category' => 'required',
                'description' => 'required',
                'file' => 'mimes:png,jpg,jpeg,pdf|max:2048'
            ]);


            $id = $request->id;

            //return response()->json($request->file->extension());

            $post = array();
            $post['title'] = $request->title;
            $post['description'] = $request->description;
            $post['category'] = implode(",", $request->category);
            $post['updated_at'] = Carbon::now();

            if ($request->file) {
                $fileName = 'post-' . md5(time()) . '.' . $request->file->extension();
                $post['file'] = $fileName;
                $request->file->move(public_path('upload'), $fileName);
                unlink(public_path('upload/') . $request->old_file);
                $postdata = DB::table('posts')->where('id', $id)->update($post);

                $notification = array(
                    'status' => 'Post successfully saved',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            } else {
                $postdata = DB::table('posts')->where('id', $id)->update($post);

                $notification = array(
                    'status' => 'Post successfully saved',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }
    public function pages()
    {
        if (Auth::check()) {
            $page_list = DB::table('pages')->orderBy('created_at', 'desc')->get();

            return view('backend.pages', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Pages'
            ], compact('page_list'));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function addpages(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'title' => 'required',
                'slug' => 'required|unique:pages',
                'description' => 'required',
            ]);

            //return response()->json($request->category );
            $post = array();
            $post['title'] = $request->title;
            $post['slug'] = $request->slug;
            $post['description'] = $request->description;
            $post['created_at'] = Carbon::now();
            $postdata = DB::table('pages')->insert($post);
            return redirect('admin/pages')->with('status', 'Data successfully saved');
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function delpages($id)
    {
        $delete = DB::table('pages')->where('id', $id)->delete();
        if ($delete) {
            $notification = array(
                'status' => 'Page successfully deleted',
                'alert-type' => 'success'
            );
        }

        return redirect()->back()->with($notification);
    }

    public function editpages($id)
    {

        if (Auth::check()) {
            $page = DB::table('pages')->where('id', $id)->first();
            //return response()->json($post_list );
            return view('backend.pages_edit', [
                'page_title' => 'Taxi Plaza',
                'page_header' => 'Page'
            ], compact('page'));
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function updatepages(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'description' => 'required',
            ]);


            $id = $request->id;

            //return response()->json($request->file->extension());

            $post = array();
            $post['title'] = $request->title;
            $post['slug'] = $request->slug;
            $post['description'] = $request->description;

            $post['updated_at'] = Carbon::now();


            $postdata = DB::table('pages')->where('id', $id)->update($post);

            $notification = array(
                'status' => 'Page successfully saved',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }
}