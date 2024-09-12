@extends('auth.layouts.master')

@isset($user)
    @section('title', 'Редактировать пользователя' . $user->name)
@else
    @section('title', 'Создать пользователя')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($user)
                        <h1>@lang('admin.edit_user') {{ $user->title }}</h1>
                    @else
                        <h1>@lang('admin.add_user')</h1>
                    @endisset
                    <form method="post"
                          @isset($user)
                              action="{{ route('users.update', $user) }}"
                          @else
                              action="{{ route('users.store') }}"
                            @endisset
                    >
                        @isset($user)
                            @method('PUT')
                        @endisset
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="name">@lang('admin.name')</label>
                            <input type="text" name="name" id="name" value="{{ old('name', isset($user) ? $user->name :
                             null) }}">
                        </div>
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', isset($user) ?
                                $user->email : null) }}">
                        </div>
                        @isset($user)
                        @else
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="password">@lang('admin.password')</label>
                                <input type="password" name="password" id="password" value="{{ old('password', isset
                            ($user) ?
                                $user->password : null) }}">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox"><label for="checkbox">@lang('admin.show_password')
                                    </label>
                                </div>
                                <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                                        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
                                        crossorigin="anonymous"></script>
                                <script>
                                    $(document).ready(function () {
                                        $('#checkbox').on('change', function () {
                                            $('#password').attr('type', $('#checkbox').prop('checked') == true ? "text" : "password");
                                        });
                                    });
                                </script>

                                <style>
                                    .checkbox {
                                        margin-top: 10px;
                                    }

                                    .checkbox label {
                                        display: inline-block;
                                    }
                                </style>
                            </div>
                        @endisset

                        <div class="form-group">
                            <label for="role">@lang('admin.role')</label>
                            <select name="is_admin" id="role">
                                @isset($user)
                                    <option value="{{ $user->is_admin }}">
                                        @if($user->is_admin == 1)
                                            Администратор
                                        @elseif($user->is_admin == 2)
                                            Менеджер
                                        @elseif($user->is_admin == 3)
                                            Бухгалтер
                                        @elseif($user->is_admin == 4)
                                            Менеджер Отеля
                                        @else
                                            Пользователь
                                        @endif
                                    </option>
                                @else
                                    <option>@lang('admin.choose')</option>
                                @endisset
                                <option value="1">Администратор</option>
                                <option value="2">Менеджер</option>
                                <option value="3">Бухгалтер</option>
                                <option value="4">Менеджер Отеля</option>
                            </select>
                        </div>
                        @csrf
                        <button class="more">@lang('admin.send')</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">@lang('admin.cancel')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
