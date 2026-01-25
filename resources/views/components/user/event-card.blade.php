@props(['title', 'date', 'location', 'price', 'image', 'href'])

<a href="{{ $href }}" class="group block h-full">
    <div
        class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
        <!-- Image Container -->
        <div class="relative aspect-[4/3] overflow-hidden rounded-lg mb-4 bg-gray-100">
            @if($image)
                <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
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

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <h3 class="font-medium text-gray-900 text-base mb-2 line-clamp-2">{{ $title }}</h3>

            <div class="space-y-1 mb-4">
                <div class="text-gray-500 text-xs">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y, H:i') }}
                </div>

                <div class="flex items-center text-gray-500 text-xs">
                    <svg class="w-3 h-3 mr-1.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                    <span class="truncate">{{ $location }}</span>
                </div>
            </div>

            <div class="mt-auto font-bold text-gray-900">
                @if($price == 0)
                    Gratis
                @else
                    Rp {{ number_format($price, 0, ',', '.') }}
                @endif
            </div>
        </div>
    </div>
</a>