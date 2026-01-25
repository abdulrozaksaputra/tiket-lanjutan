<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->get();

        return view('user.history.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['event', 'tikets', 'detailOrders.tiket']);

        return view('user.history.show', compact('order'));
    }
}
