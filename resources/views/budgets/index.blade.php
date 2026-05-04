<x-app-layout>
    <x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight">Monthly Budgets</h2></x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-10">
            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div>
                        <x-input-label value="Category" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <select name="category_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                            @foreach($categories as $cat) 
                                <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option> 
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Budget Description" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <x-text-input name="description" placeholder="e.g. For Party, Daily Meals" type="text" class="w-full rounded-xl" value="{{ old('description') }}" />
                    </div>

                    <div>
                        <x-input-label value="Limit (PHP)" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <x-text-input name="amount_limit" placeholder="0.00" type="number" step="0.01" min="0.01" class="w-full rounded-xl" value="{{ old('amount_limit') }}" required />
                    </div>

                    <x-primary-button class="justify-center py-3 rounded-xl shadow-lg shadow-indigo-100">Set Budget</x-primary-button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($budgets as $budget)
                @php
                    $percentage = $budget->amount_limit > 0 ? ($budget->total_spent / $budget->amount_limit) * 100 : 0;
                    $barColor = $percentage >= 100 ? 'bg-rose-600' : ($percentage >= 80 ? 'bg-orange-500' : 'bg-indigo-600');
                @endphp

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $budget->category->category_name }}</h4>
                            <p class="text-[10px] font-bold text-slate-300 uppercase">{{ \Carbon\Carbon::parse($budget->month_year)->format('M Y') }}</p>
                        </div>
                        
                        <h3 class="text-lg font-bold text-slate-800 mb-4 truncate">{{ $budget->description ?? 'No Description' }}</h3>

                        <div class="flex justify-between items-end mb-4">
                            <span class="text-xl font-black text-slate-800">₱{{ number_format($budget->total_spent, 2) }}</span>
                            <span class="text-slate-400 text-xs font-bold">/ ₱{{ number_format($budget->amount_limit, 2) }}</span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden mb-3">
                            <div class="{{ $barColor }} h-full transition-all duration-500" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>

                        <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-tight">
                            <span class="{{ $percentage >= 100 ? 'text-rose-600' : 'text-slate-500' }}">{{ number_format($percentage, 1) }}% Used</span>
                            @if($budget->amount_limit - $budget->total_spent > 0)
                                <span class="text-emerald-600">₱{{ number_format($budget->amount_limit - $budget->total_spent, 2) }} Remaining</span>
                            @else
                                <span class="text-rose-600 font-bold">Over Budget!</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-50 flex justify-end items-center gap-2">
                        <a href="{{ route('budgets.edit', $budget->budget_id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </a>
                        <form action="{{ route('budgets.destroy', $budget->budget_id) }}" method="POST" onsubmit="return confirm('Delete budget?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>