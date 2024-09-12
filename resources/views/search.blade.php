@extends('layouts.master')

@section('title', 'Поиск')

@section('content')

{{--    {{ $reservedCount }}--}}

    <div class="pagetitle" style="background-image: url({{ url('/') }}/img/page.jpg)">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">@lang('main.search')</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('homepage')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>@lang('main.search')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if($rooms->isNotEmpty())

        <div class="page rooms search sf">
            <div class="container">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">@lang('main.list')</li>
                    <li class="tab-link" data-tab="tab-2">@lang('main.on_map')</li>
                </ul>
                <div id="tab-1" class="tab-content current">
                    @foreach($rooms as $room)
                        @include('layouts.cardsearch', compact('room'))
                    @endforeach
                </div>
                <div id="tab-2" class="tab-content">
                    <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    <script>
                        DG.then(function () {
                            var map = DG.map('map', {
                                center: [42.855608, 74.618626],
                                zoom: 12
                            });

                            @foreach($rooms as $room)
                            DG.marker([{{ $room->hotel->lat ?? '' }}, {{ $room->hotel->lng ?? '' }}], {
                                scrollWheelZoom:
                                    false
                            }).addTo(map).bindLabel('<a target="_blank" href="{{ route('hotel', $room->hotel->code ?? '')
                                        }}">{{Illuminate\Support\Str::limit(strip_tags($room->hotel->title ?? ''),12)
                                        }}</a>', {
                                static: true
                            });
                            @endforeach
                        });
                    </script>
                </div>
            </div>
        </div>

    @else
        <div class="page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>@lang('main.not_found')</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif


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

        $(document).ready(function () {
            let price = $('#price').val();
            let price2 = $('#price2').val();
            let pricec = $('#pricec').val();
            // if(pricec == 30){
            //     alert(30);
            // }
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

            $("#count, #countc, #date").change(function () {
                let price = $('#price').val();
                let price2 = $('#price2').val();
                let age1 = <?php echo $_GET['age1'];?>;
                let age2 = <?php echo $_GET['age2'];?>;
                let age3 = <?php echo $_GET['age3'];?>;

                let count = $('#count').val();
                let countc = $('#countc').val();
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
        });

    </script>

@endsection

