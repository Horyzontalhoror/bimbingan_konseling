<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div
    class="w-full max-w-sm md:max-w-md bg-white dark:bg-zinc-800 p-8 md:p-10 rounded-xl shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-[1.01]">

    <!-- Logo and Title -->
    <div class="text-center mb-8">
        <a href="/" class="block">
            <img src="{{ asset('favicon/favicon.svg') }}" alt="Logo SMPN 1 Solor Barat"
                class="w-12 md:w-12 mx-auto mb-4 transition-transform duration-300 hover:scale-105">
        </a>
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-2">Login Admin/Guru</h1>
        <p class="text-gray-600 dark:text-gray-400 text-md">Akses portal manajemen sekolah</p>
    </div>

    <form wire:submit="login">
        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')"
            class="bg-blue-50 dark:bg-blue-800 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-100 px-4 py-3 rounded-lg relative animate-fade-in" />

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" value="{{ __('Email') }}"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
            <x-text-input wire:model="form.email" id="email"
                class="block mt-1 w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-gray-200 rounded-lg p-3 text-base shadow-sm focus:border-primary focus:ring-primary transition-all duration-200 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                type="email" name="email" required autofocus autocomplete="username"
                placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" value="{{ __('Password') }}"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
            <x-text-input wire:model="form.password" id="password"
                class="block mt-1 w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-gray-200 rounded-lg p-3 text-base shadow-sm focus:border-primary focus:ring-primary transition-all duration-200 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                type="password" name="password" required autocomplete="current-password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:bg-zinc-700 dark:border-zinc-600 transition-colors duration-200 checked:bg-primary checked:border-transparent"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:underline dark:text-primary-lighter transition-colors duration-200"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button
                class="w-full bg-primary hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-primary/50 dark:focus:ring-primary/60">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Register Link (Moved and Styled as Secondary Action) -->
        <div class="mt-8 text-center text-gray-600 dark:text-gray-400 text-sm">
            Belum punya akun?
            @if (Route::has('register'))
                <a href="{{ route('register') }}" wire:navigate
                    class="text-primary hover:underline font-medium transition-colors duration-200">
                    {{ __('Register here') }}
                </a>
            @endif
        </div>
    </form>
</div>
