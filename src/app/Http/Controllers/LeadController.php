<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\IncomingLead;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $desired_date = Carbon::create($request->date.' '.$request->time)->toDateTimeString();

        $lead = Lead::create([
           'user_id' => Auth::user()->id,
           'header' => $request->header,
           'description' => $request->description,
           'desired_date' => $desired_date,
           'status' => Lead::STATUS_PENDING,
        ]);

        $managers = User::whereRelation('roles', 'slug', 'manager')->get();
        Notification::send($managers, (new IncomingLead($lead)));

        return redirect()->route('index');
    }
}
