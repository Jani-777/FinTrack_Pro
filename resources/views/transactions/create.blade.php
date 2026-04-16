<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Transaction</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="wallet_id" value="Select Wallet/Account" />
                        <select name="wallet_id" id="wallet_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Choose a wallet...</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_id }}">
                                    {{ $wallet->wallet_name }} (Balance: ₱{{ number_format($wallet->current_balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" value="Category" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">
                                    {{ $category->category_name }} ({{ $category->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="amount" value="Amount (PHP)" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" class="block mt-1 w-full" placeholder="0.00" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="transaction_date" value="Transaction Date" />
                        <x-text-input id="transaction_date" name="transaction_date" type="date" class="block mt-1 w-full" value="{{ date('Y-m-d') }}" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" value="Description / Notes (Optional)" />
                        <x-text-input id="description" name="description" type="text" class="block mt-1 w-full" placeholder="e.g. Lunch with friends" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Save Transaction
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>