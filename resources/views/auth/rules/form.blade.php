@extends('auth.layouts.master')

@isset($rule)
    @section('title', __('admin.edit') . ' ' . $rule->title)
@else
    @section('title', __('admin.add'))
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($rule)
                        <h1>@lang('admin.edit') {{ $rule->title }}</h1>
                    @else
                        <h1>@lang('admin.add')</h1>
                    @endisset
                    <form method="post"
                          @isset($category)
                              action="{{ route('rules.update', $rule) }}"
                          @else
                              action="{{ route('rules.store') }}"
                            @endisset
                    >
                        @isset($rule)
                            @method('PUT')
                        @endisset
                        <input type="hidden" value="{{ $hotel }}" name="hotel_id">
                        <div class="row">
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'title'])
                                <div class="form-group">
                                    <label for="">@lang('admin.title')</label>
                                    <input type="text" name="title" value="{{ old('title', isset($rule) ?
                                    $rule->title :
                             null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'title_en'])
                                <div class="form-group">
                                    <label for="">@lang('admin.title') EN</label>
                                    <input type="text" name="title_en" value="{{ old('title_en', isset($rule) ?
                                $rule->title_en :
                             null) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('admin.choose')</label>
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
