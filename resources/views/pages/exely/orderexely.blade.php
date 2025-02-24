@extends('layouts.master')

@section('title', 'Забронировать')

@section('content')

    <div class="pagetitle">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">Забронировать</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>Забронировать</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @php
                        $now = \Carbon\Carbon::now();
                                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
                    @endphp
                    <div class="row">
                        <div class="col-md-8">
                            <img src="{{ $request->image }}" alt="">
                        </div>
                        <div class="col-md-4">
                            <h3>{{ $request->hotel }}</h3>
                            <h5>{{ $request->title }}</h5>
                            <div class="bed"><i class="fa-light fa-bed"></i> {{ $request->bed }}</div>
                            <div class="food"><i class="fa-solid fa-utensils"></i> {{ $request->food }}</div>
                            <div class="cancel"><i class="fa-solid fa-rotate-left"></i> {{ $request->cancel }}</div>
                            <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
                            <div id="map" style="width: 100%; height: 300px;"></div>
                            <script>
                                DG.then(function () {
                                    var map = DG.map('map', {
                                        center: [42.855608, 74.618626],
                                        zoom: 12
                                    });

                                    DG.marker([{{ $request->lat }}, {{ $request->lng }}], {scrollWheelZoom: false})
                                        .addTo(map)
                                        .bindLabel('{{ $request->hotel }}', {
                                            static: true
                                        });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <ul>
                                <li>propertyId: {{ $request->propertyId }}</li>
                                <li>arrivalDateTime: {{ $request->arrivalDate }}</li>
                                <li>departureDateTime: {{ $request->departureDate }}</li>
                                <li>ratePlan ID: {{ $request->ratePlanId }}</li>
                                <li>roomType ID: {{ $request->roomTypeId }}</li>
                                <li>placements Code: {{ $request->placementCode }}</li>
{{--                                <li>firstName: {{ $request-> }}</li>--}}
{{--                                <li>lastName: {{ $request-> }}</li>--}}
                                <li>guestCount: {{ $request->guestCount }}</li>
{{--                                <li>childAges: {{ $request->childAges }}</li>--}}
                                <li>checkSum: {{ $request->checkSum }}</li>
                                <li>services ID: {{ $request->servicesId }}</li>
{{--                                <li>services quantity: {{ $request-> }}</li>--}}
                            </ul>
                            <form action="{{ route('res_bookings_verify') }}">
                                <input type="hidden" name="propertyId" value="{{ $request->propertyId }}">
                                <input type="hidden" name="arrivalDate" value="{{ $request->arrivalDate }}">
                                <input type="hidden" name="departureDate" value="{{ $request->departureDate }}">
                                <input type="hidden" name="ratePlanId" value="{{ $request->ratePlanId }}">
                                <input type="hidden" name="roomTypeId" value="{{ $request->roomTypeId }}">
                                <input type="hidden" name="roomType" value="{{ $request->roomType }}">
                                <input type="hidden" name="roomCount" value="{{ $request->roomCount }}">
                                <input type="hidden" name="roomCode" value="{{ $request->roomCode }}">
                                <input type="hidden" name="placementCode" value="{{ $request->placementCode }}">
                                <input type="hidden" name="guestCount" value="{{ $request->guestCount }}">
                                <input type="hidden" name="checkSum" value="{{ $request->checkSum }}">
                                <input type="hidden" name="servicesId" value="{{ $request->servicesId }}">
{{--                                <input type="hidden" name="room_id" value="{{ $request->room_id}}">--}}
{{--                                <input type="hidden" name="hotel_id" value="{{$request->hotel_id}}">--}}
{{--                                <input type="hidden" name="count" value="1">--}}
{{--                                <input type="hidden" name="tag" value="exely">--}}
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-4" for="title">ФИО</label>
                                            <input type="text" class="form-control" name="name" value="test"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Номер телефона</label>
                                            <input type="text" name="phone" value="+996500500500">
                                            <div id="output"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @include('auth.layouts.error', ['fieldname' => 'email'])
                                            <label class="col-xs-4" for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="test@mail.com"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('main.sum') $</label>
                                            <input type="text" id="sum" name="price" value="{{ $request->price }}"
                                                   readonly>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        @include('auth.layouts.error', ['fieldname' => 'comment'])
                                        <label for="">Комментарий</label>
                                        <textarea name="comment" rows="3">Test message</textarea>
                                    </div>
                                    @csrf
                                    <button class="more" id="saveBtn">@lang('main.book')</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .page #map {
            margin-top: 20px;
        }

        .page i {
            color: darkblue;
        }

        .page form {
            margin-top: 50px;
        }

        .page form button {
            width: auto;
            padding: 10px 30px;
            margin-left: 10px;
        }
    </style>

@endsection
