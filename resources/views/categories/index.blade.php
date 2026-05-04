<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">System Categories</h2>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
       
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-10">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Create New Category</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                    <div class="md:col-span-5">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Category Name</label>
                        <input type="text" name="category_name" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium p-3" placeholder="e.g. Salary, Food, Rent" required />
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Transaction Type</label>
                        <select name="type" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium p-3 pr-10 appearance-none bg-no-repeat bg-[right_0.75rem_center]" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Income">Income</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Add Category
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category Name</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                        <th class="px-8 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($categories as $category)
                        @php
                            $isEditable = Auth::user()->isAdmin() || $category->user_id == Auth::id();
                        @endphp
                        <tr class="hover:bg-slate-50/30 transition">
                            <td class="px-8 py-5">
                                <form id="update-form-{{ $category->category_id }}" action="{{ route('categories.update', $category->category_id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <input type="text" name="category_name" value="{{ $category->category_name }}" 
                                        {{ !$isEditable ? 'disabled' : '' }}
                                        class="w-full max-w-xs border-transparent rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-sm font-bold text-slate-800 {{ !$isEditable ? 'bg-transparent' : 'bg-slate-50/50 p-2' }}">
                            </td>

                            <td class="px-8 py-5">
                                @if($isEditable)
                                    <select name="type" class="rounded-lg border-transparent bg-slate-50/50 focus:border-indigo-500 focus:ring-indigo-500 text-[10px] font-black uppercase tracking-tight py-1.5 pl-3 pr-8">
                                        <option value="Income" {{ $category->type == 'Income' ? 'selected' : '' }}>Income</option>
                                        <option value="Expense" {{ $category->type == 'Expense' ? 'selected' : '' }}>Expense</option>
                                    </select>
                                @else
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                        {{ $category->type }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex justify-center items-center gap-2">
                                    @if($isEditable)
                                        <button type="submit" form="update-form-{{ $category->category_id }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                </form> 

                                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" onsubmit="return confirm('Delete category?');" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        </form>
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-300 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                                            Locked
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>