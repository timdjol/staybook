@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Edit ' . $category->title)
@else
    @section('title', 'Add Room')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($category)
                        <h1>@lang('admin.edit') {{ $category->title }}</h1>
                    @else
                        <h1>Add CategoryRoom</h1>
                    @endisset
                    <form method="post"
                          @isset($category)
                              action="{{ route('categories.update', $category) }}"
                          @else
                              action="{{ route('categories.store') }}"
                            @endisset
                    >
                        @isset($category)
                            @method('PUT')
                        @endisset
                        <input type="hidden" value="{{ $hotel }}" name="hotel_id">
                        <div class="row">
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'title'])
                                <div class="form-group">
                                    <label for="">@lang('admin.title')</label>
                                    <input type="text" name="title" value="{{ old('title', isset($category) ?
                                    $category->title :
                             null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'title_en'])
                                <div class="form-group">
                                    <label for="">@lang('admin.title') EN</label>
                                    <input type="text" name="title_en" value="{{ old('title_en', isset($category) ?
                                $category->title_en :
                             null) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Select room</label>
                                    <select name="room_id">
                                        @isset($category)
                                            <option @if($category->room_id)
                                                        selected>
                                                {{ $category->room_id }}</option>
                                        @else
                                            <option>Choose</option>
                                        @endif
                                        @endisset
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    @include('auth.layouts.error', ['fieldname' => 'bed'])--}}
{{--                                    <label for="bed">@lang('admin.bed')</label>--}}
{{--                                    <select name="bed" id="bed">--}}
{{--                                        @isset($room)--}}
{{--                                            <option @if($room->bed)--}}
{{--                                                        selected>--}}
{{--                                                {{ $room->bed }}</option>--}}
{{--                                        @else--}}
{{--                                            <option>Choose</option>--}}
{{--                                        @endif--}}
{{--                                        @endisset--}}
{{--                                        <option value="Single">Single</option>--}}
{{--                                        <option value="Double">Double</option>--}}
{{--                                        <option value="Separate">Separate</option>--}}
{{--                                        <option value="King Size">King Size</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        @csrf
                        <button class="more">@lang('admin.send')</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">@lang('admin.cancel')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .admin label {
            display: inline-block;
        }
    </style>

@endsection
