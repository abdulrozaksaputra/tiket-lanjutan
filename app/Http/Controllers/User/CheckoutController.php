<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'tickets' => 'required|array',
            'tickets.*.id' => 'required|exists:tikets,id',
            'tickets.*.qty' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total price and validate stock
            $totalPrice = 0;
            $ticketData = [];

            foreach ($request->tickets as $ticketInput) {
                if ($ticketInput['qty'] > 0) {
                    $ticket = Tiket::lockForUpdate()->find($ticketInput['id']);

                    if ($ticket->stok < $ticketInput['qty']) {
                        throw new \Exception("Stok tiket {$ticket->nama} tidak mencukupi.");
                    }

                    $subtotal = $ticket->harga * $ticketInput['qty'];
                    $totalPrice += $subtotal;

                    $ticketData[] = [
                        'tiket_id' => $ticket->id,
                        'qty' => $ticketInput['qty'],
                        'price' => $ticket->harga,
                        'subtotal' => $subtotal,
                        'model' => $ticket
                    ];
                }
            }

            if (empty($ticketData)) {
                throw new \Exception("Silakan pilih minimal satu tiket.");
            }

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'order_date' => now(),
                'total_harga' => $totalPrice, // You might want to add 'payment_type_id' to orders table if needed, currently not requested but good practice.
            ]);

            // Simpan detail order dan kurangi stok
            foreach ($ticketData as $data) {
                DetailOrder::create([
                    'order_id' => $order->id,
                    'tiket_id' => $data['tiket_id'],
                    'jumlah' => $data['qty'],
                    'subtotal_harga' => $data['subtotal'],
                ]);

                $data['model']->decrement('stok', $data['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('history.show', $order->id) // Redirect to detail page
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
