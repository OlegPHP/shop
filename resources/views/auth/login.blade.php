<x-layouts.app-shop>
    <x-slot name="title">
        Вход | СМАРТФОНЫ
    </x-slot>
    <!-- Session Status -->


    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div>
            <label>Email</label>
            <input  type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div>
            <label>Пароль</label>
            <input type="password" name="password" autocomplete="current-password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember">
            <label>
                <input type="checkbox"   name="remember">
                Запомнить меня
            </label>
        </div>



        <button type="submit">Войти</button>

    </form>
</x-layouts.app-shop>
