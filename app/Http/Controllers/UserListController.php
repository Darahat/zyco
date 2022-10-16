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





class UserListController extends Controller



{



    public function __construct(){



        $this->page_title = 'Admin Panel';



    }



    public function index(){

        $user_id = Auth::user()->id;

		Paginator::useBootstrap();



		$user_group = DB::table('users_group_members')

				->join('users_group','users_group.id','=','users_group_members.group_id')

				->where([

					['member_id','=',$user_id],

					['status','=',1],

				])

				->select('users_group_members.group_id')

				->orderBy('group_id')->get();

				

		$group_id = array();

		foreach($user_group as $grp_id){

			$group_id[] = $grp_id->group_id;

		}

		$user_group_member = DB::table('users_group_members')

				->whereIn('group_id',$group_id)

				->select('users_group_members.member_id')

				->groupBy('member_id')

				->get();

		$group_member = array();

		foreach($user_group_member as $grp_member){

			$group_member[] = $grp_member->member_id;

		}

		$result = DB::table('users')

				// ->join('users_group','users_group_members.group_id','=','users_group.id')

				->where([

					['users.user_type','<>','Rider'],

					['users.driver_activity_status','>',0],

					['users.id','<>',$user_id]

				])

				// ->select('users.*', 'users_group.id as group_id','users_group.group_name')

				->orderBy('first_name')->get();

		// return response()->json($result);

		

		

				

		// return response()->json($user_group_member);

		

		

		return view('backend.user_list.index', [

			  'page_title' => $this->page_title,

			  'page_header' => 'Users',
			  'main_menu' => 'dispatch',
			  ],with(compact('group_member','result')));

    }

	public function make_favorite($id){

            $user_id = Auth::user()->id;

			

			$result = DB::table('users')->where('id',$id)->first();            

			$favorites = $result->favorites;

			

			Paginator::useBootstrap();

			

			$fav_id = explode(",",$favorites);

			array_filter($fav_id);

			$post = array();

			if(count($fav_id) == 0){

				$post['favorites'] = $user_id;

			} else {

				$post['favorites'] = $favorites.",".$user_id;

			}

			

			$result = DB::table('users')->where('id',$id)->update($post);

			$notification = array(

						'status' => 'User add to favorite',

						'alert-type' => 'success'

					);

            return redirect()->back()->with($notification);

    }

	public function remove_favorite($id){

            $user_id = Auth::user()->id;

			

			$result = DB::table('users')->where('id',$id)->first();            

			$favorites = $result->favorites;

			

			Paginator::useBootstrap();

			

			$fav_id = explode(",",$favorites);

			$new_fav = implode(",",array_diff($fav_id,array($user_id)));



			$post = array();			

			$post['favorites'] = $new_fav;

			

			

			$postdata = DB::table('users')->where('id',$id)->update($post);

			$notification = array(

						'status' => 'User remove from favorite',

						'alert-type' => 'success'

					);

            return redirect()->back()->with($notification);

    }

 



}



   