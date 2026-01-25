<x-layouts.app>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Riwayat Pembelian</h2>

        <div class="space-y-4">
            @forelse ($orders as $order)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col sm:flex-row gap-6 items-center">
                    <!-- Event Image -->
                    <div class="w-full sm:w-80 h-40 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        @if($order->event && $order->event->gambar)
                            <img src="{{ asset('storage/' . $order->event->gambar) }}" alt="{{ $order->event->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full">
                            <div class="mb-4 sm:mb-0">
                                <div class="text-sm text-gray-500 mb-1">
                                    <span class="font-bold text-gray-700">Order #{{ $order->id }}</span> <br>
                                    {{ $order->created_at->format('d F Y, H:i') }}
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $order->event->judul }}</h3>
                                <div class="text-gray-500 text-sm mt-1">{{ $order->event->lokasi }}</div>
                            </div>

                            <div class="text-right flex flex-col items-end gap-3 h-full justify-center min-w-[150px]">
                                <div class="font-bold text-gray-900 text-lg">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('history.show', $order->id) }}"
                                    class="inline-block bg-indigo-600 text-white text-sm font-semibold px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                    <p class="text-gray-500 text-sm mb-6">Kamu belum melakukan pembelian tiket apapun.</p>
                    <a href="{{ route('home') }}" class="text-indigo-600 font-semibold hover:text-indigo-800">Cari Event
                        Seru</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>