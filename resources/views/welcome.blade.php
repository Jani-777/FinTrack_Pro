<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FinTrack Pro | Master Your Finances</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22/><text y=%22.9em%22 x=%2250%%22 font-family=%22sans-serif%22 font-size=%2270%22 font-weight=%22bold%22 fill=%22white%22 text-anchor=%22middle%22>F</text><circle cx=%2280%22 cy=%2280%22 r=%2212%22 fill=%22%2310b981%22/></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    <nav class="absolute w-full z-10 top-0 left-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-2xl shadow-lg relative">
                        F
                        <span class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-emerald-400 border-2 border-indigo-600 rounded-full"></span>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-900">FinTrack <span class="text-indigo-600">Pro</span></span>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-slate-600 hover:text-indigo-600 font-semibold transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-semibold transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-semibold shadow-md transition transform hover:-translate-y-0.5">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-900">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6">
                Take Control of Your <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Financial Future</span>
            </h1>
            <p class="mt-4 max-w-2xl text-lg md:text-xl text-slate-600 mx-auto mb-10">
                FinTrack Pro is the ultimate tool to monitor your income, track your expenses, and achieve your financial goals with ease and precision.
            </p>
            
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl transition transform hover:-translate-y-1">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl transition transform hover:-translate-y-1">Start Tracking for Free</a>
                    <a href="{{ route('login') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-8 py-4 rounded-full font-bold text-lg shadow-sm transition">Sign In</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Everything you need to manage your money</h2>
                <p class="mt-4 text-slate-600">Powerful features designed to keep your finances organized.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">Track Income & Expenses</h3>
                    <p class="text-slate-600">Easily log your daily transactions and categorize them to see exactly where your money is going.</p>
                </div>

                <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">Visual Insights</h3>
                    <p class="text-slate-600">Understand your financial habits at a glance with beautiful, clean, and organized data tables.</p>
                </div>

                <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">Secure & Private</h3>
                    <p class="text-slate-600">Built on modern architecture with role-based access control, ensuring your data remains yours.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-slate-900 py-12 text-center text-slate-400">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-2xl font-bold text-white mb-4">FinTrack <span class="text-indigo-500">Pro</span></div>
            <p>&copy; {{ date('Y') }} FinTrack Pro. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>