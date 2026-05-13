<x-layouts.app-shop>
    <x-slot name="title">
        Оформление заказа | СМАРТФОНЫ
    </x-slot>

    <div class="checkout-page">

        <h2>Оформление заказа</h2>

        <div class="checkout-grid">

            {{-- ЛЕВАЯ ЧАСТЬ — ЗАКАЗ --}}
            <div class="checkout-summary">

                <h3>Ваш заказ</h3>

                @foreach($items as $item)
                    <div class="checkout-item">
                        <span>{{ $item->phone->name }}</span>
                        <span>{{ $item->quantity }} шт. на сумму {{ number_format($item->price * $item->quantity, 0, '', ' ') }} р. </span>
                    </div>
                @endforeach

                <div class="checkout-total">
                    Итого: <strong>{{ number_format($total, 0, '', ' ') }} р.</strong>
                </div>

            </div>

            {{-- ПРАВАЯ ЧАСТЬ — ФОРМА --}}
            <div class="checkout-form">

                <h3>Ваши данные</h3>

                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <label>Имя</label>
                    <input type="text" name="name" required>

                    <label>Телефон</label>
                    <input type="text" name="phone" required>

                    <button type="submit" class="btn-primary">
                        Подтвердить заказ
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-layouts.app-shop>
