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
                        <select name="wallet_id" class="w-full border-gray-300 rounded-md">
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_id }}" {{ $transaction->wallet_id == $wallet->wallet_id ? 'selected' : '' }}>{{ $wallet->wallet_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Amount" />
                        <x-text-input name="amount" type="number" step="0.01" class="w-full" value="{{ $transaction->amount }}" required />
                    </div>

                    <div>
                        <x-input-label value="Category" />
                        <select name="category_id" class="w-full border-gray-300 rounded-md">
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ $transaction->category_id == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Description" />
                        <x-text-input name="description" type="text" class="w-full" value="{{ $transaction->description }}" />
                    </div>

                    <div>
                        <x-input-label value="Date" />
                        <x-text-input name="transaction_date" type="date" class="w-full" value="{{ $transaction->transaction_date }}" required />
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>Update Record</x-primary-button>
                        <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>