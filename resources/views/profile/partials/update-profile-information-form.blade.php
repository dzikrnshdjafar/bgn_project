<x-form-card :title="'Update Profile'">
    <section>
        <header>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="btn btn-link p-0">{{ __('Click here to re-send the verification email.') }}</button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </section>
</x-form-card>