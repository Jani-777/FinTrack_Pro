<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        @if(auth()->user()->isAdmin())
            <h3 class="text-lg font-bold">System Administrator Overview</h3>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="bg-blue-100 p-4 rounded shadow">Total Users: {{ \App\Models\User::count() }}</div>
                <div class="bg-green-100 p-4 rounded shadow">Total Categories: {{ \App\Models\Category::count() }}</div>
                <div class="bg-purple-100 p-4 rounded shadow">System Wallets: {{ \App\Models\Wallet::count() }}</div>
            </div>
        @else
            <h3 class="text-lg font-bold">Welcome back, {{ auth()->user()->name }}!</h3>
            <p>You have {{ auth()->user()->wallets->count() }} active wallets.</p>
        @endif
    </div>
</x-app-layout>
