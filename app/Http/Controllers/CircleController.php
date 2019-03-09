<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Controllers\Traits\APIResponser;
use App\Invoice;
use App\Transcations;
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
            array_push($userCollection, $user['user_id']);
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
            $transcation = new Transcations();
            $transcation->trans_no = "0000" . $i++;
            $transcation->user_id = $user['user_id'];
            $transcation->amounts = $user['amount'];
            $transcation->invoice_id = $invoice->id;
            $transcation->status = 0;
            $transcation->save();
        }


        return $this->respondCollection("Create Circle", $circle);
    }
}
