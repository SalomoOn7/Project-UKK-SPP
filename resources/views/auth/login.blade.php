<x-guest-layout>
    <!-- Selamat Datang -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-indigo-600">Selamat Datang</h1>
        <p class="mt-2 text-gray-600">Di Aplikasi SPP SMK TI Pembangunan Cimahi</p>
        <p class="mt-1 text-sm text-gray-400">Silakan masuk dengan akun Anda untuk mengelola pembayaran SPP</p>
    </div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<!-- Form Login -->
<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Username -->
    <div>
        <x-input-label for="username" value="Username" />
        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" value="Password" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>


    <!-- Button Login -->
    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ms-3">
            Log in
        </x-primary-button>
    </div>
</form>
</x-guest-layout>
