@props(['label', 'active' => false])

<div
    class="{{ $active ? 'bg-blue-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} px-4 py-2 rounded-full text-sm font-semibold transition-colors duration-200 cursor-pointer border border-transparent">
    {{ $label }}
</div>