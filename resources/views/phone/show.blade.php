<!-- resources/views/home.blade.php -->
    <x-layouts.app-shop>
        <x-slot name="title">
            {{ $phone->name }} — {{ number_format($phone->price, 0, '', ' ') }} р. | СМАРТФОНЫ
        </x-slot>

        <div class="product-page">

            {{-- ЛЕВАЯ ЧАСТЬ --}}
            <div class="product-main">

                <div class="product-gallery">

                    <div class="main-image">
                        <img id="mainImage"
                             src="{{ $phone->phoneImages->first() ?
                                asset('storage/' . $phone->phoneImages->first()->path)
                                 : asset('storage/images/placeholder.png')}}">
                    </div>

                    <div class="thumbs">
                        @foreach($phone->phoneImages as $image)
                            <img
                                class="thumb"
                                src="{{ asset('storage/' . $image->path) }}"
                                data-src="{{ asset('storage/' . $image->path) }}">
                        @endforeach
                            @if($phone->phoneImages->isEmpty())
                                <img class="thumb active"
                                     src="{{ asset('storage/images/placeholder.png') }}"
                                     data-src="{{ asset('storage/images/placeholder.png') }}">
                            @endif
                    </div>

                </div>

                <div class="product-title">
                    <h2>{{ $phone->name }}</h2>
                    <div class="product-price">{{ number_format($phone->price, 0, '', ' ') }} р.</div>
                </div>

                @if(!empty($phone->description))
                    <div class="product-description">
                        {!! $phone->description !!}
                    </div>
                @endif

                <div class="product-specs">
                    <h3>Базовые характеристики</h3>

                    <ul>
                            @if($phone->phoneSpec->os) <li>OS: {!! html_entity_decode($phone->phoneSpec->os) !!}</li> @endif
                            @if($phone->phoneSpec->os_version)<li>Версия OS: {{ $phone->phoneSpec->os_version }}</li>@endif
                            @if($phone->phoneSpec->cpu_model)<li>CPU: {{ $phone->phoneSpec->cpu_model }}</li>@endif
                            @if($phone->phoneSpec->screen_size)<li>Экран: {{ $phone->phoneSpec->screen_size }}"</li>@endif
                            @if($phone->phoneSpec->sim_count)<li>Количество SIM-карт: {{ $phone->phoneSpec->sim_count }}</li>@endif
                            @if($phone->phoneSpec->sim_format)<li>Формат SIM-карт:  {{ $phone->phoneSpec->sim_format }}</li>@endif
                            @if($phone->phoneSpec->main_cam_resolution)<li>Камера: {{ $phone->phoneSpec->main_cam_resolution }} </li>@endif
                            @if($phone->phoneSpec->battery_capacity)<li>Батарея: {{ $phone->phoneSpec->battery_capacity }} mAh</li>@endif
                    </ul>
                </div>

                @php
                    $extraSpecs = json_decode($phone->phoneSpec->extra_specs, true);
                @endphp

                @if($extraSpecs)
                    <div class="specs">

                        @foreach($extraSpecs as $groupName => $items)

                            <div class="spec-group">
                                <h4>{{ $groupName }}</h4>

                                <ul>
                                    @foreach($items as $item)

                                        @foreach($item as $key => $value)
                                            <li>
                                                <span class="spec-key">{{ $key }}</span>
                                                <span class="spec-value">{{ $value }}</span>
                                            </li>
                                        @endforeach

                                    @endforeach
                                </ul>

                            </div>

                        @endforeach

                    </div>
                @endif

                <div class="reviews" id="reviews">
                    @php
                        $myReview = $phone->reviews->firstWhere('user_id', auth()->id());
                        $otherReviews = $phone->reviews->where('user_id', '!=', auth()->id())->unique('content');
                    @endphp
                    <h3>Отзывы</h3>

                    @if(session('success'))
                        <div class="flash-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @auth
                        @if($myReview)
                            <div class="review-card my-review highlight">

                                <div class="review-head">
                                    <strong>Ваш отзыв</strong>
                                    <span>{{ $myReview->rating }}★</span>

                                    <form method="POST"
                                          action="{{ route('reviews.destroy', $myReview) }}"
                                          class="review-delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit">Удалить</button>
                                    </form>
                                </div>

                                <p>{{ $myReview->content }}</p>
                                <small>{{ $myReview->published_at }}</small>
                            </div>
                        @endif
                    @endauth
                    @forelse($otherReviews as $review)

                        <div class="review-card">
                            <div class="review-head">
                                <strong>{{ $review->author }}</strong>
                                <span>{{ $review->rating }}★</span>
                            </div>

                            <p>{{ $review->content }}</p>
                            <small>{{ $review->published_at }}</small>
                        </div>

                    @empty
                        <p class="no-reviews">Пока нет отзывов</p>
                    @endforelse
                    @auth
                        @if(!$myReview)
                    <div class="reviews-form">
                        <h4>Оставить отзыв</h4>


                        <form method="POST" action="{{ route('review.store', $phone) }}">
                            @csrf
                            <div class="form-group">
                                <label>Оценка</label>
                                <select name="rating" required>
                                    <option value="">Выберите</option>
                                    <option value="5">5 ★</option>
                                    <option value="4">4 ★</option>
                                    <option value="3">3 ★</option>
                                    <option value="2">2 ★</option>
                                    <option value="1">1 ★</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Комментарий</label>
                                <textarea name="content" rows="4" required>{{ old('content') }}</textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                Отправить
                            </button>
                        </form>
                    </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- ПРАВАЯ ПАНЕЛЬ --}}
            <div class="product-sidebar">

                <div class="buy-box">
                    <div class="price-big">{{ number_format($phone->price, 0, '', ' ') }} р.</div>

                    <button class="btn-buy" data-id="{{ $phone->slug }}">
                        В корзину
                    </button>

                    <div class="meta">
                        <p>Доставка: {{ $phone->delivery_time }} дн.</p>
                        <p>Наличие: {{ $phone->availability ? 'Есть' : 'Нет' }}</p>
                    </div>

                    @if($similarPhones->count() > 1)
                        <div class="similar-block">
                        <h4>Похожие товары</h4>

                        @foreach($similarPhones as $similar)
                            <a href="{{ route('phones.show', $similar) }}" class="similar-item">

                                <img src="{{ $similar->phoneImages->first() ?
                                    asset('storage/' . $similar->phoneImages->first()->path)
                                      : asset('storage/images/placeholder.png')}}">

                                <div>
                                    <div class="name">{{ $similar->name }}</div>
                                    <div class="price">{{ number_format($similar->price, 0, '', ' ') }} р.</div>
                                </div>

                            </a>
                        @endforeach

                    </div>
                    @endif

                </div>

            </div>


        </div>




        <script>
            const mainImage = document.getElementById('mainImage');
            const thumbs = document.querySelectorAll('.thumb');

            let currentIndex = 0;

            function showImage(index) {
                if (index < 0) index = thumbs.length - 1;
                if (index >= thumbs.length) index = 0;

                currentIndex = index;

                mainImage.src = thumbs[index].dataset.src;

                thumbs.forEach(t => t.classList.remove('active'));
                thumbs[index].classList.add('active');
            }

            // клики по миниатюрам
            thumbs.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    showImage(index);
                });
            });

            // старт
            if (thumbs.length > 0) {
                showImage(0);
            }

            // =========================
            // SWIPE LOGIC
            // =========================

            let startX = 0;
            let endX = 0;

            mainImage.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            mainImage.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;

                let diff = startX - endX;

                if (Math.abs(diff) > 50) { // минимальный свайп
                    if (diff > 0) {
                        showImage(currentIndex + 1); // влево
                    } else {
                        showImage(currentIndex - 1); // вправо
                    }
                }
            });
        </script>

        <div class="mobile-buy-bar">
            <div>{{ number_format($phone->price, 0, '', ' ') }} р.</div>
            <button class="btn-buy" data-id="{{ $phone->slug }}">
                В корзину
            </button>
        </div>
        <script>
            const token = document.querySelector('meta[name="csrf-token"]').content;

            document.querySelectorAll('.btn-buy').forEach(btn => {
                btn.addEventListener('click', (e) => {

                    const id = e.currentTarget.dataset.id;

                    fetch(`/cart/add/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                        .then(res => {
                            if (res.status === 401) {
                                window.location.href = '/login';
                                return;
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (!data) return;

                            // меняем текст на всех кнопках этого типа (можно упростить)
                            document.querySelectorAll('.btn-buy[data-id="' + id + '"]')
                                .forEach(b => {
                                    b.textContent = 'Добавлено ✔';
                                    b.disabled = true;

                                    setTimeout(() => {
                                        b.textContent = 'В корзину';
                                        b.disabled = false;
                                    }, 1500);
                                });
                        });

                });
            });
        </script>
    </x-layouts.app-shop>



