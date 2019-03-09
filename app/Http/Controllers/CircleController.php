<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Controllers\Traits\APIResponser;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    use APIResponser;
    public function create(Request $request)
    {

        $data=$request->all();
        $userCollection=[];
        foreach ($data['users'] as $user){
            array_push($userCollection,$user['user_id']);
        }
        $circle = new Circle();
        $circle->name = $request->input('name');
        $circle->total_amount = $request->input('total_amount');
        $circle->save();
        $circle->user()->attach($userCollection);

        return $this->respondCollection("Create Circle", $circle);
    }
}
