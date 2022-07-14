<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $desired_date = Carbon::create($request->date.' '.$request->time)->toDateTimeString();

        Lead::create([
           'user_id' => Auth::user()->id,
           'header' => $request->header,
           'description' => $request->description,
           'desired_date' => $desired_date,
           'status' => Lead::STATUS_PENDING,
        ]);

        return redirect()->route('index');
    }
}
//TODO permissions
