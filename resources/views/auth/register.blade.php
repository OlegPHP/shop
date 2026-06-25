<x-layouts.app-shop>
    <x-slot name="title">
        Регистрация | СМАРТФОНЫ
    </x-slot>
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div>
            <label>Имя</label>
            <input type="text" name="name" value="{{old('name')}}" autocomplete="name" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- Email Address -->
        <div >
            <label>Email</label>
            <input type="email" name="email" value="{{old('email')}}" autocomplete="email" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div>
            <label>Пароль</label>
            <input type="password" name="password" autocomplete="new-password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label>Подтвердить пароль</label>
            <input type="password" name="password_confirmation" autocomplete="new-password" required>
            @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="mt-4">
            <label for="privacy" class="inline-flex items-center">
                <input id="privacy" type="checkbox" name="privacy" required class="rounded border-gray-300">
                <span class="ms-2 text-sm text-gray-600">
            Я согласен(а) на обработку email и персональных данных
        </span>
            </label>
        </div>

        <button type="submit">Регистрация</button>

    </form>
</x-layouts.app-shop>
