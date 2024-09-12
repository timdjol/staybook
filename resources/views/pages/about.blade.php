@extends('layouts.master')

@section('title', 'Об отеле')

@section('content')

    <div class="pagetitle" style="background-image: url({{ Storage::url($page->image) }})">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="fade-up" data-aos-duration="2000">{{ $page->__('title') }}</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li>></li>
                        <li>{{ $page->__('title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12">
                    {!! $page->__('description') !!}
                </div>
            </div>
        </div>
    </div>


@endsection
