<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Hash;
use Session;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Redirect;


class ERPController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }  
      

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {      
            $notification = array(
                  'status' => 'Signed in',
                  'alert-type' => 'success'
              );

            //return redirect()->intended('admin/dashboard')->withSuccess('Signed in');
            return redirect()->intended('admin/erp/dashboard')->with($notification);
        }
            
        $notification = array(
            'status' => 'Login details are not valid',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }

    public function dashboard()
    {
        $student_list = DB::table('students')->orderBy('CLASS_ROLL')->get();

        if(Auth::check()){          
            return view('backend.erp.dashboard', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Dashboard'    
            ],with(compact('student_list')));
        }
  
        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
    }
    
    
        public function student_sit_plan_list(){
         $student_list = DB::table('students')->orderBy('CLASS_ROLL')->get();

        if(Auth::check()){          
            return view('backend.erp.sit_plan_list', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Seat Plan Download'    
            ],with(compact('student_list')));
        }
  
        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
     }
     
     
     
     
   
     
     
      public function student_entry_form_pdf($regno){
          if(Auth::check()){
              if($regno){
                $student_detail = DB::table('students')->where('S_REGNO',$regno)->first();
                $cls_sub_list = DB::table('class_subject')->get();

           $dataVal = [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                 'student_detail' => $student_detail,  
                 'cls_sub_list' => $cls_sub_list,
            ];
            
             $pdf = PDF::loadView('backend.erp.student_entry_form_pdf', $dataVal);
             return $pdf->stream('admit_card.pdf');
          }
          
     }else{
          $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
                         return redirect("login")->with($notification);
          }
        
    }
     
     public function getStudentSitPlanByGroupId(Request $request)
    {
        $groupid= $request->groupid;
        $exam = $request->exam_name;
        $class = $request->class_name;
        $student_list = DB::table('students')->where('GROUP_ID', $groupid)->orderBy('CLASS_ROLL')->get();
      return view('backend.erp.sit_plan_card',[
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Attendance Card Download',   
                'exam_name' => $exam,
                'class_name' => $class,
            ],with(compact('student_list')));
     }
     
      public function sit_plan_PDF($regno)
    {
        // print_r($regno);
        $student_detail = DB::table('students')->where('S_REGNO',$regno)->first();

     
         if(Auth::check()){ 
               
        $data = [
            'date' => date('m/d/Y'),
            'student_detail' => $student_detail,
        ];
        $pdf = PDF::loadView('backend.erp.sit_plan_card', $data);
        }
      
	  
		return $pdf->stream('sit_plan.pdf');
        // return $pdf->download('admit_card.pdf');
    }
     
   
     
       public function student_attendance_card_list(){
         $student_list = DB::table('students')->orderBy('CLASS_ROLL')->get();

        if(Auth::check()){          
            return view('backend.erp.student_attendance_card_list', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Attendance Card Download'    
            ],with(compact('student_list')));
        }
  
        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
     }
     public function getStudentAttendanceByGroupId(Request $request)
    {
        $groupid= $request->groupid;
		$exam = $request->exam_name;
        $class = $request->class_name;
        $student_list = DB::table('students')->where('GROUP_ID', $groupid)->orderBy('CLASS_ROLL')->get();
        $cls_sub_list = DB::table('class_subject')->where('class_name', $class)->get();

      return view('backend.erp.std_attendance_card', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                 'page_header' => 'Attendance Card Download',   
                'exam_name' => $exam,
                'class_name' => $class,    
            ],with(compact('student_list','cls_sub_list')));
     }
      public function attendance_card_PDF($regno)
    {
        // print_r($regno);
        $student_detail = DB::table('students')->where('S_REGNO',$regno)->orderBy('CLASS_ROLL')->get();

     
         if(Auth::check()){ 
               
        $data = [
            'date' => date('m/d/Y'),
            'student_detail' => $student_detail,
        ];
        $pdf = PDF::loadView('backend.erp.std_attendance_card', $data);
        }
      
    return $pdf->stream('attendance_card.pdf');
        // return $pdf->download('admit_card.pdf');
    }
        public function student_admit_card_list(){
         $student_list = DB::table('students')->orderBy('CLASS_ROLL')->get();

        if(Auth::check()){          
            return view('backend.erp.student_admit_card_list', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Admit Card List'    
            ],with(compact('student_list')));
        }
  
        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
        return redirect("login")->with($notification);
     }
    public function getStudentUsingId(Request $request)
    {
       $groupid= $request->groupid;
        $exam = $request->exam_name;
        $class = $request->class_name;
        $exam_date = $request->exam_date;
        $groupid= $request->groupid;
        $student_list = DB::table('students')->where('GROUP_ID', $groupid)->orderBy('CLASS_ROLL')->get();
    
            
      return view('backend.erp.admit_card', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Sub Menu',
                'exam_name' => $exam,
                'exam_date' => $exam_date,
                'class_name' => $class,
            ],with(compact('student_list')));
  
      }
  
     
     public function printPDF($regno)
    {
        // print_r($regno);
        $student_detail = DB::table('students')->where('S_REGNO',$regno)->first();

     
         if(Auth::check()){ 
               
        $data = [
            'date' => date('m/d/Y'),
            'student_detail' => $student_detail,
        ];
        $pdf = PDF::loadView('backend.erp.admit_card', $data);
        }
      
    return $pdf->stream('admit_card.pdf');
        // return $pdf->download('admit_card.pdf');
    }
     public function add_student_form()
    {
      $district = DB::table('districts')->get();

      return view('backend.erp.add_student_form', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                 'page_header' => 'Add New Student',   
     
            ],with(compact('district')));
  
     }
     
    public function getElectiveSub1(Request $request)
    {
                $group_id = $request->group_id;
                $sub_list = DB::table('hsc_subject_group')
                        ->where(['group_id' => $group_id])
                        ->where(['is_composary' => '0'])
                        ->get();
				$str="";
				$str.='<select name="elective_sub1" id="elective_sub1" class="form-control" onchange="getElectiveSub2()" required>
				<option value="">---- Select ----</option>';
				if(count($sub_list)): foreach($sub_list as $sVal):
				        $str .='<option value="' . $sVal->subject_code. '">'.$sVal->subject_name.'</option>';	
                endforeach; endif;
			    $str.='</select>';
				echo $str;
    }
    
    public function getElectiveSub2(Request $request)
    {
                $group_id = $request->group_id;
                $elective_sub1 = $request->elective_sub1;
                
                $sub_list = DB::table('hsc_subject_group')
                        ->where(['group_id' => $group_id])
                        ->where(['is_composary' => '0'])
                        ->where('subject_code', '!=' , $elective_sub1)
                        ->get();
				$str="";
				$str.='<select name="elective_sub2" id="elective_sub2" class="form-control" onchange="getElectiveSub3()" required>
				<option value="">---- Select ----</option>';
				if(count($sub_list)): foreach($sub_list as $sVal):
				        $str .='<option value="' . $sVal->subject_code. '">'.$sVal->subject_name.'</option>';	
                endforeach; endif;
			    $str.='</select>';
				echo $str;
    }
    
    public function getElectiveSub3(Request $request)
    {
                $group_id = $request->group_id;
                $elective_sub1 = $request->elective_sub1;
                $elective_sub2 = $request->elective_sub2;
                
                $sub_list = DB::table('hsc_subject_group')
                        ->where(['group_id' => $group_id])
                        ->where(['is_composary' => '0'])
                        ->where('subject_code', '!=' , $elective_sub1)
                        ->where('subject_code', '!=' , $elective_sub2)
                        ->get();
				$str="";
				$str.='<select name="elective_sub3" id="elective_sub3" class="form-control" onchange="getFourthSub()" required>
				<option value="">---- Select ----</option>';
				if(count($sub_list)): foreach($sub_list as $sVal):
				        $str .='<option value="' . $sVal->subject_code. '">'.$sVal->subject_name.'</option>';	
                endforeach; endif;
			    $str.='</select>';
				echo $str;
    }
    
    public function getFourthSub(Request $request)
    {
                $group_id = $request->group_id;
                $elective_sub1 = $request->elective_sub1;
                $elective_sub2 = $request->elective_sub2;
                $elective_sub3 = $request->elective_sub3;
                
                $sub_list = DB::table('hsc_subject_group')
                        ->where(['group_id' => $group_id])
                        ->where(['is_composary' => '0'])
                        ->where('subject_code', '!=' , $elective_sub1)
                        ->where('subject_code', '!=' , $elective_sub2)
                        ->where('subject_code', '!=' , $elective_sub3)
                        ->get();
				$str="";
				$str.='<select name="fourth_sub" id="fourth_sub" class="form-control" required>
				<option value="">---- Select ----</option>';
				if(count($sub_list)): foreach($sub_list as $sVal):
				        $str .='<option value="' . $sVal->subject_code. '">'.$sVal->subject_name.'</option>';	
                endforeach; endif;
			    $str.='</select>';
				echo $str;
    }
    
     public function getSubjectByGroup(Request $request)
    {
       $groupid= $request->groupid;
      $cls_sub_list = array();
      $cls_sub_list = DB::table('class_subject')
                        ->select('class_subject.id','class_subject.group_id','class_subject.subject','class_subject.is_optional','hsc_subject.subject_name')
                        ->join('hsc_subject','hsc_subject.subject_code','=','class_subject.subject')
                        ->where(['class_subject.group_id' => $groupid])
                        ->where(['class_subject.part'=> '0'])
                        ->where('class_subject.subject', '!=' , 275)
                        ->where('class_subject.subject', '!=' , 102)
                        ->where('class_subject.subject', '!=' , 107)
                        ->where('class_subject.subject', '!=' , 101)
                        ->where('class_subject.subject', '!=' , 108)
                        ->get();
    //   foreach($cls_sub_list as $sub){
    //       if($sub->subject == )
           
    //   }
 
   
      return json_encode($cls_sub_list);
     }
     
     public function addNewStudent(Request $request){
          if(Auth::check()){
            $validatedData = $request->validate([
                    'S_ROLL'=> 'required',
                    'S_PYR'=> 'required',
                    'S_REGNO'=> 'required',                
                    'SESSION'=> 'required',    
                    'NAME'=> 'required',
                    'SECTION'=> 'required',
                    'SEX'=> 'required',
                    'RELIGION'=> 'required',
                    'FNAME'=> 'required',
                    'MOTHER'=> 'required',
                    'S_BOARD'=> 'required',
                    'EIIN'=> 'required',
                    'GPA'=> 'required',
                    'BIRTH_DATE'=> 'required',
                    'SHIFT'=> 'required',
                    'GROUP_ID'=> 'required',
                    'HDISTRICT'=> 'required',
                    'APPTYPE'=> 'required',
                    
                    'F_CONTACT_NO'=> 'required',
                    
              ]);
             
             $group_id = $request->GROUP_ID;
             $session = $request->SESSION;
             
            $max_class_roll = DB::table('students')
                        ->select('CLASS_ROLL')
                        ->where('GROUP_ID','=', $group_id)
                        ->where('SESSION','=',$session)
                        ->limit(1)
                        ->orderBy('CLASS_ROLL', 'DESC')
                        ->get();
            if($max_class_roll): foreach($max_class_roll as $maxRoll): $classroll = $maxRoll->CLASS_ROLL; endforeach; else: $classroll =""; endif;            
                        
            $max_esif = DB::table('students')
                        ->select('ESIF')
                        ->where('GROUP_ID','=', $group_id)
                        ->where('SESSION','=',$session)
                        ->limit(1)
                        ->orderBy('ESIF', 'DESC')
                        ->get();
            if($max_esif): foreach($max_esif as $maxes): $esif = $maxes->ESIF; endforeach; else: $esif =""; endif;            
                        
            if($group_id == 0):  
              if(!empty($classroll)):  $classroll = $classroll + 1; else: $classroll = "233001"; endif;
              if(!empty($esif)):  $esif = $esif + 1; else: $esif = "3001"; endif;
              
            elseif($group_id == 2):  
              if(!empty($classroll)):  $classroll = $classroll + 1; else: $classroll = "231001"; endif;
              if(!empty($esif)):  $esif = $esif + 1; else: $esif = "1001"; endif;
                
            elseif($group_id == 8):  
              if(!empty($classroll)):  $classroll = $classroll + 1; else: $classroll = "232001"; endif;
              if(!empty($esif)):  $esif = $esif + 1; else: $esif = "2001"; endif;
            else:
             $classroll ="";  $esif =""; 
            endif;    

              $elective_sub1 = $request->elective_sub1;
              $elective_sub2 = $request->elective_sub2;
              $elective_sub3 = $request->elective_sub3;
              $fourth_sub    = $request->fourth_sub;
              
              $elective_sub1_ar = explode("-",$elective_sub1);
              $elective_sub2_ar = explode("-",$elective_sub2);
              $elective_sub3_ar = explode("-",$elective_sub3);
              $fourth_sub_ar    = explode("-",$fourth_sub);
              if(!empty($request->FILENAME)){
                $imageName = 'student-'.time().'.'.$request->FILENAME->extension();  
                $request->FILENAME->move(public_path('student_photo/'.$request->S_PYR.''), $imageName);
              } else {
                   $imageName = '';
              }

             $common_sub = "101,102,107,108,275";

              $post = array();
              $post['S_ROLL'] = $request->S_ROLL;
              $post['GROUPS'] = $request->GROUP_ID;
              $post['S_PYR'] = $request->S_PYR;
              $post['S_REGNO'] = $request->S_REGNO;
              //$post['S_SESS1'] = $request->S_SESS1;
              $post['SESSION'] = $request->SESSION;
              $post['REGNO'] = $request->S_REGNO;
              $post['NAME'] = $request->NAME; 
              $post['SECTION'] = $request->SECTION;
              $post['CLASS_ROLL'] = $classroll;
              $post['SEX'] = $request->SEX;
              $post['RELIGION'] = $request->RELIGION;
              $post['FNAME'] = $request->FNAME;
              $post['MOTHER'] = $request->MOTHER;
              $post['S_BOARD'] = $request->S_BOARD;
              $post['OPTIONAL'] = $fourth_sub; 
              $post['SUBS1'] = '101'; 
              $post['SUBS2'] = '102'; 
              $post['SUBS3'] = '107'; 
              $post['SUBS4'] = '108'; 
              $post['SUBS5'] = '275'; 
              $post['SUBS6'] = $elective_sub1_ar[0]; 
              $post['SUBS7'] = $elective_sub1_ar[1]; 
              $post['SUBS8'] = $elective_sub2_ar[0]; 
              $post['SUBS9'] = $elective_sub2_ar[1]; 
              $post['SUBS10'] = $elective_sub3_ar[0]; 
              $post['SUBS11'] = $elective_sub3_ar[1]; 
              $post['SUBS12'] = $fourth_sub_ar[0]; 
              $post['SUBS13'] = $fourth_sub_ar[1]; 
              $post['SUBJECT'] =  $common_sub.','.$elective_sub1_ar[0].','.$elective_sub1_ar[1].','.$elective_sub2_ar[0].','.$elective_sub2_ar[1].','.$elective_sub3_ar[0].','.$elective_sub3_ar[1].','.$fourth_sub_ar[0].','.$fourth_sub_ar[1];
              $post['BIRTH_REGNO'] = $request->birth_regno;
              $post['FNID'] = $request->fnid;
              $post['MNID'] = $request->mnid;
              $post['EIIN'] = $request->EIIN;
              $post['GPA'] = $request->GPA;
              $post['BIRTH_DATE'] = $request->BIRTH_DATE;
              $post['FILENAME'] =  $imageName;
              $post['ESIF'] = $esif;
              $post['SHIFT'] = $request->SHIFT; 
              $post['GROUP_ID'] = $request->GROUP_ID;
              $post['HDISTRICT'] = $request->HDISTRICT;
              $post['APPTYPE'] = $request->APPTYPE;
              $post['CONTACT_NO'] = $request->CONTACT_NO;
              $post['F_CONTACT_NO'] = $request->F_CONTACT_NO;
              $post['M_CONTACT_NO'] = $request->M_CONTACT_NO;
              $post['STATUS'] = "Regular";
              $post['HDISTRICT'] = $request->HDISTRICT;
              $post['PARMANENTVILLAGE'] = $request->PARMANENTVILLAGE;
              $post['PARMANENTPOSTOFFICE'] = $request->PARMANENTPOSTOFFICE;
              $post['UPAZILLA'] = $request->UPAZILLA;
              $post['HDISTRICT'] = $request->HDISTRICT;
              $post['PRESENTADDRESS'] = $request->PRESENTADDRESS;
              
              $post['created_at'] = Carbon::now();

              $postdata = DB::table('students')->insert($post);
              
              $notification = array(
            'status' => 'Data successfully saved',
            'alert-type' => 'success'
        );
              
                 return view('backend.erp.success_student_add', [
                 'class_roll' => $classroll,
                 'esif'     => $esif,
                 'page_title' => 'Student Added Successfully',
                 'page_header' => 'Success',   
     
            ],with($notification));
              
             }

            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("login")->with($notification);
     } 
     
    public function student_list() {
        $student_list = DB::table('students')->where('is_exist',0)->orderBy('CLASS_ROLL')->get();

        if(Auth::check()){          
            return view('backend.erp.student_list', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Student List'    
            ],with(compact('student_list')));
        }
  
        $notification = array(
            'status' => 'You are not allowed to access',
            'alert-type' => 'error'
        );
      
    }
    public function student_edit($regno){
        

    
          if(Auth::check()){
              if($regno){
               $district = DB::table('districts')->get();
               $student_detail = DB::table('students')->where('S_REGNO',$regno)->first();

            return view('backend.erp.student_edit', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                 'page_header' => 'Edit Student Info',   
     
            ],with(compact('student_detail','district')));
          }
    }else{
                         return redirect("login")->with($notification);
          }
        
    }
    
    public function updateStudent(Request $request){

      if(Auth::check()){
           
             $cls_sub_list = DB::table('class_subject')->where('GROUP_ID', $request->GROUP_ID)->get();
 
              foreach($cls_sub_list as $key=>$subcode){
                  $subcodearray[$key] =  $subcode->subject;
              }

              $optional_array = [];
              $op_item2 ="";
              $optional_subjects="";
             
 
              foreach($request->OPTIONAL as $op_item){
                  $op_item2 = $op_item+1;
                  $optional_subjects = "$op_item,$op_item2";
                  
              }
             
             unset($subcodearray[array_search($op_item2,$subcodearray)]);
             unset($subcodearray[array_search($op_item2-1,$subcodearray)]);
             array_push($subcodearray,$op_item2-1);
             array_push($subcodearray,$op_item2);

             $subjects_array = json_decode(json_encode($subcodearray), true);
             $subjects = implode(',', $subjects_array);
              
              $post = array();
              if($request->FILENAME){
              $imageName = 'student-'.time().'.'.$request->FILENAME->extension();  
              $request->FILENAME->move(public_path('student_photo/'.$request->S_PYR.''), $imageName); 
              $post['FILENAME'] =  $imageName;
              }else{
                  
              }
               
              $post['S_ROLL'] = $request->S_ROLL;
              $post['S_PYR'] = $request->S_PYR;
              $post['S_REGNO'] = $request->S_REGNO;
              $post['S_SESS1'] = $request->S_SESS1;
              $post['SESSION'] = $request->SESSION;
              $post['REGNO'] = $request->REGNO;
              $post['NAME'] = $request->NAME; 
              $post['SECTION'] = $request->SECTION;
              $post['CLASS_ROLL'] = $request->CLASS_ROLL;
              $post['SEX'] = $request->SEX;
              $post['RELIGION'] = $request->RELIGION;
              $post['FNAME'] = $request->FNAME;
              $post['MOTHER'] = $request->MOTHER;
              $post['S_BOARD'] = $request->S_BOARD;
              $post['OPTIONAL'] = $optional_subjects; 
              $post['SUBJECT'] =  $subjects;
              $post['EIIN'] = $request->EIIN;
              $post['GPA'] = $request->GPA;
              $post['BIRTH_DATE'] = $request->BIRTH_DATE;
              $post['NATIONATY'] = $request->NATIONATY;
              $post['ESIF'] = $request->ESIF;
              $post['SHIFT'] = $request->SHIFT; 
              $post['VERSION'] = $request->VERSION;
              $post['GROUP_ID'] = $request->GROUP_ID;
              $post['HDISTRICT'] = $request->HDISTRICT;
              $post['APPTYPE'] = $request->APPTYPE;
              $post['CONTACT_NO'] = $request->CONTACT_NO;
              $post['created_at'] = Carbon::now();

              $updatedata = DB::table('students')->where('S_REGNO', $request->S_REGNO)->update($post);
              return redirect('admin/erp/student_list')->with('status', 'Data successfully Updated');
            }

            $notification = array(
                'status' => 'You are not allowed to access',
                'alert-type' => 'error'
            );
            return redirect("login")->with($notification);
     } 
     
     public function student_delete($regno){
    
            if(Auth::check()){
                  if($regno){
                           $district = DB::table('districts')->get();
                           $student_detail = DB::table('students')->where('S_REGNO',$regno)->first();
                           $deletestudentdata = DB::table('students')->where('S_REGNO', $regno)->update(['is_exist' => -1]);
                           if($deletestudentdata){
                                 $notification = array(
                            'status' => 'Deleted Succesfully',
                            'alert-type' => 'error');
                           return redirect("admin/erp/student_list")->with($notification);         

                           }else{
                                $notification = array(
                            'status' => 'Delete unsuccessfull',
                            'alert-type' => 'error');
                           return redirect("admin/erp/student_list")->with($notification);
                           }
                  }else{
                       $notification = array(
                        'status' => 'Registration Number not found',
                        'alert-type' => 'error');
                       return redirect("admin/erp/student_list")->with($notification);         
                       }
               }else{
                  $notification = array(
                    'status' => 'You are not allowed to access',
                    'alert-type' => 'error'
                    );
                return redirect("login")->with($notification);         
                };
     }
    public function signOut() {
        Session::flush();
        Auth::logout();

        $notification = array(
            'status' => 'You are successfully logout',
            'alert-type' => 'info'
        );
        return Redirect('login')->with($notification);
    }

    public function get_science_student(){
         if(Auth::check()){

            return view('backend.menu_sub', [
                'page_title' => 'Admin Panel | ARMC, Mymensingh',
                'page_header' => 'Sub Menu'    
            ],with(compact('menu_list')));
        }
  
    }

}

