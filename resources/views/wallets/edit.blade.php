<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Wallet Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <form action="{{ route('wallets.update', $wallet->wallet_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex flex-col">
                        <x-input-label for="wallet_name" value="Wallet Name" class="mb-1" />
                        <x-text-input id="wallet_name" name="wallet_name" type="text" class="w-full" value="{{ old('wallet_name', $wallet->wallet_name) }}" required />
                        <x-input-error :messages="$errors->get('wallet_name')" class="mt-1" />
                    </div>

                    <div class="flex flex-col">
                        <x-input-label for="current_balance" value="Current Balance (PHP)" class="mb-1" />
                        <x-text-input id="current_balance" name="current_balance" type="number" step="0.01" min="0" class="w-full" value="{{ old('current_balance', $wallet->current_balance) }}" required />
                        <x-input-error :messages="$errors->get('current_balance')" class="mt-1 text-xs" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <x-primary-button>
                            {{ __('Save Changes') }}
                        </x-primary-button>

                        <a href="{{ route('wallets.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>