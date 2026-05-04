<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22/><text y=%22.9em%22 x=%2250%%22 font-family=%22sans-serif%22 font-size=%2270%22 font-weight=%22bold%22 fill=%22white%22 text-anchor=%22middle%22>F</text><circle cx=%2280%22 cy=%2280%22 r=%2212%22 fill=%22%2310b981%22/></svg>">    
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center py-16 bg-slate-50 px-4">
            
            <div class="w-full sm:max-w-lg mb-8">
                <a href="/" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-indigo-600 transition-colors duration-200 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>

            <div class="animate-fade-up">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
                </a>
            </div>

            <div class="w-full sm:max-w-lg mt-8 px-8 py-8 bg-white shadow-xl shadow-slate-200/60 overflow-hidden sm:rounded-2xl border border-slate-100 animate-fade-up delay-100">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-slate-400 text-xs">
                &copy; {{ date('Y') }} FinTrack Pro System
            </div>
        </div>
    </body>
</html>