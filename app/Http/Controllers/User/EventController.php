<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $paymentTypes = \App\Models\PaymentType::all();
        return view('events.show', compact('event', 'paymentTypes'));
    }
}
