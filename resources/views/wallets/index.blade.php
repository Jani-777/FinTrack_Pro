<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Wallets & Accounts</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h3 class="font-bold mb-4">Add New Fund Source</h3>
            <form action="{{ route('wallets.store') }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <x-input-label for="wallet_name" value="Account Name (e.g. Cash, Bank)" />
                    <x-text-input id="wallet_name" name="wallet_name" type="text" class="block w-full mt-1" required />
                </div>
                <div class="flex-1">
                    <x-input-label for="current_balance" value="Initial Balance (PHP)" />
                    <x-text-input id="current_balance" name="current_balance" type="number" step="0.01" class="block w-full mt-1" required />
                </div>
                <x-primary-button>Create Wallet</x-primary-button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($wallets as $wallet)
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-indigo-500 flex flex-col justify-between">
                    <div>
                        <h4 class="text-gray-500 text-sm uppercase font-bold tracking-wider">{{ $wallet->wallet_name }}</h4>
                        <p class="text-3xl font-black mt-2 text-slate-800">
                            ₱{{ number_format($wallet->current_balance, 2) }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-mono">Wallet</span>
                        
                        <div class="flex items-center gap-4">
                            <a href="{{ route('wallets.edit', $wallet->wallet_id) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 leading-none">
                                Edit
                            </a>
                            
                            <form action="{{ route('wallets.destroy', $wallet->wallet_id) }}" method="POST" class="flex items-center m-0" onsubmit="return confirm('Delete wallet?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-800 leading-none">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>