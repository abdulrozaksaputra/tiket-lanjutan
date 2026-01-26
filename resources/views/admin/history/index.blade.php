<x-layouts.admin title="History Pembelian">
    <div class="container mx-auto p-10">
        @if (session('success'))
            <div class="toast toast-top toast-end z-50">
                <div class="alert alert-success">
                    <span class="text-white font-bold">{{ session('success') }}</span>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    document.querySelector('.toast')?.remove()
                }, 3000)
            </script>
        @endif

        <div class="flex">
            <h1 class="text-3xl font-semibold mb-4">History Pembelian</h1>
        </div>
        <div class="overflow-x-auto rounded-box bg-white p-5 shadow-xs">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Event</th>
                        <th>Tipe Tiket</th>
                        <th>Tanggal Pembelian</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($histories as $index => $history)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $history->user->name }}</td>
                            <td>{{ $history->event?->judul ?? '-' }}</td>
                            <td>
                                @foreach($history->detailOrders->unique('tiket.tipe') as $detail)
                                    <span
                                        class="badge badge-link font-bold text-xs">{{ ucfirst($detail->tiket?->tipe ?? '-') }}</span>
                                @endforeach
                            </td>
                            <td>{{ $history->created_at->format('d M Y') }}</td>
                            <td>{{ number_format($history->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.histories.show', $history->id) }}"
                                        class="btn btn-sm btn-info text-white">Detail</a>
                                    <button onclick="openAdminDeleteModal({{ $history->id }})"
                                        class="text-red-600 hover:text-red-800 text-sm font-bold transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada history pembelian tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Delete Confirmation Modal -->
    <dialog id="admin_delete_modal" class="modal">
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
            <p class="text-gray-600 mb-6 text-sm">Tindakan ini tidak dapat dibatalkan. Riwayat pesanan ini akan dihapus
                permanen dari sistem.</p>
            <form id="adminDeleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="admin_delete_modal.close()"
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

    <script>
        function openAdminDeleteModal(historyId) {
            const form = document.getElementById('adminDeleteForm');
            form.action = `/admin/histories/${historyId}`;
            admin_delete_modal.showModal();
        }
    </script>
</x-layouts.admin>