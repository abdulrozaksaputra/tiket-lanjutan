<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HistoriesController extends Controller
{
    public function index()
    {
        $histories = Order::with(['user', 'event', 'detailOrders.tiket'])
            ->latest()
            ->get();
        return view('admin.history.index', compact('histories'));
    }

    public function show(string $history)
    {
        $order = Order::findOrFail($history);
        return view('admin.history.show', compact('order'));
    }

    public function destroy(string $history)
    {
        $order = Order::findOrFail($history);
        $order->delete();
        return redirect()->route('admin.histories.index')->with('success', 'Riwayat telah dihapus.');
    }
}
