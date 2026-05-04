<x-app-layout>
    <x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight">Edit Budget Details</h2></x-slot>

    <div class="py-12 px-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white shadow-sm rounded-3xl p-8 border border-slate-100">
                <form action="{{ route('budgets.update', $budget->budget_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <x-input-label value="Category" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <select name="category_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 text-sm">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}" {{ old('category_id', $budget->category_id) == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="Budget Description" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <x-text-input name="description" type="text" class="w-full rounded-xl" value="{{ old('description', $budget->description) }}" placeholder="e.g. Monthly Grocery Bill" />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="Limit (PHP)" class="text-[10px] font-black uppercase tracking-widest mb-2 ml-1" />
                        <x-text-input name="amount_limit" type="number" step="0.01" min="0.01" class="w-full rounded-xl mt-1" value="{{ old('amount_limit', $budget->amount_limit) }}" required />
                        <x-input-error :messages="$errors->get('amount_limit')" class="mt-1" />
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <x-input-label value="Budget Period" class="text-[10px] font-black uppercase tracking-widest mb-1" />
                        <p class="text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($budget->month_year)->format('F Y') }}</p>
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <x-primary-button class="justify-center py-3 rounded-xl">Update Budget</x-primary-button>
                        <a href="{{ route('budgets.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 text-center hover:text-slate-600 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>