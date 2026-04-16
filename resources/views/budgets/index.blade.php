<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Monthly Budgets</h2></x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <form action="{{ route('budgets.store') }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <x-input-label value="Category" />
                    <select name="category_id" class="w-full border-gray-300 rounded-md">
                        @foreach($categories as $cat) <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option> @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <x-input-label value="Limit (PHP)" />
                    <x-text-input name="amount_limit" placeholder="Enter budget limit" type="number" class="w-full" required />
                </div>
                <x-primary-button>Set Budget</x-primary-button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($budgets as $budget)
                <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500 flex justify-between items-center">
                    <div>
                        <div class="font-bold">
                            <span>{{ $budget->category->category_name }}</span>
                            <span class="ml-4 text-indigo-600">₱{{ number_format($budget->amount_limit, 2) }}</span>
                        </div>
                        <p class="text-xs text-gray-500">For {{ \Carbon\Carbon::parse($budget->month_year)->format('F Y') }}</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('budgets.edit', $budget->budget_id) }}" class="text-gray-400 hover:text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>

                        <form action="{{ route('budgets.destroy', $budget->budget_id) }}" method="POST" onsubmit="return confirm('Remove budget?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-rose-600 pt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>