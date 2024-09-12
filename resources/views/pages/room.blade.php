@extends('layouts.master')

@section('title', $room->__('title'))

@section('content')

    <div class="page rooms single">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-loop="true"
                         data-autoplay="3000">
                        <img loading="lazy" src="{{ Storage::url($room->image) }}" alt="">
                        @foreach($images as $image)
                            <img loading="lazy" src="{{ Storage::url($image->image) }}" alt="">
                        @endforeach
                    </div>
                    <div class="cont">
                        <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
                        <div id="map" style="width: 100%; height: 300px;"></div>
                        <script>
                            DG.then(function () {
                                var map = DG.map('map', {
                                    center: [{{$room->hotel->lat}}, {{$room->hotel->lng}}],
                                    zoom: 14
                                });

                                DG.marker([{{$room->hotel->lat}}, {{$room->hotel->lng}}], {scrollWheelZoom: false})
                                    .addTo(map)
                                    .bindLabel('{{$room->hotel->__('title')}}', {
                                        static: true
                                    });
                            });
                        </script>
                        <div class="phone"><span>@lang('main.hphone')</span> <a href="tel:{{ $room->hotel->phone }}">{{
                $room->hotel->phone
                }}</a></div>
                        <div class="address"><span>@lang('main.address')</span> {{ $room->hotel->__('address') }}</div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-duration="2000">
                    <h1>{{ $room->__('title') }}</h1>
                    <h5>{{ $room->hotel->__('title') }}</h5>
                    <div class="price">@lang('main.price') @php
                            //$comission = \Illuminate\Support\Facades\Auth::user()->comission;
                        $comission = 10;
                        @endphp
                        @if(isset($comission))
                            <td>{{ $room->price + ($room->price * $comission / 100) }} $</td>
                        @else
                            <td>{{ $room->price }} $</td>
                        @endif</div>
                    <div class="btn-wrap">
                        <a href="#callback" class="more">@lang('main.book')</a>
                        <div class="hidden">
                            <form action="{{ route('book_mail') }}" method="post" id="callback" class="form-callback">
                                <h3>@lang('main.book') {{ $room->__('title') }} <br> {{ $room->hotel->__('title')
                                }}</h3>
                                <input type="hidden" name="room_id" value="{{ $room->id}}">
                                <input type="hidden" name="hotel_id" value="{{$room->hotel->id}}">
                                <div class="form-group">
                                    <label class="col-xs-4" for="end_d">@lang('main.date')</label>
                                    <input type="text" id="date">
                                    <input type="hidden" id="start_d"
                                           @php
                                               $now = \Carbon\Carbon::now();
                                                   $date = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
                                                  //$date = date('Y-m-d H:s:i');
                                           @endphp
                                           name="start_d" value="{{ date('Y-m-d H:s:i') }}">
                                    <input type="hidden" id="end_d" name="end_d" value="{{ $date->addDays(1) }}">
                                   
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="count">@lang('main.search-count')</label>
                                    <select name="count" id="count" onchange="countCheck(this);" required>
                                        <option value="">@lang('main.choose')</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>

                                <div class="form-group" id="title">
                                    <label class="col-xs-4" for="title">@lang('main.adult_name1')</label>
                                    <input type="text" class="form-control" name="title"
                                           id="title"
                                           required/>
                                </div>
                                <div class="form-group" id="title2">
                                    <label class="col-xs-4" for="title2">@lang('main.adult_name2')</label>
                                    <input type="text" class="form-control" name="title2"/>
                                </div>


                                <div class="form-group">
                                    <label for="">@lang('main.count_child')</label>
                                    <select name="countc" id="countc" onchange="ageCheck(this);">
                                        <option value="">@lang('main.choose')</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="row" id="child1">
                                    <div class="col-md-4">
                                        <select name="age1" id="age1">
                                            <option value="1">@lang('main.1_year')</option>
                                            <option value="2">@lang('main.2_year')</option>
                                            <option value="3">@lang('main.3_year')</option>
                                            <option value="4">@lang('main.4_year')</option>
                                            <option value="5">@lang('main.5_year')</option>
                                            <option value="6">@lang('main.6_year')</option>
                                            <option value="7">@lang('main.7_year')</option>
                                            <option value="8">@lang('main.8_year')</option>
                                            <option value="9">@lang('main.9_year')</option>
                                            <option value="10">@lang('main.10_year')</option>
                                            <option value="11">@lang('main.11_year')</option>
                                            <option value="12">@lang('main.12_year')</option>
                                            <option value="13">@lang('main.13_year')</option>
                                            <option value="14">@lang('main.14_year')</option>
                                            <option value="16">@lang('main.15_year')</option>
                                            <option value="16">@lang('main.16_year')</option>
                                            <option value="17">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec1"
                                                   id="titlec1" placeholder="@lang('main.child_name1')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="child2">
                                    <div class="col-md-4">
                                        <select name="age2" id="age2">
                                            <option value="1">@lang('main.1_year')</option>
                                            <option value="2">@lang('main.2_year')</option>
                                            <option value="3">@lang('main.3_year')</option>
                                            <option value="4">@lang('main.4_year')</option>
                                            <option value="5">@lang('main.5_year')</option>
                                            <option value="6">@lang('main.6_year')</option>
                                            <option value="7">@lang('main.7_year')</option>
                                            <option value="8">@lang('main.8_year')</option>
                                            <option value="9">@lang('main.9_year')</option>
                                            <option value="10">@lang('main.10_year')</option>
                                            <option value="11">@lang('main.11_year')</option>
                                            <option value="12">@lang('main.12_year')</option>
                                            <option value="13">@lang('main.13_year')</option>
                                            <option value="14">@lang('main.14_year')</option>
                                            <option value="16">@lang('main.15_year')</option>
                                            <option value="16">@lang('main.16_year')</option>
                                            <option value="17">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec2"
                                                   id="titlec2" placeholder="@lang('main.child_name2')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="child3">
                                    <div class="col-md-4">
                                        <select name="age3" id="age3">
                                            <option value="1">@lang('main.1_year')</option>
                                            <option value="2">@lang('main.2_year')</option>
                                            <option value="3">@lang('main.3_year')</option>
                                            <option value="4">@lang('main.4_year')</option>
                                            <option value="5">@lang('main.5_year')</option>
                                            <option value="6">@lang('main.6_year')</option>
                                            <option value="7">@lang('main.7_year')</option>
                                            <option value="8">@lang('main.8_year')</option>
                                            <option value="9">@lang('main.9_year')</option>
                                            <option value="10">@lang('main.10_year')</option>
                                            <option value="11">@lang('main.11_year')</option>
                                            <option value="12">@lang('main.12_year')</option>
                                            <option value="13">@lang('main.13_year')</option>
                                            <option value="14">@lang('main.14_year')</option>
                                            <option value="16">@lang('main.15_year')</option>
                                            <option value="16">@lang('main.16_year')</option>
                                            <option value="17">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec3"
                                                   id="titlec3" placeholder="@lang('main.child_name3')"/>
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    #title2, #child1, #child2, #child3 {
                                        display: none;
                                    }
                                </style>

                                <div class="form-group">
                                    <label class="col-xs-4" for="phone">@lang('main.phone')</label>
                                    <input type="number" class="form-control" name="phone" id="phone"
                                           required>
                                    <div id="output" class="output"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"/>
                                </div>

                                {{--                                <input type="hidden" id="price" value="@if(isset($comission)){{ $room->price +--}}
                                {{--                                ($room->price * $comission / 100) }}--}}
                                {{--                        @else--}}
                                {{--                            {{ $room->price }}--}}
                                {{--                        @endif--}}
                                {{--                                ">--}}
                                <input type="hidden" id="price" value="{{ $room->price }}">
                                <input type="hidden" id="price2" value="{{ $room->price2 }}">
                                <input type="hidden" id="pricec" value="{{ $room->pricec }}">
                                <input type="hidden" id="price2" class="price2" value="{{ $room->price2 }}">
                                <input type="hidden" id="pricec" class="pricec" value="{{$room->pricec }}">
                                <input type="hidden" id="pricec2" class="pricec" value="{{$room->pricec2 }}">
                                <input type="hidden" id="pricec3" class="pricec" value="{{$room->pricec3 }}">
                                <input type="hidden" id="pricec4" class="pricec" value="{{$room->pricec4 }}">
                                <input type="hidden" id="pricec5" class="pricec" value="{{$room->pricec5 }}">
                                <input type="hidden" id="pricec6" class="pricec" value="{{$room->pricec6 }}">
                                <input type="hidden" id="pricec7" class="pricec" value="{{$room->pricec7 }}">
                                <input type="hidden" id="pricec8" class="pricec" value="{{$room->pricec8 }}">
                                <input type="hidden" id="pricec9" class="pricec" value="{{$room->pricec9 }}">
                                <input type="hidden" id="pricec10" class="pricec" value="{{$room->pricec10 }}">
                                <input type="hidden" id="pricec11" class="pricec" value="{{$room->pricec11 }}">
                                <input type="hidden" id="pricec12" class="pricec" value="{{$room->pricec12 }}">
                                <input type="hidden" id="pricec13" class="pricec" value="{{$room->pricec13 }}">
                                <input type="hidden" id="pricec14" class="pricec" value="{{$room->pricec14 }}">
                                <input type="hidden" id="pricec15" class="pricec" value="{{$room->pricec15 }}">
                                <input type="hidden" id="pricec16" class="pricec" value="{{$room->pricec16 }}">
                                <input type="hidden" id="pricec17" class="pricec" value="{{$room->pricec17 }}">

                                <div class="form-group">
                                    <label for="">@lang('main.sum')</label>
                                    <input type="text" id="sum" name="sum" readonly>
                                </div>

                                <input type="hidden" name="book_id" value="{{ $random }}">
                                <input type="hidden" name="status" value="Paid">

                                <script>
                                    function countCheck(that) {
                                        if (that.value == 2) {
                                            document.getElementById("title").style.display = "block";
                                            document.getElementById("title2").style.display = "block";
                                        } else {
                                            document.getElementById("title").style.display = "block";
                                            document.getElementById("title2").style.display = "none";
                                        }
                                    }

                                    function ageCheck(that) {
                                        if (that.value == 1) {
                                            document.getElementById("child1").style.display = "flex";
                                            document.getElementById("child2").style.display = "none";
                                            document.getElementById("child3").style.display = "none";
                                        } else if (that.value == 2) {
                                            document.getElementById("child1").style.display = "flex";
                                            document.getElementById("child2").style.display = "flex";
                                            document.getElementById("child3").style.display = "none";
                                        } else if (that.value == 3) {
                                            document.getElementById("child1").style.display = "flex";
                                            document.getElementById("child2").style.display = "flex";
                                            document.getElementById("child3").style.display = "flex";
                                        } else {
                                            document.getElementById("child1").style.display = "none";
                                            document.getElementById("child2").style.display = "none";
                                            document.getElementById("child3").style.display = "none";
                                        }
                                    }

                                    $("#count, #countc, #date, #age1, #age2, #age3").change(function () {
                                        let price = $('#price').val();
                                        let price2 = $('#price2').val();
                                        let pricec = $('#pricec').val();
                                        let pricec2 = $('#pricec2').val();
                                        let pricec3 = $('#pricec3').val();
                                        let pricec4 = $('#pricec4').val();
                                        let pricec5 = $('#pricec5').val();
                                        let pricec6 = $('#pricec6').val();
                                        let pricec7 = $('#pricec7').val();
                                        let pricec8 = $('#pricec8').val();
                                        let pricec9 = $('#pricec9').val();
                                        let pricec10 = $('#pricec10').val();
                                        let pricec11 = $('#pricec11').val();
                                        let pricec12 = $('#pricec12').val();
                                        let pricec13 = $('#pricec13').val();
                                        let pricec14 = $('#pricec14').val();
                                        let pricec15 = $('#pricec15').val();
                                        let pricec16 = $('#pricec16').val();
                                        let pricec17 = $('#pricec17').val();

                                        let age1 = $('#age1').val();
                                        let age2 = $('#age2').val();
                                        let age3 = $('#age3').val();

                                        if(age1 == 1){
                                            pricec = pricec;
                                        }
                                        if(age1 == 2){
                                            pricec = pricec2;
                                        }
                                        if(age1 == 3){
                                            pricec = pricec3;
                                        }
                                        if(age1 == 4){
                                            pricec = pricec4;
                                        }
                                        if(age1 == 5){
                                            pricec = pricec5;
                                        }
                                        if(age1 == 6){
                                            pricec = pricec6;
                                        }
                                        if(age1 == 7){
                                            pricec = pricec7;
                                        }
                                        if(age1 == 8){
                                            pricec = pricec8;
                                        }
                                        if(age1 == 9){
                                            pricec = pricec9;
                                        }
                                        if(age1 == 10){
                                            pricec = pricec10;
                                        }
                                        if(age1 == 11){
                                            pricec = pricec11;
                                        }
                                        if(age1 == 12){
                                            pricec = pricec12;
                                        }
                                        if(age1 == 13){
                                            pricec = pricec13;
                                        }
                                        if(age1 == 14){
                                            pricec = pricec14;
                                        }
                                        if(age1 == 15){
                                            pricec = pricec15;
                                        }
                                        if(age1 == 16){
                                            pricec = pricec16;
                                        }
                                        if(age1 == 17){
                                            pricec = pricec17;
                                        }

                                        //age2
                                        if(age2 == 1){
                                            pricec = pricec;
                                        }
                                        if(age2 == 2){
                                            pricec = pricec2;
                                        }
                                        if(age2 == 3){
                                            pricec = pricec3;
                                        }
                                        if(age2 == 4){
                                            pricec = pricec4;
                                        }
                                        if(age2 == 5){
                                            pricec = pricec5;
                                        }
                                        if(age2 == 6){
                                            pricec = pricec6;
                                        }
                                        if(age2 == 7){
                                            pricec = pricec7;
                                        }
                                        if(age2 == 8){
                                            pricec = pricec8;
                                        }
                                        if(age2 == 9){
                                            pricec = pricec9;
                                        }
                                        if(age2 == 10){
                                            pricec = pricec10;
                                        }
                                        if(age2 == 11){
                                            pricec = pricec11;
                                        }
                                        if(age2 == 12){
                                            pricec = pricec12;
                                        }
                                        if(age2 == 13){
                                            pricec = pricec13;
                                        }
                                        if(age2 == 14){
                                            pricec = pricec14;
                                        }
                                        if(age2 == 15){
                                            pricec = pricec15;
                                        }
                                        if(age2 == 16){
                                            pricec = pricec16;
                                        }
                                        if(age2 == 17){
                                            pricec = pricec17;
                                        }

                                        //age3
                                        if(age3 == 1){
                                            pricec = pricec;
                                        }
                                        if(age3 == 2){
                                            pricec = pricec2;
                                        }
                                        if(age3 == 3){
                                            pricec = pricec3;
                                        }
                                        if(age3 == 4){
                                            pricec = pricec4;
                                        }
                                        if(age3 == 5){
                                            pricec = pricec5;
                                        }
                                        if(age3 == 6){
                                            pricec = pricec6;
                                        }
                                        if(age3 == 7){
                                            pricec = pricec7;
                                        }
                                        if(age3 == 8){
                                            pricec = pricec8;
                                        }
                                        if(age3 == 9){
                                            pricec = pricec9;
                                        }
                                        if(age3 == 10){
                                            pricec = pricec10;
                                        }
                                        if(age3 == 11){
                                            pricec = pricec11;
                                        }
                                        if(age3 == 12){
                                            pricec = pricec12;
                                        }
                                        if(age3 == 13){
                                            pricec = pricec13;
                                        }
                                        if(age3 == 14){
                                            pricec = pricec14;
                                        }
                                        if(age3 == 15){
                                            pricec = pricec15;
                                        }
                                        if(age3 == 16){
                                            pricec = pricec16;
                                        }
                                        if(age3 == 17){
                                            pricec = pricec17;
                                        }

                                        let count = $('#count').val();
                                        let countc = $('#countc').val();

                                        let start_d = $('#start_d').val();
                                        let end_d = $('#end_d').val();

                                        let date1 = new Date(start_d);
                                        let date2 = new Date(end_d);
                                        let days = (date2 - date1) / (1000 * 60 * 60 * 24);

                                        let sum = (price * days) + (pricec * countc * days);
                                        let sum2 = (price2 * days) + (pricec * countc * days);
                                        if (count == 2) {
                                            $('#sum').val(sum2 + ' $');
                                        } else {
                                            $('#sum').val(sum + ' $');
                                        }
                                    });

                                </script>
                                @csrf

                                <button class="more" id="saveBtn">@lang('main.book')</button>
                            </form>
                        </div>
                        {{--                        @if(session('locale')=='ru')--}}
                        {{--                            <a href="https://api.whatsapp.com/send?phone={{ $room->hotel->phone }}&text=Заявка--}}
                        {{--                        на номер {{ $room->__('title') }}" class="more whatsapp"--}}
                        {{--                               target="_blank">@lang('main.book_whatsapp')</a>--}}
                        {{--                        @else--}}
                        {{--                            <a href="https://api.whatsapp.com/send?phone={{ $room->hotel->phone}}&text=Booking room {{ $room->__('title') }}"--}}
                        {{--                               class="more whatsapp"--}}
                        {{--                               target="_blank">@lang('main.book_whatsapp')</a>--}}
                        {{--                        @endif--}}
                    </div>
                    {!! $room->__('description') !!}
                    <div class="list">
                        @if($room->include != '')
                            <p><i class="fa-light fa-mug-saucer"></i> {{$room->include}}</p>
                        @endif
                        @if($room->hotel->early_in != '')
                            <p><i class="fa-light fa-calendar-days"></i> @lang('main.early')
                                {{$room->hotel->early_in}}</p>
                        @endif
                        @if($room->hotel->early_out != '')
                            <p><i class="fa-light fa-calendar-days"></i> @lang('main.late')
                                {{$room->hotel->early_out}}</p>
                        @endif
                        @if($room->hotel->cancelled == 0 || $room->hotel->cancelled == '')
                            <p><i class="fa-regular fa-money-bill"></i> @lang('main.cancelled')</p>
                        @else
                            <p><i class="fa-regular fa-money-bill"></i> @lang('main.cancelled-price') {{
                            $room->hotel->cancelled }}$
                        @endif

                    </div>
                    <div class="servlisting">
                        <h5>@lang('main.services'):</h5>
                        <div class="row">
                            @php
                                $services = explode(', ', $room->hotel->service->services);
                            @endphp
                            @foreach($services as $service)
                                <div class="col-md-4">
                                    <div class="item">
                                        <i class="fa-regular fa-check"></i> {{ $service }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="servlisting">
                        <h5>@lang('main.payments'):</h5>
                        <div class="row">
                            @php
                                $pays = explode(', ', $room->hotel->payment->payments);
                            @endphp
                            @foreach($pays as $pay)
                                <div class="col-md-3">
                                    <div class="item">
                                        <i class="fa-light fa-credit-card"></i> {{ $pay }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="share">
                        <div class="descr">@lang('main.share')</div>
                        <script src="https://yastatic.net/share2/share.js"></script>
                        <div class="ya-share2" data-curtain data-shape="round"
                             data-services="vkontakte,odnoklassniki,telegram,twitter,whatsapp,linkedin"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($related->isNotEmpty())
        <div class="page rooms related">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>@lang('main.related')</h2>
                    </div>
                </div>
                @foreach($related as $room)
                    @include('layouts.card', compact('room'))
                @endforeach
            </div>
        </div>
    @endif

@endsection
