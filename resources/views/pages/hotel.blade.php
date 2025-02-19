@extends('layouts.master')

@section('title', $hotel->__('title'))

@section('content')

    @auth
        <div class="page hotel">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1>{{$hotel->__('title')}}</h1>
                        <div class="address">{{ $hotel->__('address') }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="min_price">от {{ $min }} $</div>
                        <div class="btn-wrap">
                            <a href="#price" class="more">Посмотреть цены</a>
                        </div>
                    </div>
                </div>
                <div class="row gallery">
                    <div class="col-md-2">
                        <a href="{{ Storage::url($hotel->image) }}"><img src="{{ Storage::url($hotel->image) }}" alt=""></a>
                    </div>
                    @php
                        $images = \App\Models\Image::where('hotel_id', $hotel->id)->get();
                    @endphp
                    @isset($images)
                        @foreach($images as $image)
                            <div class="col-md-2">
                                <a href="{{ Storage::url($image->image) }}"><img loading="lazy"
                                                                                 src="{{ Storage::url($image->image) }}"
                                                                                 alt=""></a>
                            </div>
                        @endforeach
                    @endisset
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="servlisting">
                            <h5>@lang('main.amenities'):</h5>
                            <div class="row">
                                @php
                                    $services = \App\Models\Service::where('hotel_id', $hotel->id)->firstOrFail();
                                    $servs = explode(', ', $services->services);
                                @endphp
                                @foreach($servs as $service)
                                    <div class="col-md-4">
                                        <div class="item">
                                            <i class="fa-regular fa-check"></i> {{ $service }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {!! $hotel->__('description') !!}
                            <div class="phone"><span>@lang('main.hphone')</span> <a href="tel:{{ $hotel->phone }}">{{
                    $hotel->phone}}</a></div>
                            <div class="email"><span>Email:</span> <a
                                    href="mailto:{{ $hotel->email }}">{{ $hotel->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h2>Расположение</h2>
                    <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
                    <div id="map" style="width: 100%; height: 400px;"></div>
                    <script>
                        DG.then(function () {
                            var map = DG.map('map', {
                                center: [{{$hotel->lat}}, {{$hotel->lng}}],
                                zoom: 14
                            });

                            DG.marker([{{$hotel->lat}}, {{$hotel->lng}}], {scrollWheelZoom: false})
                                .addTo(map)
                                .bindLabel('{{$hotel->__('title')}}', {
                                    static: true
                                });
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="rooms" id="price">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Доступные варианты
                        </h2>
                    </div>
                </div>
                @if($rooms->isNotEmpty())
                    @foreach($rooms as $room)
                        <div class="row rooms-item">
                            <div class="col-lg-4">
                                <a href="">
                                    <img src="{{ Storage::url($room->image) }}" alt="">
                                </a>
                                <div class="bed"><i class="fa-light fa-bed"></i> {{ $room->bed }}</div>
                                <div class="amenities">
                                    {{ $room->services }}
                                </div>
                            </div>
                            @php
                                $cats = \App\Models\Category::where('room_id', $room->id)->get();
                            @endphp
                            @foreach($cats as $cat)
                                <div class="col-lg-4">
                                    <h5>{{ $cat->__('title') }}</h5>
                                    <div class="food"><i class="fa-solid fa-utensils"></i> {{ $cat->food_id }}</div>
                                    <div class="cancel"><i class="fa-solid fa-rotate-left"></i> {{ $cat->rule->__('title') }}</div>
                                    <div class="price">
                                        @php
                                            if($count_day != null){
                                                $price = ($cat->room->price + $cat->food->price) * $count * $count_day;
                                            }
                                            else {
                                                $fprice = \App\Models\Food::where('title_en', $cat->food_id)->first();
                                                $fprice = $fprice->price;
                                                $price = ($cat->room->price + $fprice) * $count;
                                            }
                                            if($count != null){
                                                $fprice = \App\Models\Food::where('title_en', $cat->food_id)->first();
                                                $fprice = $fprice->price;
                                                $price = ($cat->room->price + $fprice) * $count;
                                            } else {
                                                $fprice = \App\Models\Food::where('title_en', $cat->food_id)->first();
                                                $fprice = $fprice->price;
                                                $price = $cat->room->price + $fprice;
                                            }
                                        @endphp
                                        {{ $price }} $
                                    </div>
                                    <div class="nds">Все налоги включены</div>
                                    <div class="btn-wrap">
                                        <form action="{{ route('order', $cat->id) }}">
                                            @csrf
                                            <input type="hidden" name="hotel" value="{{ $room->hotel->title }}">
                                            <input type="hidden" name="hotel_id" value="{{ $room->hotel->id }}">
                                            <input type="hidden" name="lng" value="{{ $room->hotel->lng }}">
                                            <input type="hidden" name="lat" value="{{ $room->hotel->lat }}">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="title" value="{{ $cat->__('title') }}">
                                            <input type="hidden" name="food" value="{{ $cat->food_id }}">
                                            <input type="hidden" name="cancel" value="{{ $cat->rule->__('title') }}">
                                            <input type="hidden" name="price" value="{{ $price }}">
                                            <input type="hidden" name="image" value="{{ Storage::url($room->image) }}">
                                            <input type="hidden" name="bed" value="{{ $room->bed }}">
                                            <button class="more">Забронировать</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger">@lang('main.not_found')</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="pagination">
                            {{ $rooms->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <div class="descr">Необходимо пройти <a href="{{ route('login') }}">авторизацию</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <style>
        .hotel .min_price{
            font-size: 24px;
        }
        .hotel .btn-wrap{
            margin-top: 20px;
        }
        .hotel .btn-wrap .more{
            color: #fff;
        }
        .hotel .gallery{
            margin-top: 20px;
        }
        .hotel .gallery img{
            height: 20vh;
            object-fit: cover;
        }
        .servlisting{
            margin: 20px 0;
        }
        .hotel #map{
            margin-top: 0px;
        }
        .hotel i{
            color: #0163b4;
        }
        .nds{
            font-size: 14px;
            color: #0163b4;
        }
    </style>

@endsection
