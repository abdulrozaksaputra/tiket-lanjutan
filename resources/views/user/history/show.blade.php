<x-layouts.app>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center sm:text-left">Detail Pemesanan</h2>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Section with Event Image & Info -->
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-start border-b border-gray-100">
                <div
                    class="w-full sm:w-1/3 bg-gray-100 rounded-xl overflow-hidden aspect-video sm:aspect-[4/3] flex-shrink-0">
                    @if($order->event && $order->event->gambar)
                        <img src="{{ asset('images/events/' . $order->event->gambar) }}" alt="{{ $order->event->judul }}"
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
                    <div class="flex flex-col-reverse sm:flex-row justify-between items-start mb-4">
                        <div>
                            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">
                                ORDER #{{ $order->id }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $order->created_at->format('d F Y, H:i') }}
                            </div>
                        </div>
                        <div class="text-xl font-bold text-indigo-900 mb-2 sm:mb-0">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">{{ $order->event->judul }}</h3>

                    <div class="flex items-start text-gray-500 text-sm gap-2">
                        <svg class="w-5 h-5 text-pink-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $order->event->lokasi }}</span>
                    </div>
                </div>
            </div>

            <!-- Tiket Details -->
            <div class="p-6 sm:p-8 bg-gray-50/50">
                <h4 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Rincian Tiket</h4>
                <div class="space-y-3">
                    @foreach($order->detailOrders as $detail)
                        <div
                            class="flex justify-between items-center py-3 border-b border-gray-200 last:border-0 border-dashed">
                            <div>
                                <div class="font-medium text-gray-900">{{ ucfirst($detail->tiket->tipe) }}</div>
                                <div class="text-sm text-gray-500">Qty: {{ $detail->jumlah }}</div>
                            </div>
                            <div class="font-medium text-gray-900">
                                Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <span class="font-bold text-gray-900 text-lg">Total</span>
                    <span class="font-bold text-indigo-700 text-xl">Rp
                        {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <div class="mt-8">
                    <a href="{{ route('history.index') }}"
                        class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-indigo-200">
                        Kembali ke Riwayat Pembelian
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>