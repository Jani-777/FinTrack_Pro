<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Wallets & Accounts</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <form action="{{ route('wallets.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                @csrf
                <h3 class="font-bold text-slate-800 mb-6">Add New Fund Source</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    <div class="flex flex-col">
                        <x-input-label for="wallet_name" value="Account Name (e.g. Cash, Bank)" class="mb-1" />
                        <x-text-input id="wallet_name" name="wallet_name" type="text" class="w-full" placeholder="Cash, BPI Account, GCash ..." value="{{ old('wallet_name') }}" required />
                        <x-input-error :messages="$errors->get('wallet_name')" class="mt-1" />
                    </div>

                    <div class="flex flex-col">
                        <x-input-label for="current_balance" value="Initial Balance (PHP)" class="mb-1" />
                        <x-text-input id="current_balance" name="current_balance" type="number" step="0.01" min="0" class="w-full" placeholder="0.00" value="{{ old('current_balance') }}" required />
                        <x-input-error :messages="$errors->get('current_balance')" class="mt-1 text-xs" />
                    </div>

                    <div class="pt-7"> <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 uppercase text-xs tracking-widest">
                            {{ __('Create Wallet') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{ openModal: null }">
            @foreach($wallets as $wallet)
                <div @click="openModal = {{ $wallet->wallet_id }}" 
                    class="bg-white p-6 rounded-xl shadow-md border-t-4 border-indigo-500 flex flex-col justify-between cursor-pointer hover:shadow-lg transition group">
                    
                    <div>
                        <div class="flex justify-between items-start">
                            <h4 class="text-gray-500 text-sm uppercase font-bold tracking-wider">{{ $wallet->wallet_name }}</h4>
                            <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded font-bold opacity-0 group-hover:opacity-100 transition">VIEW HISTORY</span>
                        </div>
                        <p class="text-3xl font-black mt-2 text-slate-800">
                            ₱{{ number_format($wallet->current_balance, 2) }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end items-center gap-4" @click.stop>
                        <a href="{{ route('wallets.edit', $wallet->wallet_id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('wallets.destroy', $wallet->wallet_id) }}" method="POST" onsubmit="return confirm('Delete wallet?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div x-show="openModal === {{ $wallet->wallet_id }}" 
                    class="fixed inset-0 z-50 overflow-y-auto" 
                    style="display: none;">
                    
                    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="openModal = null"></div>

                    <div class="relative min-h-screen flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 overflow-hidden">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-slate-800">{{ $wallet->wallet_name }} - Recent History</h3>
                                <button @click="openModal = null" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="border-b border-gray-100">
                                        <tr>
                                            <th class="py-3 text-xs font-bold text-gray-400 uppercase">Date</th>
                                            <th class="py-3 text-xs font-bold text-gray-400 uppercase">Category</th>
                                            <th class="py-3 text-right text-xs font-bold text-gray-400 uppercase">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($wallet->transactions as $transaction)
                                            <tr>
                                                <td class="py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                                                <td class="py-4">
                                                    <span class="px-2 py-1 bg-gray-100 rounded text-xs text-gray-700">
                                                        {{ $transaction->category->category_name }}
                                                    </span>
                                                </td>
                                                <td class="py-4 text-right font-bold {{ $transaction->category->type == 'Income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ $transaction->category->type == 'Income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="py-8 text-center text-gray-400">No transactions found for this wallet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-8 text-center">
                                <button @click="openModal = null" class="bg-slate-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-slate-700 transition">Close History</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>