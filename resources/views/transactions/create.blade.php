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
                                <option value="{{ $wallet->wallet_id }}" {{ old('wallet_id') == $wallet->wallet_id ? 'selected' : '' }}>
                                    {{ $wallet->wallet_name }} (Balance: ₱{{ number_format($wallet->current_balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('wallet_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" value="Category" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }} ({{ $category->type }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="amount" value="Amount (PHP)" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" min="0.01" class="block mt-1 w-full" placeholder="0.00" value="{{ old('amount') }}" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="transaction_date" value="Transaction Date" />
                        <x-text-input id="transaction_date" name="transaction_date" type="date" class="block mt-1 w-full" value="{{ old('transaction_date', date('Y-m-d')) }}" required />
                        <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" value="Description / Notes (Optional)" />
                        <x-text-input id="description" name="description" type="text" class="block mt-1 w-full" placeholder="e.g. Lunch with friends" value="{{ old('description') }}" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>
                            {{ __('Save Transaction') }}
                        </x-primary-button>

                        <a href="{{ route('transactions.index') }}" 
                        class="text-sm text-gray-600 hover:text-gray-900 font-medium transition duration-150 ease-in-out">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const walletSelect = document.getElementById('wallet_id');
            const categorySelect = document.getElementById('category_id');

            function checkBalance() {
                const selectedOption = walletSelect.options[walletSelect.selectedIndex];
                const categoryText = categorySelect.options[categorySelect.selectedIndex]?.text || '';
                
                // Extract balance from the option text using regex
                const balanceMatch = selectedOption.text.match(/₱([\d,.]+)/);
                if (!balanceMatch || !categoryText.includes('Expense')) return;

                const currentBalance = parseFloat(balanceMatch[1].replace(/,/g, ''));
                const inputAmount = parseFloat(amountInput.value);

                if (inputAmount > currentBalance) {
                    amountInput.classList.add('border-rose-500', 'ring-rose-500');
                    // You could also show a small warning div here
                } else {
                    amountInput.classList.remove('border-rose-500', 'ring-rose-500');
                }
            }

            amountInput.addEventListener('input', checkBalance);
            walletSelect.addEventListener('change', checkBalance);
            categorySelect.addEventListener('change', checkBalance);
        });
    </script>
</x-app-layout>