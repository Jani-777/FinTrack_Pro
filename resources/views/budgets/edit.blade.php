<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Budget Limit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('budgets.update', $budget->budget_id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <x-input-label value="Category" />
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}" {{ $budget->category_id == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Limit (PHP)" />
                        <x-text-input name="amount_limit" type="number" step="0.01" class="w-full mt-1" value="{{ $budget->amount_limit }}" required />
                    </div>

                    <div>
                        <x-input-label value="Budget Period" />
                        <x-text-input name="month_year" type="text" class="w-full mt-1 bg-gray-100" value="{{ $budget->month_year }}" readonly />
                        <p class="text-xs text-gray-500 mt-1 italic">Note: To change the period, please create a new budget.</p>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>Update Budget</x-primary-button>
                        <a href="{{ route('budgets.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>