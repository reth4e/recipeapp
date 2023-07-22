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

        <div class="mb-1 text-sm text-gray-600 fs-1">
        {{ __('パスワードをお忘れであれば、メールアドレスを入力し「パスワードのリセット」を押してください。') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('メールアドレス')" class="fs-1"/>

                <x-input id="email" class="block mt-1 w-full fs-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4 ">
                <x-button class="fs-1">
                    {{ __('パスワードのリセット') }}
                </x-button>
            </div>
        </form>
    </div>
</div>

</html>