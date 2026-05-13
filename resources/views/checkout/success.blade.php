<x-layouts.app-shop>
    <x-slot name="title">
        Завершение заказа | СМАРТФОНЫ
    </x-slot>

    <div class="checkout-success">

        <div class="success-card">

            <div class="success-icon">✔</div>

            <h2>Заказ оформлен</h2>

            @if($name)
                <p class="success-name">
                    Спасибо, {{ $name }}!
                </p>
            @endif

            <p class="success-text">
                Но есть нюанс 😄<br><br>
                Сайт учебный — заказ никуда не уйдёт.
            </p>

            <div class="success-actions">

                <a href="https://www.21vek.by/" target="_blank" class="btn-primary">
                    Перейти к реальному магазину
                </a>

                <a href="{{ route('phones.index') }}" class="btn-secondary">
                    Вернуться в каталог
                </a>

            </div>

        </div>

    </div>

</x-layouts.app-shop>
