<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picoo</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<div class="auth-container">
    <div class="auth-card">

        <p class="auth-title">mendorecipe</p>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 fs-1" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" class="fs-1" :value="__('名前')" />

                <x-input id="name" class="block mt-1 w-full fs-1" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" class="fs-1"/>

                <x-input id="email" class="block mt-1 w-full fs-1" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" class="fs-1"/>

                <x-input id="password" class="block mt-1 w-full fs-1"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('パスワード確認')" class="fs-1"/>

                <x-input id="password_confirmation" class="block mt-1 w-full fs-1"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 inline-block mtb-1 fs-1" href="{{ route('login') }}">
                    {{ __('登録がお済の方はこちら') }}
                </a>

                <x-button class="ml-4 fs-1">
                    {{ __('登録') }}
                </x-button>
            </div>
        </form>
    </div>
</div>

</html>