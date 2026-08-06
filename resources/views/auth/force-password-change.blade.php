<x-guest-layout>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Set a new password</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
            Your account was just created. Choose a new password to continue.
        </p>
    </div>

    <form method="POST" action="{{ route('password.force.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="password" :value="__('New Password')" />

            <div class="relative mt-1">
                <button type="button" class="js-toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                    tabindex="-1" data-target="password">
                    <svg class="js-eye-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51
                       7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431
                       0 .638C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required
                    autocomplete="new-password" placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />

            <div class="relative mt-1">
                <button type="button" class="js-toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                    tabindex="-1" data-target="password_confirmation">
                    <svg class="js-eye-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51
                       7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431
                       0 .638C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                <x-text-input id="password_confirmation" class="block w-full pr-12" type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
            class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-orange-500 hover:bg-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 transition">
            {{ __('Set Password & Continue') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center mt-4">
        @csrf
        <button type="submit" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 underline">
            Log out instead
        </button>
    </form>
</x-guest-layout>
