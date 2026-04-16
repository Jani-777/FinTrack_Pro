<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">System Categories (Admin)</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 text-emerald-700 bg-emerald-50 border border-emerald-200 p-4 rounded-lg font-medium">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-lg sm:rounded-xl p-6 mb-8 border border-slate-100">
            <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border mb-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    
                    <div>
                        <x-input-label for="category_name" value="Category Name" />
                        <x-text-input id="category_name" name="category_name" type="text" class="block mt-1 w-full" placeholder="e.g. Salary, Food, Rent" required />
                    </div>

                    <div>
                        <x-input-label for="type" value="Transaction Type" />
                        <select name="type" id="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Income">Income</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3">
                            Add Category
                        </x-primary-button>
                    </div>
                    
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($categories as $category)
                <tr>
                    <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <td class="px-6 py-4">
                            <input type="text" name="category_name" value="{{ $category->category_name }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </td>

                        <td class="px-6 py-4">
                            <select name="type" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="Income" {{ $category->type == 'Income' ? 'selected' : '' }}>Income</option>
                                <option value="Expense" {{ $category->type == 'Expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                    Update
                                </button>
                    </form>

                                <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" 
                                    onsubmit="return confirm('Delete this category? Users using this will be affected.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-bold transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
</x-app-layout>