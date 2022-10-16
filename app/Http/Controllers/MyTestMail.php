<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Country;
use App\Models\User;
use App\Models\CustomDatatableColumn;
use Illuminate\Http\File;
use Auth;
use Validator;
use Session;
use App\Models\Role;
use Carbon\Carbon;

class MyTestMail extends Controller
{
    /**
     * Build the message.
     *
     * @return $this
     */
    // public function checkEmail()
    // {
    //     echo "testing";
    // $data=['name'=> "Vishal", 'data'=> "Hello vishal"];
    // $user['to'] = 'darahat42@gmail.com';
    // Mail::send('myTestMail',$data,function($messages) use ($user){
    //     $messages->to('darahat42@gmail.com');
    //     $messages->subject('Hello dev');
    // });
    // }
    public function Passwordrecovery(Request $request)
    {
        // dd($request->all());
        // exit;
        $check = DB::table($request->table)->where($request->field, '=', $request->value)->orWhere('mobile_number', '=', $request->value)->first();
        // $check = DB::table($request->table)->where($request->field, '=', $request->value)->first();
        if ($check) {
            // $id = $request->id;
            // $user = $request->username;
            $update_details = array(
                'payment_approve' => 1,
                'update_time' => Carbon::now(),
            );
            //    $applicant = DB::table('registration')->where('username', $user)->first();
            // return $applicant;
            $email = $check->email;
            //    $email = $applicant->email;
            $sub = "Zyco | Password recovery";
            $body = "
            <html>
			<head>
			</head>
			<body>
			Dear,
			<p>Greetings from the Zyco</p>
            Your password changed successfully.	
			<br><br>
			 
			</body>
			</html>";
            //    $payment_update = DB::table('registration')->where('username', $user)->update($update_details);
            //    $payment = DB::table('payment')->where('ID', $id)->update($update_details);
            $this->composeEmail($email, $sub, $body);
            $notification = array(
                'status' => 'Your password changed successfully.',
                'alert-type' => 'success'
            );
            return $check->alt_email;
        } else {
            return null;
        }
    }
    public function RegistrationComplete(Request $request)
    {
        $check = DB::table($request->table)->where($request->field, '=', $request->value)->orWhere('mobile_number', '=', $request->value)->first();

        //$amount = 30; 

        //$ps1 .= str_replace("{{amount}}",$amount,$data->message);
        // $ps1 .= str_replace("{{curr_code}}",'$',$ps1);
        //echo $ps1;

        // $check = DB::table($request->table)->where($request->field, '=', $request->value)->first();
        if ($check) {
            // dd($request->all());
            // exit;
            // $id = $request->id;
            // $user = $request->username;
            // $applicant = DB::table('registration')->where('username', $user)->first();
            // return $applicant;
            $email = $request->value;
            // $email = $applicant->email;
            $sub = "Zyco | Account Creation Successfull";
            $body = "
<html>

    <head>
    </head>

    <body>
        Dear,
        <p>Greetings from the Zyco</p>
        Account created Succesfully
        <br><br>
    </body>

</html>";
            $this->composeEmail($email, $sub, $body);
            return $email;
        } else {
            return null;
        }
    }
    public function Emailrecovery(Request $request)
    {
        // dd($request->all());
        // exit;
        $check = DB::table($request->table)->where($request->field, '=', $request->value)->orWhere(
            'mobile_number',
            '=',
            $request->value
        )->first();
        // $check = DB::table($request->table)->where($request->field, '=', $request->value)->first();
        if ($check) {
            // $id = $request->id;
            // $user = $request->username;
            $update_details = array(
                'payment_approve' => 1,
                'update_time' => Carbon::now(),
            );
            // $applicant = DB::table('registration')->where('username', $user)->first();
            // return $applicant;
            $email = $request->value;
            // $email = $applicant->email;
            $sub = "Zyco | Email recovery";
            $body = "
<html>

    <head>
    </head>

    <body>
        Dear,
        <p>Greetings from the Zyco</p>
        Your Recovered Email address is " . $check->email . "
        <br><br>
    </body>

</html>";
            // $payment_update = DB::table('registration')->where('username', $user)->update($update_details);
            // $payment = DB::table('payment')->where('ID', $id)->update($update_details);
            $this->composeEmail($email, $sub, $body);
            $notification = array(
                'status' => 'Payment status changed successfully',
                'alert-type' => 'success'
            );
            return $check->alt_email;
        } else {
            return null;
        }
    }
    public function composeEmail($email, $sub, $body)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'ns1.ihostbd.net'; // smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@wvpaam2022.com'; // sender username
            $mail->Password = 'VsZbsFnIzpC0'; // sender password
            $mail->SMTPSecure = 'ssl'; // encryption - ssl/tls
            $mail->Port = 465; // port - 587/465
            $mail->setFrom('no-reply@wvpaam2022.com', 'zyco.nl');
            $mail->addAddress($email);
            $mail->addReplyTo('no-reply@wvpaam2022.com', 'zyco.nl');
            $mail->isHTML(true); // Set email content format to HTML
            $mail->Subject = $sub;
            $mail->Body = $body;
            // $mail->AltBody = plain text version of email body;
            if (!$mail->send()) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            } else {
                return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
            return back()->with('error', 'Message could not be sent.');
        }
    }
}