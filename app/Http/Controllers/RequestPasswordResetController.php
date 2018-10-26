<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\RestPassword;
use App\User;
use DB;
use Carbon\Carbon;

class RequestPasswordResetController extends Controller
{
    public function send_email(Request $request)
    {
        if(!$this->validateEmail($request->email)){
           return $this->failedResponse();
        }
        $this->sendEmail($request->email);
        // success response
        return $this->successResponse();
    }

    public function validateEmail($email)
    {
        // Make it return true or false
        return !!User::where('email',$email)->first();
    }
   //  Function handling error in the Response
    public function failedResponse(){
        return response()->json([
            'error' => 'Email not Found on our Database'
        ],Response::HTTP_NOT_FOUND);
    }
     // success response function 
    public function successResponse(){
        return response()->json([
            'success' => 'Email Reset Password Sent Successfully,Please Check Your Email'
        ],Response::HTTP_OK);
    }

    // Hold sending Email logic
    public function sendEmail($email){
        $token = $this->createToken($email);
        Mail::to($email)->send(new RestPassword($token));
    }

    // Function to create a token
    public function createToken($email){
        $oldToken = DB::table('password_resets')->where('email',$email)->first();
        if($oldToken) {
            return $oldToken->token;
        }
        else{
            $token = str_random(60);
            $this->saveToken($token,$email);
            return $token;
        }
       
    }
    // Function to save token in password resets table
    public function saveToken($token, $email){
        DB::table('password_resets')->insert(
            [
                'email' => $email,
                'token' => $token,
                'created_at'=> Carbon::now()
            ]
        );
    }

}
