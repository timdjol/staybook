@extends('layouts.master')

@section('title', 'Search Room Stay')

@section('content')

    <div class="pagetitle">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">Search Room Stay</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>Search Room Stays</li>
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
                        @foreach($rooms as $room)
                            <div class="col-md-4 property-item">
                                <h5>{{ $room->fullPlacementsName }}</h5>
                                <ul>
                                    <li>{{ $room->propertyId }}</li>
                                    <li>{{ $room->roomType->placements[0]->kind }} : {{ $room->roomType->placements[0]->count }}</li>
                                    <li>Guest Count: {{ $room->guestCount->adultCount }}</li>
                                    <li>Arrival Time: {{ $room->stayDates->arrivalDateTime }}</li>
                                    <li>Departure Time: {{ $room->stayDates->departureDateTime }}</li>
                                    <li>Availability: {{ $room->availability }}</li>
                                    <li>Total: {{ $room->total->priceBeforeTax }}</li>
                                    <li>CancellationPolicy: {{ $room->cancellationPolicy->penaltyAmount }}</li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
