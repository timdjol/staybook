@extends('layouts.master')

@section('title', 'Amenities')

@section('content')

    <div class="pagetitle">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">Amenities</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>Amenities</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page property">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('pages.exely.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @foreach($amenities as $amenity)
                            <div class="col-md-6">
                                <h5>{{ $amenity->name }}</h5>
                                <ul>
                                    @foreach($amenity->amenities as $item)
                                        <li>{{ $item->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
