<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">System Categories (Admin)</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 text-emerald-700 bg-emerald-50 border border-emerald-200 p-4 rounded-lg font-medium">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-lg sm:rounded-xl p-6 mb-8 border border-slate-100">
            <form action="{{ route('categories.store') }}" method="POST" class="flex items-end gap-4">
                @csrf
                <div class="flex-grow">
                    <x-input-label for="name" value="New Category Name (e.g. Investment, Refund)" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                </div>
                <x-primary-button>Add Category</x-primary-button>
            </form>
        </div>

        <div class="bg-white shadow-lg sm:rounded-xl overflow-hidden border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-sm uppercase tracking-wider">
                        <th class="py-4 px-6 font-semibold">Category Name</th>
                        <th class="py-4 px-6 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-slate-800 font-medium">{{ $category->name }}</td>
                        <td class="py-4 px-6 text-right">
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 transition font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>