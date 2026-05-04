<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\SystemSetting::where('setting_name', 'App_Name')->first()->setting_value ?? 'FinTrack' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22/><text y=%22.9em%22 x=%2250%%22 font-family=%22sans-serif%22 font-size=%2270%22 font-weight=%22bold%22 fill=%22white%22 text-anchor=%22middle%22>F</text><circle cx=%2280%22 cy=%2280%22 r=%2212%22 fill=%22%2310b981%22/></svg>">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                    @if (session('success'))
                        <div x-data="{ show: true }" 
                            x-show="show" 
                            x-init="setTimeout(() => show = false, 3000)"
                            class="mb-4 p-4 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-xl flex justify-between items-center animate-fade-up">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 text-xl font-bold">&times;</button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
