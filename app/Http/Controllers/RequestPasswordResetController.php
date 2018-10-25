<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\RestPassword;
use App\User;

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
        Mail::to($email)->send(new RestPassword);
    }
}
