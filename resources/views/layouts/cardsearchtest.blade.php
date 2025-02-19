@php
    //$rooms = \App\Models\Room::where('hotel_id', $hotel->id)->orderBy('price', 'asc')->get();
    //$cats = \App\Models\Category::where('hotel_id', $hotel->id)->where('title', $request->title)->where('food_id', $request->food_id)->orderBy('price', 'asc')->take(1)->get();
    $query = \App\Models\Category::with('room', 'food', 'rule', 'child');

    //food
    if ($request->filled('food_id')) {
        $food = $request->input('food_id');
        $query->where('food_id', $food);
    }

    //cancellation
    if ($request->filled('cancelled')) {
        $cancel = $request->input('cancelled');
        $query->whereHas('rule', function ($quer) use ($cancel) {
            $quer->where('size', 0);
        });
    }

    //extra_place
//    if ($request->filled('extra_place')) {
//            $extra_place = $request->input('extra_place');
//            $query->whereHas('child', function ($quer) use ($extra_place) {
//                $quer->where('price_extra', '!=', 0);
//                $quer->orWhere('price_extra', '!=', null);
//            });
//        }

     $cats = $query->where('hotel_id', $hotel->id)->take(1)->get();
@endphp

<div class="row rooms-item @if($cats->isEmpty()) hidden @endif">
    <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="2000">
        <a href="{{ route('hotel', $hotel->code ?? '') }}" target="_blank">
            <div class="img" style="background-image: url({{ Storage::url($hotel->image) }})"></div>
        </a>
    </div>
    <div class="col-lg-8 col-md-6">
        <div class="start">@lang('main.start_d') {{ $hotel->checkin ?? '' }}</div>
        <div class="end">@lang('main.end_d') {{ $hotel->checkout ?? '' }}</div>
        <div class="title">{{ $hotel->__('title') ?? '' }}</div>
        <div class="address">{{ $hotel->__('address') ?? '' }}</div>
        {{--        <div class="services">{{ $hotel->service->services }}</div>--}}
        <div class="room" style="margin-top: 20px">
            @foreach($cats as $cat)
                <div class="room-item">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>{{ $cat->room->__('title') ?? '' }}</h5>
                            <div class="plan">Тариф: {{ $cat->__('title') }}</div>
                            <div class="bed"><i class="fa-light fa-bed"></i> {{ $cat->room->bed }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="listings">
                                <ul>
                                    <li><i class="fa-solid fa-utensils"></i> {{ $cat->food_id }}</li>
                                    <li><i class="fa-solid fa-rotate-left"></i> {{ $cat->rule->__('title') }}</li>
                                    @php
                                        $ch = \App\Models\Child::where('room_id', $cat->room->id)->first();
                                    @endphp
                                    @if($ch->price_extra != 0)
                                        <li>Есть дополнительное место</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php
                                if($count_day != null){
                                    $price = ($cat->room->price + $cat->food->price) * $count * $count_day;
                                } else {
                                    $fprice = \App\Models\Food::where('title_en', $cat->food_id)->first();
                                    $fprice = $fprice->price;
                                    $price = ($cat->room->price + $fprice) * $count;
                                }
                            @endphp
                            <div class="price">{{ $price }} $</div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="btn-wrap">
            <a href="{{ route('hotel', $hotel->code) }}?title={{ $request->title }}&start_d={{ date_format($start, 'Y-m-d') }}&end_d={{ date_format($end, 'Y-m-d') }}&count={{ $request->count }}&countc={{ $request->countc }}&age1={{ $request->age1 }}&age2={{ $request->age2 }}&age3={{ $request->age3 }}&citizenship={{ $request->citizenship }}&rating={{ $request->rating }}&food_id={{ $request->food_id }}&early_in={{ $request->early_in }}&early_out={{ $request->early_out }}"
               target="_blank" class="more">Показать все номера</a>
        </div>
    </div>
</div>
