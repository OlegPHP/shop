<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Phone;
use App\Models\PhoneImage;
use App\Models\PhoneSpec;

class HomeController extends Controller
{
    public function show(Request $request, Brand $brand = null)
    {
        $brands = Brand::orderBy('name')->get();
        $query = Phone::with([
            'phoneImages' => function ($q) {
                $q->where('is_main', 1);
            },
            'phoneSpec']);
        if($brand){
            $query->where('brand_id', $brand->id);
        }



        if ($request->type === 'smartphone') {
            $query->where('name', 'NOT LIKE', 'Мобильный телефон%');
        }

        if ($request->type === 'feature') {
            $query->where('name', 'LIKE', 'Мобильный телефон%');
        }

        // ФИЛЬТР ПО ЦЕНЕ
        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // ФИЛЬТР ПО ОПЕРАТИВНОЙ ПАМЯТИ
        if ($request->filled('ram_from')) {
            $query->where('ram', '>=', $request->ram_from);
        }

        if ($request->filled('ram_to')) {
            $query->where('ram', '<=', $request->ram_to);
        }

        // ФИЛЬТР ПО ОСНОВНОЙ ПАМЯТИ
        if ($request->filled('storage_from')) {
            $query->where('storage', '>=', $request->storage_from);
        }

        if ($request->filled('storage_to')) {
            $query->where('storage', '<=', $request->storage_to);
        }
        // ФИЛЬТР ПО ВРЕМЕНИ ДОСТАВКИ
        if ($request->filled('delivery_time')) {

            if ($request->delivery_time === '7') {
                $query->whereBetween('delivery_time', [2, 7]);
            } else {
                $query->where('delivery_time', $request->delivery_time);
            }

        }

        // ФИЛЬТР ПО ЦВЕТУ
        $colors = ['черный','белый','красный','синий','зеленый','серый'];
        if ($request->filled('color')) {
            if(in_array($request->color, $colors)) {
                $query->where('color', $request->color);
            }else{
                $query->whereNotIn('color', $colors);
            }
        }

        //ФИЛЬТР ПО ОС

        if ($request->filled('os')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->where('os', $request->os);
            });
        }

        //  ФИЛЬТР ПО РАЗМЕРУ ЭКРАНА

        if ($request->filled('screen_size')) {

            match ($request->screen_size) {
                'small' => $query->whereHas('phoneSpec', function ($q) {
                    $q->where('screen_size', '<=', 6.1);
                }),
                'medium' => $query->whereHas('phoneSpec', function ($q) {
                    $q->whereBetween('screen_size', [6.1, 6.5]);
                }),
                'large' => $query->whereHas('phoneSpec', function ($q) {
                    $q->where('screen_size', '>=', 6.5);
                }),
            };

        }

        //ФИЛЬТР ПО ФОРМАТУ СИМ КАРТЫ

        if ($request->filled('sim_format')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {

                if ($request->sim_format === 'SIM') {
                    $q->where('sim_format', 'SIM');
                } else {
                    $q->where('sim_format', 'LIKE', '%' . $request->sim_format . '%');
                }

            });
        }

        //ФИЛЬТР КОЛИЧЕСТВУ СИМ КАРТ

        if ($request->filled('sim_count')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->where('sim_count', $request->sim_count);
            });
        }

        //ФИЛЬТР ПО РАЗРЕШЕНИЮ КАМЕРЫ
        if ($request->filled('main_cam_resolution_from')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->whereRaw('CAST(main_cam_resolution AS DECIMAL(5,2)) >= ?', [$request->main_cam_resolution_from]);
            });
        }

        if ($request->filled('main_cam_resolution_to')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->whereRaw('CAST(main_cam_resolution AS DECIMAL(5,2)) <= ?', [$request->main_cam_resolution_to]);
            });
        }
        //ФИЛЬТР ПО ЕМКОСТИ АККУМУЛЯТОРА

        if ($request->filled('battery_capacity_from')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->where('battery_capacity', '>=' ,$request->battery_capacity_from);
            });
        }
        if ($request->filled('battery_capacity_to')) {
            $query->whereHas('phoneSpec', function ($q) use ($request) {
                $q->where('battery_capacity', '<=', $request->battery_capacity_to);
            });
        }


        $phones = $query->paginate(12)->onEachSide(0)->withQueryString();

        return view('home.show', compact('brands', 'phones', 'brand'));
    }
}
