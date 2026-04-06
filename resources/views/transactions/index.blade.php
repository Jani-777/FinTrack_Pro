<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Financial Records') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition">
                + New Record
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg border border-slate-100 sm:rounded-xl">
                
                @if(session('success'))
                    <div class="m-4 text-emerald-700 bg-emerald-50 border border-emerald-200 p-4 rounded-lg font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-sm uppercase tracking-wider">
                                @if(auth()->user()->isAdmin())
                                    <th class="py-4 px-6 font-semibold">User</th>
                                @endif
                                <th class="py-4 px-6 font-semibold">Date</th>
                                <th class="py-4 px-6 font-semibold">Title</th>
                                <th class="py-4 px-6 font-semibold">Type</th>
                                <th class="py-4 px-6 font-semibold text-right">Amount</th>
                                <th class="py-4 px-6 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                @if(auth()->user()->isAdmin())
                                    <td class="py-4 px-6 text-slate-700">{{ $transaction->user->name }}</td>
                                @endif
                                <td class="py-4 px-6 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6 text-slate-800 font-medium">{{ $transaction->title }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wide 
                                        {{ strtolower($transaction->type) === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $transaction->type }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-bold {{ strtolower($transaction->type) === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ strtolower($transaction->type) === 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="py-4 px-6 flex justify-center gap-4 text-sm font-medium">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="text-indigo-500 hover:text-indigo-700 transition">Edit</a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Delete this record forever?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($transactions->isEmpty())
                    <div class="p-8 text-center text-slate-500">
                        No transactions found. Start tracking your finances today!
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>