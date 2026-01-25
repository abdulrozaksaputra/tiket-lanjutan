<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Event;

class HistorySeeder extends Seeder
{
    public function run()
    {
        $user = User::where('role', 'user')->first() ?? User::first();
        $event = Event::first();

        if ($user && $event) {
            Order::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'order_date' => now(),
                'total_harga' => 150000,
            ]);

            Order::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'order_date' => now()->subDays(2),
                'total_harga' => 300000,
            ]);
        }
    }
}
