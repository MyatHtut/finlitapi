<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Controllers\Traits\APIResponser;
use App\Invoice;
use App\Transcations;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class CircleController extends Controller
{
    use APIResponser;

    public function create(Request $request)
    {
        $i = 0;
        $data = $request->all();
        $userCollection = [];

        foreach ($data['users'] as $user) {
            $newuser = new User();
            $newuser->name = $user['name'];
            $newuser->phone_number = $user['phone_number'];
            $newuser->save();
            array_push($userCollection, $newuser->id);
        }
        $circle = new Circle();
        $circle->name = $request->input('name');
        $circle->total_amount = $request->input('total_amounts');
        $circle->save();
        $circle->user()->attach($userCollection);

        $invoice = new Invoice();
        $invoice->invoice_no = "000011";
        $invoice->total_amounts = $data['total_amounts'];
        $invoice->date = Carbon::today()->toDateString();
        $invoice->circle_id = $circle->id;
        $invoice->save();
        foreach ($data['users'] as $user) {
            $userQuery = User::where('phone_number', $user['phone_number'])->first();
            $transcation = new Transcations();
            $transcation->trans_no = "0000" . $i++;
            $transcation->user_id = $userQuery->id;
            $transcation->amounts = $user['amount'];
            $transcation->invoice_id = $invoice->id;
            $transcation->status = 0;
            $transcation->save();
        }


        return $this->respondCollection("Create Circle", $circle);
    }

    public function circleDetail($id)
    {
        $circle = Circle::where('id', $id)->with(['user', 'invoice.transcation'])->first();
        return $this->respondCollection("success to get Circle Detail", $circle);
//        return $circle;
//        return $circle->user()->get();

    }

    public function index($userID)
    {
        $users = User::where("id", $userID)->with(['circle.invoice.transcation'])->get();
        return $this->respondCollection("success", $users);
    }
}
