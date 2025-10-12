<x-form-card :title="'Update Password'">
    <section>
        <header>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="update_password_current_password">{{ __('Current Password') }}</label>
                <input type="password" name="current_password" class="form-control" id="update_password_current_password" autocomplete="current-password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="update_password_password">{{ __('New Password') }}</label>
                <input type="password" name="password" class="form-control" id="update_password_password" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" class="form-control" id="update_password_password_confirmation" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                @if (session('status') === 'password-updated')
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </section>
</x-form-card>