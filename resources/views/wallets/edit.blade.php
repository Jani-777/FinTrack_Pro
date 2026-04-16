<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Edit Wallet</h2></x-slot>

    <div class="py-12 max-w-md mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('wallets.update', $wallet->wallet_id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label value="Wallet Name" />
                    <x-text-input name="wallet_name" type="text" class="w-full" value="{{ $wallet->wallet_name }}" required />
                </div>
                <div>
                    <x-input-label value="Balance" />
                    <x-text-input name="current_balance" type="number" step="0.01" class="w-full" value="{{ $wallet->current_balance }}" required />
                </div>
                <x-primary-button>Save Changes</x-primary-button>
                <a href="{{ route('wallets.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
            </form>
        </div>
    </div>
</x-app-layout>