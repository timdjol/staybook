@extends('auth.layouts.master')

@isset($child)
    @section('title', __('admin.edit'))
@else
    @section('title', __('admin.add'))
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @include('auth.layouts.subroom')
                    @isset($child)
                        <h1>@lang('admin.edit') {{ $child->title }}</h1>
                    @else
                        <h1>@lang('admin.add')</h1>
                    @endisset
                    <form method="post"
                          @isset($category)
                              action="{{ route('childs.update', $child) }}"
                          @else
                              action="{{ route('childs.store') }}"
                            @endisset
                    >
                        @isset($child)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'room_id'])
                                <div class="form-group">
                                    <label for="">@lang('admin.room')</label>
                                    <select name="room_id">
                                        @isset($category)
                                            <option @if($category->room_id)
                                                        selected>
                                                {{ $category->room->title }}</option>
                                        @else
                                            <option>@lang('admin.choose')</option>
                                        @endif
                                        @endisset
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->__('title') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('auth.layouts.error', ['fieldname' => 'type'])
                                <div class="form-group">
                                    <label for="">@lang('admin.child_type')</label>
                                    <input type="text" name="type" value="{{ old('title_en', isset($child) ?
                                $child->title_en :
                             null) }}">
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
