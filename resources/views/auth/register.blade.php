<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Welcome to FinTrack Pro</h2>
        <p class="text-sm text-slate-500 mt-2">Create your account to start tracking your money today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-slate-200">
            <x-input-label for="admin_code" value="System Owner Passcode (Optional)" class="text-indigo-600 font-bold" />
            <p class="text-xs text-slate-500 mb-2">Leave blank if you are registering as a normal client.</p>
            <x-text-input id="admin_code" class="block mt-1 w-full border-indigo-100 focus:border-indigo-500 focus:ring-indigo-500 bg-indigo-50/30" type="password" name="admin_code" autocomplete="off" />
        </div>

        <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
            <a class="text-sm text-gray-600 hover:text-indigo-600 font-medium transition" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>