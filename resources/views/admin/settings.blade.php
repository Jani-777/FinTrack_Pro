<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">System Settings</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Global Configuration</h3>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Setting Key</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($settings as $setting)
                            <tr>
                                <form action="{{ route('admin.settings.update', $setting->setting_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $setting->setting_name }}</td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="setting_value" value="{{ $setting->setting_value }}" class="border-gray-300 rounded-md w-full">
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-primary-button>Update</x-primary-button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>