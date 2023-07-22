<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mendorecipe</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<div class="auth-container">
    
    <div class="auth-card">
        <p class="auth-title">mendorecipe</p>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 fs-1" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 fs-1" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('メールアドレス')" class="fs-1"/>

                <x-input id="email" class="block mt-1 w-full fs-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" class="fs-1"/>

                <x-input id="password" class="block mt-1 w-full fs-1"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 inline-block mtb-1 mr-1 fs-1" href="{{ route('password.request') }}">
                        {{ __('パスワードをお忘れですか？') }}
                    </a>
                @endif
                <a class="underline text-sm text-gray-600 hover:text-gray-900 inline-block mtb-1 fs-1" href="{{ route('register') }}">
                    {{ __('新規登録はこちら') }}
                </a>

                <x-button class="ml-3 fs-1">
                    {{ __('ログイン') }}
                </x-button>
            </div>
        </form>
    </div>
</div>

</html>