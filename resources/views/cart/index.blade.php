<x-layouts.app-shop>
    <x-slot name="title">
        Корзина покупок | СМАРТФОНЫ
    </x-slot>

    <div class="cart-page">

        <h2 class="cart-title">Корзина</h2>

        @forelse($items as $item)

            <div class="cart-item">
                <img src="{{$item->phone->phoneImages->first() ?
                asset('storage/' . $item->phone->phoneImages->first()->path)
                :  asset('storage/images/placeholder.png')}}">
                <div class="cart-info">
                    <h3>{{$item->phone->name}}</h3>
                    <p>Цена: {{ number_format($item->price, 0, '', ' ') }} р.</p>

                    <div class="cart-row-bottom">
                        <div class="cart-quantity" data-id="{{ $item->id }}">
                            <button class="decrease">-</button>
                            <span class="qty">{{ $item->quantity }}</span>
                            <button class="increase">+</button>
                        </div>

                        <button class="remove-item" data-id="{{ $item->id }}">
                            Удалить
                        </button>

                        <p class="item-total">
                            {{ number_format($item->price * $item->quantity, 0, '', ' ') }} р.
                        </p>
                    </div>
                </div>
    </div>


        @empty
            <h4>Корзина пуста</h4>
        @endforelse

        <div class="cart-summary">

            <div class="cart-total-block">
                <span class="cart-summary-label">Итого:</span>
                <span class="cart-summary-price" id="cart-total">
                {{ $items->count() ? number_format($items->sum(fn($i) => $i->price * $i->quantity), 0, '', ' ') . ' р.' : '0 р.' }}
                </span>
            </div>
            @if($items->count())
                <a href="{{ route('checkout.index') }}" class="checkout-button">
                    Оформить заказ
                </a>
            @endif
        </div>

    </div>
    <script>
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const formatPrice = (value) => {
            return new Intl.NumberFormat('ru-RU').format(Math.round(value)) + ' р.';
        };

        const updateCartTotal = (total) => {
            const el = document.getElementById('cart-total');
            if (el) {
                el.textContent = total;
            }
        };

        document.querySelectorAll('.cart-quantity').forEach(block => {

            const id = block.dataset.id;

            const qtyEl = block.querySelector('.qty');
            const totalEl = block.closest('.cart-item').querySelector('.item-total');

            // ➕ УВЕЛИЧЕНИЕ
            block.querySelector('.increase').addEventListener('click', () => {
                fetch(`/cart/${id}/increase`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        qtyEl.textContent = data.quantity;
                        totalEl.textContent = formatPrice(data.item_total);
                        updateCartTotal(formatPrice(data.cart_total));
                    });
            });

            // ➖ УМЕНЬШЕНИЕ
            block.querySelector('.decrease').addEventListener('click', () => {
                fetch(`/cart/${id}/decrease`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {

                        // если товар удалился
                        if (data.deleted) {
                            block.closest('.cart-item').remove();
                            updateCartTotal(data.cart_total);
                            return;
                        }

                        qtyEl.textContent = data.quantity;
                        totalEl.textContent = formatPrice(data.item_total);
                        updateCartTotal(formatPrice(data.cart_total));
                    });
            });

        });
        document.querySelectorAll('.remove-item').forEach(btn => {

            btn.addEventListener('click', () => {

                const id = btn.dataset.id;

                fetch(`/cart/remove/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {

                        btn.closest('.cart-item').remove();
                        updateCartTotal(formatPrice(data.cart_total));

                    });

            });

        });
    </script>
</x-layouts.app-shop>
