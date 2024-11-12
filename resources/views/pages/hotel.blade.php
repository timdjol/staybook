@extends('layouts.master')

@section('title', $hotel->__('title'))

@section('content')

    @auth
    <div class="page hotel">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-loop="true" data-autoplay="3000">
                        <img src="{{ Storage::url($hotel->image) }}" alt="">
                        @php
                            $images = \App\Models\Image::where('hotel_id', $hotel->id)->get();
                        @endphp
                        @isset($images)
                            @foreach($images as $image)
                                <img loading="lazy" src="{{ Storage::url($image->image) }}" alt="">
                            @endforeach
                        @endisset
                    </div>
                    <div class="servlisting">
                        <h5>@lang('main.services'):</h5>
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
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <h1>{{$hotel->__('title')}}</h1>
                    {!! $hotel->__('description') !!}
                    <div class="phone"><span>@lang('main.hphone')</span> <a href="tel:{{ $hotel->phone }}">{{
                    $hotel->phone}}</a></div>
                    <div class="address"><span>@lang('main.address')</span> {{ $hotel->address }}</div>
                    <div class="email"><span>Email:</span> <a href="mailto:{{ $hotel->email }}">{{ $hotel->email }}</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
                <div id="map" style="width: 100%; height: 300px;"></div>
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

    <div class="rooms">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="showed">@lang('main.showed') {{ $rooms->count() }}</div>
                </div>
            </div>
            @if($rooms->isNotEmpty())
                @foreach($rooms as $room)
                    @include('layouts.card', compact('room'))
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

@endsection
