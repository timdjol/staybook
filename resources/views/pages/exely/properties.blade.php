@extends('layouts.master')

@section('title', 'Properties')

@section('content')

    <div class="pagetitle">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">Properties</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>Properties</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk="
            crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
          integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous"/>

    <div class="page property search homesearch">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('search_property') }}">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">Название отеля</label>
                                    <select name="title" id="hotel">
                                        <option value="">@lang('main.choose')</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}">{{ $hotel->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">Название города</label>
                                    <select name="city" id="city">
                                        <option value="">@lang('main.choose')</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->contactInfo->address->cityId }}">{{ $hotel->contactInfo->address->cityName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">@lang('main.search-date')</label>
                                    <input type="text" id="date" class="date">
                                    <input type="hidden" id="start_d" name="arrivalDate">
                                    <input type="hidden" id="end_d" name="departureDate">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <script>
                                $(document).ready(function () {
                                    $('#hotel').selectize({
                                        sortField: 'text'
                                    });
                                    $('#city').selectize({
                                        sortField: 'text'
                                    });
                                });
                            </script>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">@lang('main.search-adult')</label>
                                    <select name="adult" id="">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="position: relative">
                                    <label for="">@lang('main.search-child')</label>
                                    <select name="countc" onchange="ageCheck(this);">
                                        <option value="">@lang('main.choose')</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <select name="age1" id="age1" class="age">
                                        <option value="0">@lang('main.choose')</option>
                                        <option value="1">1 год</option>
                                        <option value="2">2 года</option>
                                        <option value="3">3 года</option>
                                        <option value="4">4 года</option>
                                        <option value="5">5 лет</option>
                                        <option value="6">6 лет</option>
                                        <option value="7">7 лет</option>
                                        <option value="8">8 лет</option>
                                        <option value="9">9 лет</option>
                                        <option value="10">10 лет</option>
                                        <option value="11">11 лет</option>
                                        <option value="12">12 лет</option>
                                        <option value="13">13 лет</option>
                                        <option value="14">14 лет</option>
                                        <option value="15">15 лет</option>
                                        <option value="16">16 лет</option>
                                        <option value="17">17 лет</option>
                                    </select>
                                    <select name="age2" id="age2" class="age">
                                        <option value="0">@lang('main.choose')</option>
                                        <option value="1">1 год</option>
                                        <option value="2">2 года</option>
                                        <option value="3">3 года</option>
                                        <option value="4">4 года</option>
                                        <option value="5">5 лет</option>
                                        <option value="6">6 лет</option>
                                        <option value="7">7 лет</option>
                                        <option value="8">8 лет</option>
                                        <option value="9">9 лет</option>
                                        <option value="10">10 лет</option>
                                        <option value="11">11 лет</option>
                                        <option value="12">12 лет</option>
                                        <option value="13">13 лет</option>
                                        <option value="14">14 лет</option>
                                        <option value="15">15 лет</option>
                                        <option value="16">16 лет</option>
                                        <option value="17">17 лет</option>
                                    </select>
                                    <select name="age3" id="age3" class="age">
                                        <option value="0">@lang('main.choose')</option>
                                        <option value="1">1 год</option>
                                        <option value="2">2 года</option>
                                        <option value="3">3 года</option>
                                        <option value="4">4 года</option>
                                        <option value="5">5 лет</option>
                                        <option value="6">6 лет</option>
                                        <option value="7">7 лет</option>
                                        <option value="8">8 лет</option>
                                        <option value="9">9 лет</option>
                                        <option value="10">10 лет</option>
                                        <option value="11">11 лет</option>
                                        <option value="12">12 лет</option>
                                        <option value="13">13 лет</option>
                                        <option value="14">14 лет</option>
                                        <option value="15">15 лет</option>
                                        <option value="16">16 лет</option>
                                        <option value="17">17 лет</option>
                                    </select>
                                    <script>
                                        function ageCheck(that) {
                                            if (that.value == 1) {
                                                document.getElementById("age1").style.display = "inline-block";
                                                document.getElementById("age2").style.display = "none";
                                                document.getElementById("age3").style.display = "none";
                                            }
                                            else if (that.value == 2) {
                                                document.getElementById("age1").style.display = "inline-block";
                                                document.getElementById("age2").style.display = "inline-block";
                                                document.getElementById("age3").style.display = "none";
                                            }
                                            else if (that.value == 3) {
                                                document.getElementById("age1").style.display = "inline-block";
                                                document.getElementById("age2").style.display = "inline-block";
                                                document.getElementById("age3").style.display = "inline-block";
                                            }
                                            else {
                                                document.getElementById("age1").style.display = "none";
                                                document.getElementById("age2").style.display = "none";
                                                document.getElementById("age3").style.display = "none";
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="more">@lang('main.search')</button>
                                </div>
                            </div>
                            <div class="col">
                                <a href="{{ route('properties') }}">Reset</a>
                            </div>
                        </div>

                    </form>
                    <style>
                        .homesearch form button.more:hover {
                            background-color: #035497;
                            color: #fff;
                        }
                        select.age{
                            position: relative;
                            left: 0;
                            bottom: -5px;
                            height: 30px;
                            width: 32%;
                            padding: 0;
                            display: none;
                        }
                        .selectize-input {
                            height: 50px;
                            padding: 5px 15px;
                        }
                        .selectize-input > input {
                            height: 50px;
                            top: -5px;
                            position: relative;
                        }
                        .selectize-input > * {
                            position: relative;
                            top: 10px;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

        <div class="page">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        @include('pages.exely.sidebar')
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            @foreach($properties as $property)
                                <div class="col-lg-4">
                                    <div class="property-item">
                                        <img src="{{ $property->images[0]->url }}" alt="">
                                        <h4>{{ $property->name}}</h4>
                                        <p>{{ Str::limit($property->description, 100) }}</p>
                                        <p>Stars: {{ $property->stars }}</p>
                                        <div class="address">{{ $property->contactInfo->address->addressLine }}</div>
                                        <div class="btn-wrap" style="margin-top: 20px">
                                            <a href="{{ route('property', $property->id) }}" class="more">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
