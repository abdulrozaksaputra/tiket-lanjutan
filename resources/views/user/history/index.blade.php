<x-layouts.app>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if (session('success'))
            <div class="toast toast-bottom toast-center z-50">
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    document.querySelector('.toast')?.remove()
                }, 3000)
            </script>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Pembelian</h2>
            @if ($orders->count() > 0)
                <button onclick="openDeleteAllModal()"
                    class="text-red-500 hover:text-red-700 text-sm font-semibold transition-colors duration-200 flex items-center gap-1 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus Semua Riwayat</span>
                </button>
            @endif
        </div>

        <div class="space-y-4">
            @forelse ($orders as $order)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col sm:flex-row gap-6 items-center group relative">
                    <!-- Event Image -->
                    <div class="w-full sm:w-80 h-40 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        @if ($order->event && $order->event->gambar)
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
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <button onclick="openDeleteModal({{ $order->id }})"
                                        class="text-red-600 hover:text-red-800 text-base font-bold transition-colors">
                                        Hapus
                                    </button>
                                    <a href="{{ route('history.show', $order->id) }}"
                                        class="flex-grow sm:flex-grow-0 inline-block bg-indigo-600 text-white text-sm font-semibold px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm text-center">
                                        Lihat Detail
                                    </a>
                                </div>
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

    <!-- Delete Single Confirmation Modal -->
    <dialog id="delete_modal" class="modal">
        <div class="modal-box max-w-sm text-center bg-blue-50 border-2 border-blue-100 shadow-xl">
            <div
                class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-gray-900">Hapus Riwayat?</h3>
            <p class="text-gray-600 mb-6">Tindakan ini tidak dapat dibatalkan. Riwayat pesanan ini akan dihapus
                permanen.</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="delete_modal.close()"
                        class="btn flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="btn flex-1 bg-red-600 hover:bg-red-700 text-white border-none">Ya,
                        Hapus</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button class="outline-none border-none bg-transparent h-0 w-0 p-0 overflow-hidden opacity-0"></button>
        </form>
    </dialog>

    <!-- Delete All Confirmation Modal -->
    <dialog id="delete_all_modal" class="modal">
        <div class="modal-box max-w-sm text-center bg-blue-50 border-2 border-blue-100 shadow-xl">
            <div
                class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-gray-900">Hapus SEMUA Riwayat?</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus seluruh riwayat pembelian Anda? Tindakan ini
                permanen.</p>
            <form action="{{ route('history.destroyAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="delete_all_modal.close()"
                        class="btn flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="btn flex-1 bg-red-600 hover:bg-red-700 text-white border-none">Ya,
                        Hapus Semua</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button class="outline-none border-none bg-transparent h-0 w-0 p-0 overflow-hidden opacity-0"></button>
        </form>
    </dialog>

    <script>
        function openDeleteModal(orderId) {
            const form = document.getElementById('deleteForm');
            form.action = `/history/${orderId}`;
            delete_modal.showModal();
        }

        function openDeleteAllModal() {
            delete_all_modal.showModal();
        }
    </script>
</x-layouts.app>