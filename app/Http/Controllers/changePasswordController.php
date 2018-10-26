<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\changePasswordRequest;
use DB;
use App\User;

class changePasswordController extends Controller
{
    public function resetPassword(changePasswordRequest $request){
        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePassword($request):$this->tokenNotFoundResponse();
    }

    private function changePassword($request) {
        // Get User
        DB::table('users')->where('email', $request->email)->update(['password' => bcrypt($request->password)]);
        // After delete the password request row
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data'=>'Successfully Changed the password'],Response::HTTP_CREATED);
    }

    private function tokenNotFoundResponse() {
        return response()->json(['error' => 'Email or Token is Incorrect!!'],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getPasswordResetTableRow($request) {
        return DB::table('password_resets')->where(['email' => $request->email,'token' => $request->resetToken]);
    }
}
