<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class HomeController extends Controller
{
    private $marquee_notice;


    public function __construct()
    {
    }
    public function home()
    {
        Paginator::useBootstrap();


        return view('home', [
            'page_title' => 'Taxi Plaza | Home',
            'page_header' => 'Welcome to Taxi Plaza'

        ]);
    }

    public function notice_all()
    {
        Paginator::useBootstrap();

        $marquee_notice = $this->marquee_notice;

        //$marquee_notice = DB::table('posts')->orderBy('created_at','desc')->limit(5)->get();

        $notice = DB::table('posts')->where('category', '<>', '13')->orderBy('created_at', 'desc')->get();


        //return response()->json($notice );
        return view('notice', [
            'page_title' => 'ARMC, Mymensingh | Notice',
            'page_header' => 'Notice',

        ], compact('marquee_notice', 'notice'));
    }
    public function notice(Request $request)
    {
        Paginator::useBootstrap();

        $id = $request->id;
        $marquee_notice = $this->marquee_notice;

        //$marquee_notice = DB::table('posts')->orderBy('created_at','desc')->limit(5)->get();
        if ($id == 'all') {
            $header = 'Notice';
            $notice = DB::table('posts')->orderBy('created_at', 'desc')->get();
        } else {
            $category = DB::table('postcategories')->where('id', $id)->first();
            $header = $category->title;
            $notice = DB::table('posts')->where('category', 'like', '%' . $id . '%')->orderBy('created_at', 'desc')->get();
        }

        //return response()->json($notice );
        return view('notice', [
            'page_title' => 'ARMC, Mymensingh | Notice',
            'page_header' => $header,

        ], compact('marquee_notice', 'notice'));
    }
    public function notice_details(Request $request)
    {
        Paginator::useBootstrap();

        $id = $request->id;

        $marquee_notice = $this->marquee_notice;

        $notice = DB::table('posts')->where('id', $id)->first();

        //return response()->json($notice );
        return view('notice_details', [
            'page_title' => 'ARMC, Mymensingh | Notice',
            'page_header' => $id

        ], compact('marquee_notice', 'notice'));
    }
    public function pages(Request $request)
    {
        Paginator::useBootstrap();

        $id = $request->id;

        $marquee_notice = $this->marquee_notice;
        $facility_sub_menu_list = DB::table('menus')->where('parent_menu', '16')->orderBy('id', 'asc')->get();

        $page = DB::table('menus')->where('slug', $id)->first();
        $slider_images = DB::table('facility_sliders')->where('slug', $id)->first();
        // print_r($slider_images);
        // exit;
        //return response()->json($notice );
        return view('page_views', [
            'page_title' => 'ARMC, Mymensingh | ' . $page->menu_name,
            'page_header' => $page->menu_name

        ], compact('marquee_notice', 'page', 'slider_images', 'facility_sub_menu_list'));
    }

    public function teacher()
    {
        Paginator::useBootstrap();

        $marquee_notice = $this->marquee_notice;
        // $latest_movie = DB::table('media')->where('media_type', 'movie')->orderBy('year', 'desc')->paginate(18);
        $teachers_list = DB::table('employees')->where('type', 'Teacher')->orderBy('id', 'asc')->paginate(8);

        return view('teachers', [
            'page_title' => 'ARMC, Mymensingh | Officers',
            'page_header' => 'আমাদের শিক্ষকমন্ডলী'

        ], compact('marquee_notice', 'teachers_list'));
    }
    public function officer()
    {
        Paginator::useBootstrap();

        $marquee_notice = $this->marquee_notice;
        // $latest_movie = DB::table('media')->where('media_type', 'movie')->orderBy('year', 'desc')->paginate(18);
        $officers_list = DB::table('employees')->where('type', 'Staff')->orderBy('id', 'asc')->paginate(8);

        return view('officers', [
            'page_title' => 'ARMC, Mymensingh | Officers',
            'page_header' => 'আমাদের কর্মকর্তা/কর্মচারীবৃন্দ'

        ], compact('marquee_notice', 'officers_list'));
    }
    public function history()
    {
        Paginator::useBootstrap();
        // $latest_movie = DB::table('media')->where('media_type', 'movie')->orderBy('year', 'desc', 'entry_time', 'desc','id', 'desc')->paginate(18);

        $marquee_notice = $this->marquee_notice;
        return view('history', [
            'page_title' => 'ARMC, Mymensingh | History',
            'page_header' => 'History'

        ], compact('marquee_notice'));
    }
    public function academic_calender()
    {
        Paginator::useBootstrap();

        $marquee_notice = $this->marquee_notice;
        return view('academic_calender', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'Academic Calender'

        ], compact('marquee_notice'));
    }
    public function forms()
    {
        Paginator::useBootstrap();
        $form_categoy = DB::table('formcategories')->where('title', '<>', 'notice')->orderBy('title')->get();
        $marquee_notice = $this->marquee_notice;
        return view('forms', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'Forms'

        ], compact('marquee_notice', 'form_categoy'));
    }
    public function gallery()
    {
        Paginator::useBootstrap();
        $marquee_notice = $this->marquee_notice;
        $gallery_categoy = DB::table('gallerycategories')->orderBy('title')->get();
        //$gallery = DB::table('gallery')->orderBy('id','desc')->get();


        //return response()->json($post_data );

        return view('gallery', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'ফটো গ্যালারী'

        ], compact('marquee_notice', 'gallery_categoy'));
    }
    public function gallery_details(Request $request)
    {
        Paginator::useBootstrap();
        $id = $request->id;
        $marquee_notice = $this->marquee_notice;

        $category_title = DB::table('gallerycategories')->where('id', $id)->first();

        $gallery = DB::table('gallery')->where('category', $id)->orderBy('id', 'desc')->get();

        return view('gallery_details', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'ফটো গ্যালারী'

        ], compact('marquee_notice', 'gallery', 'category_title'));
    }
    public function downloadfile()
    {


        $filelist = DB::table('posts')->orderBy('created_at', 'desc')->get();


        $path = public_path('notice');


        foreach ($filelist as $row) {
            if (!empty($row->file_filter)) {
                $url = trim($row->file_filter);
                $fileName = basename($url);
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);

                //file_put_contents($path .'/'. $fileName, file_get_contents($url));
                /*
               if(file_put_contents($path .'/'. $fileName, file_get_contents(urlencode($url)))){
                    $notice = 'File downloaded successfully';
                } else {
                    $notice = 'File downloading failed';
            
                }
                */
                /*$post = array();
                $post['file'] = $fileName;
                
                
                $filelist = DB::table('posts')->where('id',$row->id)->update($post);
                */
            }
            echo  '<a href="' . $url . '" target="_blank">' . $row->file . '</a><br>';
        }

        //return response()->json( $post);



    }

    public function content()
    {
        Paginator::useBootstrap();
        $marquee_notice = $this->marquee_notice;
        $content_categoy = DB::table('contentcategories')->orderBy('title')->get();
        //$gallery = DB::table('gallery')->orderBy('id','desc')->get();

        //return response()->json($post_data );

        return view('content', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'ডিজিটাল কন্টেন্ট'

        ], compact('marquee_notice', 'content_categoy'));
    }
    public function content_details(Request $request)
    {
        Paginator::useBootstrap();
        $id = $request->id;
        $marquee_notice = $this->marquee_notice;

        $category_title = DB::table('contentcategories')->where('id', $id)->first();

        $content = DB::table('content')->where('category', $id)->orderBy('id', 'desc')->get();

        return view('content_details', [
            'page_title' => 'ARMC, Mymensingh | Academic Calender',
            'page_header' => 'ডিজিটাল কন্টেন্ট'

        ], compact('marquee_notice', 'content', 'category_title'));
    }
}