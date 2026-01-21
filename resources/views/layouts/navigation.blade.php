<nav class="w-full bg-white shadow flex justify-between items-center px-8 py-4 fixed top-0 left-0 z-50">
    <div>
        <a href="{{ url('/') }}">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
        </a>
    </div>
    <div>
        @guest
            <a href="{{ route('login') }}" class="px-4 py-2 rounded bg-blue-700 text-white font-semibold hover:bg-blue-800 mr-2">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 rounded border border-blue-700 text-blue-700 font-semibold hover:bg-blue-700 hover:text-white">Register</a>
        @else
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded bg-blue-700 text-white font-semibold hover:bg-blue-800">Dashboard</a>
        @endguest
    </div>
</nav>
<div class="pt-20"></div>
