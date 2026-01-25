<nav class="w-full bg-white shadow flex justify-between items-center px-8 py-4 fixed top-0 left-0 z-50">
    <div>
        <a href="{{ url('/') }}">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
        </a>
    </div>
    <div>
        @guest
            <a href="{{ route('login') }}"
                class="px-4 py-2 rounded bg-blue-700 text-white font-semibold hover:bg-blue-800 mr-2">Login</a>
            <a href="{{ route('register') }}"
                class="px-4 py-2 rounded border border-blue-700 text-blue-700 font-semibold hover:bg-blue-700 hover:text-white">Register</a>
        @else
            <div class="flex items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>Halo, {{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Admin Dashboard Link -->
                        @if (Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @endguest
    </div>
</nav>
<div class="pt-20"></div>