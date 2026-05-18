<!-- resources/views/home.blade.php -->
<x-layouts.app-shop>

    <div class="page-layout">

        <div class="main-content">
            <div class="brands-wrapper">
            <button class="brands-toggle" type="button">
                Бренды
            </button>
    <div class="brands-menu">
        <a href="{{ route('phones.index') }}" class="{{ !$brand ? 'active' : '' }}">Все</a>
        @foreach($brands as $b)
            <a href="{{ route('brands.phones', $b) }}" class="{{ $brand && $brand->id === $b->id ? 'active' : '' }}">
                {{ $b->name }}
            </a>
        @endforeach
    </div>
            </div>
    <div class="phones-grid">
        @foreach($phones as $phone)
            @php $image = $phone->phoneImages->first(); @endphp
                <div class="phones-card">
                <a href="{{ route('phones.show', $phone) }}" >
                    <img src="{{ $image ? asset('storage/' . $image->path) : asset('storage/images/placeholder.png') }}"
                         alt="{{ $phone->name }}">

                <div class="phones-info">
                    <h4>{{ number_format($phone->price, 0, '', ' ') }} р.</h4>
                    <h3>{{ $phone->name }}</h3>


                </div>
            </a>
                <div class="phones-info">
                    <button class="add-to-cart" data-id="{{ $phone->slug }}">
                        В корзину
                    </button>
                </div>
                </div>
        @endforeach
    </div>

    <div class="pagination-wrapper">
        {{ $phones->links() }}
    </div>
        </div>
        {{-- СПРАВА НОВАЯ ЗОНА --}}
        <aside class="right-panel">
            <h3>Подбор устройства</h3>

            <div class="experiment-box">

                <form method="GET">
                    <label>Тип устройства</label>
                    <select name="type" onchange="this.form.submit()">
                        <option value="">Все</option>
                        <option value="smartphone" {{ request('type') == 'smartphone' ? 'selected' : '' }}>
                            Смартфоны
                        </option>
                        <option value="feature" {{ request('type') == 'feature' ? 'selected' : '' }}>
                            Мобильные телефоны
                        </option>
                    </select>
                </form>

                <form action="" method="GET">

                        <input type="hidden" name="type" value="{{ request('type') }}">


                        @if(request('type') === 'smartphone' or !request('type'))
                        <div class="filter">

                        <label>Цена от, р.</label>
                        <input type="number" name="price_from" value="{{ request('price_from') }}">

                        <label>Цена до, р.</label>
                        <input type="number" name="price_to" value="{{ request('price_to') }}">
                    </div>



                         <div class="filter">
                            <label>Операционная система</label>
                            <select name="os">
                                @foreach([null,'Android','Apple iOS'] as $os)
                                    <option value="{{ $os }}" {{ request('os') == $os ? 'selected' : '' }}>
                                        {{ $os ?? 'Не важно' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter">
                        <label>Оперативная память от, Гб</label>
                        <select name="ram_from">
                            @foreach([null,2,4,6,8,10,12] as $ram)
                                <option value="{{ $ram }}" {{ request('ram_from') == $ram ? 'selected' : '' }}>
                                    {{ $ram ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>


                        <label>Оперативная память до, Гб</label>
                        <select name="ram_to">
                            @foreach([null,2,4,6,8,10,12] as $ram)
                                <option value="{{ $ram }}" {{ request('ram_to') == $ram ? 'selected' : '' }}>
                                    {{ $ram ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                        <div class="filter">
                        <label>Основная память от, Гб</label>
                        <select name="storage_from">
                            @foreach([null,32,64,128,256,512] as $storage)
                                <option value="{{ $storage }}" {{ request('storage_from') == $storage ? 'selected' : '' }}>
                                    {{ $storage ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>


                        <label>Основная память до, Гб</label>
                        <select name="storage_to">
                            @foreach([null,32,64,128,256,512] as $storage)
                                <option value="{{ $storage }}" {{ request('storage_to') == $storage ? 'selected' : '' }}>
                                    {{ $storage ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                        <div class="filter">
                        <label>Цвет</label>
                        <select name="color">
                            @foreach([null,'черный','белый','красный','синий','зеленый','серый','другие цвета'] as $color)
                                <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                    {{ $color ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                        <div class="filter">
                        <label>Размер экрана, дюймы</label>

                        <select name="screen_size">

                            <option value="" {{ !request('screen_size') ? 'selected' : '' }}>
                                Не важно
                            </option>

                            <option value="small" {{ request('screen_size') === 'small' ? 'selected' : '' }}>
                                До 6.1
                            </option>

                            <option value="medium" {{ request('screen_size') === 'medium' ? 'selected' : '' }}>
                                6.1 – 6.5
                            </option>

                            <option value="large" {{ request('screen_size') === 'large' ? 'selected' : '' }}>
                                Больше 6.5
                            </option>

                        </select>
                    </div>

                        <div class="filter">
                        <label>Формат SIM-карты</label>
                        <select name="sim_format">
                            @foreach([null,'eSIM','Nano-SIM', 'Micro-SIM', 'SIM'] as $sim_format)
                                <option value="{{ $sim_format }}" {{ request('sim_format') == $sim_format ? 'selected' : '' }}>
                                    {{ $sim_format ?? 'Не важно' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                        <div class="filter">
                        <label>Количество SIM-карт</label>
                        <select name="sim_count">
                            @foreach([null, 1, 2, 3] as $sim_count)
                                <option value="{{ $sim_count }}" {{ request('sim_count') == $sim_count ? 'selected' : '' }}>
                                    {{ $sim_count ?? 'Не важно' }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                        <div class="filter">
                        <label>Разрешение камеры от, Мп</label>
                        <select name="main_cam_resolution_from">
                            @foreach([null,0.03,0.08,0.3,0.5,1.3,2,8,12,13,16,20,32,48,50,64,100,108,200] as $main_cam_resolution_from)
                                <option value="{{ $main_cam_resolution_from }}" {{ request('main_cam_resolution_from') == $main_cam_resolution_from ? 'selected' : '' }}>
                                    {{ $main_cam_resolution_from ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>


                        <label>Разрешение камеры до, Мп</label>
                        <select name="main_cam_resolution_to">
                            @foreach([null,0.03,0.08,0.3,0.5,1.3,2,8,12,13,16,20,32,48,50,64,100,108,200] as $main_cam_resolution_to)
                                <option value="{{ $main_cam_resolution_to }}" {{ request('main_cam_resolution_to') == $main_cam_resolution_to ? 'selected' : '' }}>
                                    {{ $main_cam_resolution_to ?? 'Все' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                        <div class="filter">
                        <label>Емкость аккумулятора от, мАч</label>
                        <input type="number" name="battery_capacity_from" value="{{ request('battery_capacity_from') }}">

                        <label>Емкость аккумулятора до, мАч</label>
                        <input type="number" name="battery_capacity_to" value="{{ request('battery_capacity_to') }}">
                    </div>

                        <div class="filter">
                        <label>Время доставки</label>
                        <select name="delivery_time">
                            <option value="" {{ !request()->filled('delivery_time') ? 'selected' : '' }}>
                                Не важно
                            </option>

                            <option value="0" {{ request('delivery_time') === '0' ? 'selected' : '' }}>
                                Сегодня
                            </option>

                            <option value="1" {{ request('delivery_time') === '1' ? 'selected' : '' }}>
                                Завтра
                            </option>

                            <option value="7" {{ request('delivery_time') === '7' ? 'selected' : '' }}>
                                В течение недели
                            </option>

                        </select>

                    </div>
                    @else
                        <div class="filter">
                            <label>Цена от, р.</label>
                            <input type="number" name="price_from" value="{{ request('price_from') }}">

                            <label>Цена до, р.</label>
                            <input type="number" name="price_to" value="{{ request('price_to') }}">
                        </div>


                        <div class="filter">
                            <label>Цвет</label>
                            <select name="color">
                                @foreach([null,'черный','белый','красный','синий','зеленый','серый','другие цвета'] as $color)
                                    <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                        {{ $color ?? 'Все' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="filter">
                            <label>Формат SIM-карты</label>
                            <select name="sim_format">
                                @foreach([null,'eSIM','Nano-SIM', 'Micro-SIM', 'SIM'] as $sim_format)
                                    <option value="{{ $sim_format }}" {{ request('sim_format') == $sim_format ? 'selected' : '' }}>
                                        {{ $sim_format ?? 'Не важно' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter">
                            <label>Количество SIM-карт</label>
                            <select name="sim_count">
                                @foreach([null, 1, 2, 3] as $sim_count)
                                    <option value="{{ $sim_count }}" {{ request('sim_count') == $sim_count ? 'selected' : '' }}>
                                        {{ $sim_count ?? 'Не важно' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>




                        <div class="filter">
                            <label>Емкость аккумулятора от, мАч</label>
                            <input type="number" name="battery_capacity_from" value="{{ request('battery_capacity_from') }}">

                            <label>Емкость аккумулятора до, мАч</label>
                            <input type="number" name="battery_capacity_to" value="{{ request('battery_capacity_to') }}">
                        </div>

                        <div class="filter">
                            <label>Время доставки</label>
                            <select name="delivery_time">
                                <option value="" {{ !request()->filled('delivery_time') ? 'selected' : '' }}>
                                    Не важно
                                </option>

                                <option value="0" {{ request('delivery_time') === '0' ? 'selected' : '' }}>
                                    Сегодня
                                </option>

                                <option value="1" {{ request('delivery_time') === '1' ? 'selected' : '' }}>
                                    Завтра
                                </option>

                                <option value="7" {{ request('delivery_time') === '7' ? 'selected' : '' }}>
                                    В течение недели
                                </option>

                            </select>

                        </div>
                    @endif
                    <button type="submit">Применить</button>
                </form>
            </div>
        </aside>

    </div>

    <script>
        const token = document.querySelector('meta[name="csrf-token"]').content;

        document.querySelectorAll('.add-to-cart').forEach(btn => {

            btn.addEventListener('click', () => {

                const id = btn.dataset.id;

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

                        btn.textContent = 'Добавлено ✔';
                        btn.disabled = true;

                        setTimeout(() => {
                            btn.textContent = 'В корзину';
                            btn.disabled = false;
                        }, 1500);
                    });

            });

        });
    </script>
    <script>
        document.querySelector('.brands-toggle').addEventListener('click', function () {
            document.querySelector('.brands-wrapper').classList.toggle('open');
        });
    </script>
</x-layouts.app-shop>
