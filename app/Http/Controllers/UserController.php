<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\APIResponser;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use APIResponser;
    public function userEditAPI(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if ($user) {
            $user->name = $request->input('name');
            $user->gender = $request->input('gender') == 1 ? "Male" : "Female";
            $user->dob = $request->input('dob');
            $user->email = $request->input('email');
            $user->save();
            return $this->respondCollection("Success Update Customer", $user);
        }
        return $this->exceptionResponse("Customer Not Found", 404);
    }
}
