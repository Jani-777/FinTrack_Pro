<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Transaction</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form action="{{ route('transactions.update', $transaction->transaction_id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <x-input-label value="Wallet" />
                        <select name="wallet_id" class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_id }}" {{ old('wallet_id', $transaction->wallet_id) == $wallet->wallet_id ? 'selected' : '' }}>
                                    {{ $wallet->wallet_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('wallet_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label value="Amount (PHP)" />
                        <x-text-input name="amount" type="number" step="0.01" min="0.01" class="w-full" value="{{ old('amount', $transaction->amount) }}" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label value="Category" />
                        <select name="category_id" class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id', $transaction->category_id) == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }} ({{ $category->type }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label value="Description" />
                        <x-text-input name="description" type="text" class="w-full" value="{{ old('description', $transaction->description) }}" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label value="Date" />
                        <x-text-input name="transaction_date" type="date" class="w-full" value="{{ old('transaction_date', $transaction->transaction_date) }}" required />
                        <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>
                            {{ __('Update Transaction') }}
                        </x-primary-button>

                        <a href="{{ route('transactions.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Go Back') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>