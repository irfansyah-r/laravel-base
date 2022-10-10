<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <style>
            [x-cloak] { display: none !important; }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
        <div class="font-sans antialiased md:overflow-auto">
            <div class="min-h-screen bg-gray-100 flex md:flex-row flex-col" x-data="{ isOpen: true }"
                @resize.window="width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                if (width < 900) {
                    isOpen = false
                }else{
                    isOpen = true
                }"
            >

                <header class="md:bg-transparent bg-white w-full h-16 absolute flex flex-1 items-center">
                    <!-- <div class="max-w-7xl mx-6 rounded-full hover:bg-gray-300 transform transition duration-500 ease-in-out md:mx-72"> -->
                    <div class="max-w-7xl mx-6 rounded-full hover:bg-gray-300 transform transition duration-500 ease-in-out md:mx-28" :class="{ 'md:translate-x-36': isOpen }">
                        <button x-on:click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 text-gray-800 hover:text-black focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </header>

                @include('layouts.sidenav')

                <!-- Page Content -->
                <main class="mx-8 mt-20 mb-10 md:ml-56 transform transition duration-500 ease-in-out md:w-full md:-translate-x-0 overflow-hidden md:px-8" :class="{ 'md:-translate-x-56': !isOpen, 'md:-mr-56': !isOpen }">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
