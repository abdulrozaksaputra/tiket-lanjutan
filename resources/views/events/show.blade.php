<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{
             tickets: {
                 @foreach($event->tikets as $tiket)
                     {{ $tiket->id }}: { qty: 0, price: {{ $tiket->harga }}, name: '{{ $tiket->nama }}', stock: {{ $tiket->stok }} },
                 @endforeach
             },
             get totalItems() {
                 return Object.values(this.tickets).reduce((sum, t) => sum + t.qty, 0);
             },
             get totalPrice() {
                 return Object.values(this.tickets).reduce((sum, t) => sum + (t.qty * t.price), 0);
             },
             formatPrice(price) {
                 return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
             }
         }">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm font-medium text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-gray-800 transition-colors">
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-3 text-gray-300"></span> <!-- Wider spacing -->
                        <a href="{{ route('home') }}" class="hover:text-gray-800 transition-colors">
                            Event
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="mx-3 text-gray-300"></span>
                        <span class="text-gray-600">{{ $event->judul }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <!-- Event Image -->
                    <div
                        class="rounded-xl overflow-hidden mb-8 bg-gray-50 aspect-video flex items-center justify-center relative group">
                        @if($event->gambar)
                            <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center gap-2 text-gray-500">
                                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-gray-400 font-medium">{{ $event->judul }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $event->judul }}</h1>

                    <!-- Date & Location -->
                    <div class="flex flex-wrap items-center text-gray-500 text-sm mb-5 gap-3">
                        <span>{{ $event->tanggal_waktu->translatedFormat('d F Y, H:i') }}</span>
                        <span class="text-gray-300">•</span>
                        <div class="flex items-center gap-1 text-gray-500">
                            <!-- Pink properties for the pin -->
                            <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            <span>{{ $event->lokasi }}</span>
                        </div>
                    </div>

                    <!-- Category & User -->
                    <div class="flex items-center gap-3 mb-8">
                        <span
                            class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                            {{ $event->kategori->nama ?? 'Workshop' }}
                        </span>
                        <span class="text-sm text-gray-500 font-medium">
                            {{ $event->user->name ?? 'Admin User' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="prose text-gray-600 mb-8 max-w-none text-sm border-b border-gray-100 pb-8">
                        <p>{{ $event->deskripsi }}</p>
                    </div>

                    <!-- Ticket Section -->
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Pilih Tiket</h3>

                    <div class="space-y-6">
                        @foreach($event->tikets as $tiket)
                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                <!-- Left: Ticket Info -->
                                <div class="mb-4 sm:mb-0">
                                    <div class="font-medium text-gray-900 text-base mb-1">{{ $tiket->nama }}</div>
                                    <div class="text-sm text-gray-500">Stok: {{ $tiket->stok }}</div>
                                </div>

                                <!-- Right: Price & Controls -->
                                <div class="flex flex-col items-end w-full sm:w-auto">
                                    <div class="font-bold text-gray-900 text-lg mb-3">Rp
                                        {{ number_format($tiket->harga, 0, ',', '.') }}
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <!-- Quantity Counter -->
                                        <div class="flex items-center border border-gray-200 rounded-md bg-white shadow-sm">
                                            <button
                                                @click="if(tickets[{{ $tiket->id }}].qty > 0) tickets[{{ $tiket->id }}].qty--"
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-gray-50 disabled:opacity-50 transition rounded-l-md"
                                                :disabled="tickets[{{ $tiket->id }}].qty <= 0">-</button>

                                            <div class="w-12 text-center text-sm font-medium border-x border-gray-200 py-1.5 text-gray-700"
                                                x-text="tickets[{{ $tiket->id }}].qty">0</div>

                                            <button
                                                @click="if(tickets[{{ $tiket->id }}].qty < tickets[{{ $tiket->id }}].stock) tickets[{{ $tiket->id }}].qty++"
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-gray-50 transition rounded-r-md"
                                                :disabled="tickets[{{ $tiket->id }}].qty >= tickets[{{ $tiket->id }}].stock">+</button>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-2 font-medium">
                                        Subtotal: <span
                                            x-text="formatPrice(tickets[{{ $tiket->id }}].qty * tickets[{{ $tiket->id }}].price)">Rp
                                            0</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- Right Column: Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-6 text-lg">Ringkasan Pembelian</h3>

                    <div class="flex justify-between text-sm mb-4 text-gray-500 font-medium">
                        <span>Item</span>
                        <span x-text="totalItems">0</span>
                    </div>
                    <div
                        class="flex justify-between font-bold text-xl mb-6 border-b border-gray-100 pb-6 text-gray-900">
                        <span>Total</span>
                        <span x-text="formatPrice(totalPrice)">Rp 0</span>
                    </div>

                    <!-- Selected Items List (Dynamic) -->
                    <template x-for="(ticket, id) in tickets">
                        <div x-show="ticket.qty > 0" class="flex justify-between text-sm text-gray-500 mb-2">
                            <span x-text="ticket.name + ' x ' + ticket.qty"></span>
                            <span x-text="formatPrice(ticket.price * ticket.qty)"></span>
                        </div>
                    </template>

                    <div x-show="totalItems === 0" class="text-left text-gray-400 text-sm mb-6">
                        Belum ada tiket dipilih
                    </div>

                    @auth
                        <!-- Checkout Form (Hidden, submitted via JS) -->
                        <div x-data="{ 
                                showConfirmModal: false, 
                                paymentTypeId: '',
                                submitCheckout() {
                                    if(!this.paymentTypeId) {
                                        alert('Silakan pilih metode pembayaran');
                                        return;
                                    }

                                    // Show confirmation modal
                                    this.showConfirmModal = true;
                                },
                                processPayment() {
                                    // Prepare data
                                    let formData = {
                                        event_id: {{ $event->id }},
                                        payment_type_id: this.paymentTypeId,
                                        tickets: []
                                    };

                                    for (const [id, ticket] of Object.entries(this.tickets)) {
                                        if (ticket.qty > 0) {
                                            formData.tickets.push({ id: id, qty: ticket.qty });
                                        }
                                    }

                                    fetch('{{ route('checkout.store') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify(formData)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if(data.success) {
                                            window.location.href = data.redirect_url;
                                        } else {
                                            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
                                            this.showConfirmModal = false;
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan sistem.');
                                        this.showConfirmModal = false;
                                    });
                                }
                            }" x-show="totalItems > 0">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                <select x-model="paymentTypeId"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="" disabled selected>Pilih Pembayaran</option>
                                    @foreach($paymentTypes as $payment)
                                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button @click="submitCheckout()" type="button"
                                class="w-full bg-indigo-800 text-white font-bold py-3.5 rounded-lg hover:bg-indigo-900 transition shadow-lg shadow-indigo-100 mt-4">
                                Checkout
                            </button>

                            <!-- Confirmation Modal -->
                            <div x-show="showConfirmModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
                                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div
                                    class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true"
                                        @click="showConfirmModal = false">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                        aria-hidden="true">&#8203;</span>

                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                        id="modal-title">
                                                        Konfirmasi Pembelian
                                                    </h3>
                                                    <div class="mt-4">
                                                        <div class="border-t border-gray-200 py-2">
                                                            <template x-for="(ticket, id) in tickets">
                                                                <div x-show="ticket.qty > 0"
                                                                    class="flex justify-between py-2 text-sm text-gray-600">
                                                                    <span x-text="ticket.name + ' x ' + ticket.qty"></span>
                                                                    <span
                                                                        x-text="formatPrice(ticket.price * ticket.qty)"></span>
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <div
                                                            class="border-t border-gray-200 mt-2 pt-2 flex justify-between font-bold text-gray-900">
                                                            <span>Total</span>
                                                            <span x-text="formatPrice(totalPrice)"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button @click="processPayment()" type="button"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-900 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                Konfirmasi
                                            </button>
                                            <button @click="showConfirmModal = false" type="button"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-indigo-600 text-white font-bold py-3.5 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 mt-4">
                            Login untuk Checkout
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>