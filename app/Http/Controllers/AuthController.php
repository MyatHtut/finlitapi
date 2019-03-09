<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\APIResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponser;

    public function signUp(Request $request)
    {
        $user = User::where('phone_number', $request->input('phone_number'))->first();
        if (!$user) {
            $user = new User();
            $user->phone_number = $request->input('phone_number');
            $user->save();
            $this->generateOTP($user);
        } elseif ($user->is_otp_confirm == false) {
            $this->generateOTP($user);
        }
//        $return_customer = $this->customerResponse($user);
        return $this->respondCollection("Success", $user);
    }

    public function verifyOtp(Request $request)
    {
        $otpQuery = User::where('otp', $request['otp'])->where('phone_no', $request['phone_number'])->first();
        if ($otpQuery) {
            $user = User::where('phone_number', $request['phone_number'])->first();
            $user->is_otp_confirm = true;
            $user->save();
            $return_customer = $this->customerResponse($user);
            return $this->respondCollection("Success OTP confirm", $return_customer);
        }
        return $this->exceptionResponse("OTP incorrect", 400);
    }

    public function firstTimePassword(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if ($user) {
            $this->setPassword($user, $request->password);
            $return_customer = $this->customerResponse($user);
            return $this->respondCollection("Success Password Set", $return_customer);
        }
        return $this->exceptionResponse("Customer Not Found", 404);
    }

    public function loginByPhoneNumberAndPassword(Request $request)
    {
        $customer = User::where('phone_number', $request->phone_number)->first();
        if ($customer && Hash::check($request->password, $customer->password)) {

            return $this->respondCollection("Success Password Set", $customer);
        }
        return $this->exceptionResponse("Login Fail", 400);

    }

//    public function logout(Request $request)
//    {
//        JWTAuth::parseToken()->invalidate();
//        return $this->respondSuccessMsgOnly("User successfully logged out.");
//    }

    public function setPassword($customer, $password)
    {
        $customer->password = Hash::make($password);
        $customer->save();
    }

    public function generateOTP($user)
    {
        $user=User::find($user->id);
        $otpCode = "123456";
        $user->otp = $otpCode;
        $user->save();
    }

    /**
     * @param $customer
     * @return \stdClass
     */
    private function customerResponse($customer, $isCompleteData = false, $token = ""): \stdClass
    {
        if ($isCompleteData) {
            $return_customer = new \stdClass();
            $return_customer->id = $customer->id;
            $return_customer->name = $customer->name;
            $return_customer->email = $customer->email;
            $return_customer->dob = $customer->dob;
            $return_customer->photo_path = $customer->photo_path;
            $return_customer->gender = $customer->gender;
            $return_customer->is_otp_confirm = (boolean)$customer->is_otp_confirm;
            $return_customer->phone_number = $customer->phone_number;
            $return_customer->is_password_set = $customer->password == "" || $customer->password == null ? false : true;
            $return_customer->token = $token;

        } else {
            $return_customer = new \stdClass();
            $return_customer->id = $customer->id;
            $return_customer->is_otp_confirm = (boolean)$customer->is_otp_confirm;
            $return_customer->phone_number = $customer->phone_number;
            $return_customer->is_password_set = $customer->password == "" || $customer->password == null ? false : true;
        }
        return $return_customer;
    }
}
