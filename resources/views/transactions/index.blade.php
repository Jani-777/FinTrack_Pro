<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">My Transactions</h2>
            <a href="{{ route('transactions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                + Add Record
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
                <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                    <div class="md:col-span-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Wallet Source</label>
                        <select name="wallet_id" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium">
                            <option value="">All Wallets</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_id }}" {{ request('wallet_id') == $wallet->wallet_id ? 'selected' : '' }}>
                                    {{ $wallet->wallet_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Category</label>
                        <select name="category_id" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Date Range</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full rounded-xl border-slate-200 shadow-sm text-sm p-2 font-medium">
                            <span class="text-slate-300 font-bold">-</span>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full rounded-xl border-slate-200 shadow-sm text-sm p-2 font-medium">
                        </div>
                    </div>

                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 text-white py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-lg shadow-slate-100">
                            Filter
                        </button>
                        <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                
                <div class="hidden md:block">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Wallet</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 py-5 text-sm text-slate-600 font-medium whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-800">{{ $transaction->wallet->wallet_name }}</td>
                                    <td class="px-6 py-5">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                            {{ $transaction->category->category_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-400 italic">
                                        {{ Str::limit($transaction->description ?? '-', 25) }}
                                    </td>
                                    <td class="px-6 py-5 text-right font-black text-lg {{ strtolower($transaction->category->type) == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ strtolower($transaction->category->type) == 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('transactions.edit', $transaction->transaction_id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm group">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST" onsubmit="return confirm('Delete record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-16 text-center text-slate-400 italic font-medium">No transactions found matching your filters.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-slate-50">
                    @forelse($transactions as $transaction)
                        <div class="p-5 hover:bg-slate-50 transition active:bg-slate-100">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-800">{{ $transaction->wallet->wallet_name }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-lg {{ strtolower($transaction->category->type) == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ strtolower($transaction->category->type) == 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md text-[9px] font-black uppercase">
                                        {{ $transaction->category->category_name }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($transaction->description)
                                <p class="text-xs text-slate-400 italic mb-4">{{ $transaction->description }}</p>
                            @endif

                            <div class="flex gap-2 pt-3 border-t border-slate-50">
                                <a href="{{ route('transactions.edit', $transaction->transaction_id) }}" class="flex-1 flex justify-center items-center gap-2 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    Edit
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-2 bg-rose-50 text-rose-500 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic font-medium">No transactions found matching your filters.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>