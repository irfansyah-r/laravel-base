<div class="md:translate-x-0 fixed shadow-xl bg-white w-56 h-full text-blue-100 h-screen min-w-max pb-4 md:mt-0 transform transition duration-500 ease-in-out z-20" :class="{ 'md:-translate-x-full': !isOpen, '-translate-x-full': !isOpen }">
    <a href="#home" class="text-black flex md:justify-start justify-center items-center h-16 space-x-2 px-8">
        {{-- <span class="text-xl font-extrabold">UjiCrypto</span> --}}
        <img class="w-28" src="{{ asset('images/logo.png') }}" />
    </a>
    <div class="bg-gray-50 text-black p-6 -ml-2">
        <div>Welcome,</div>
        <span class="font-bold">{{Auth::user()->name}}</span>
    </div>

    <nav class="text-gray-700 flex flex-col ml-0 space-y-2 m-6">
        <a href="/dashboard" class="{{ Request::is('dashboard') ? 'font-bold':'' }} flex pl-8 space-x-4 hover:text-black hover:font-bold">
            <span class="my-auto">Dashboard</span>
        </a>
        <a href="/users" class="{{ Request::is('users') ? 'font-bold':'' }} flex pl-8 space-x-4 hover:text-black hover:font-bold">
            <span class="my-auto">Users</span>
        </a>
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a onclick="event.preventDefault();
            this.closest('form').submit();" class="cursor-pointer flex pl-8 space-x-4 hover:text-red-500 hover:font-semibold">
                <span class="my-auto">Logout</span>
            </a>
        </form>
    </nav>
    <div class="w-full fixed flex justify-center md:hidden">
        <div class="rounded-full mx-2">
            <button x-on:click="isOpen = !isOpen" class="items-center justify-center p-2 text-black hover:bg-red-500 hover:text-white rounded-full focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
