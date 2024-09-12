@extends('auth.layouts.master')

@section('title', 'Пользователи')

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <p class="alert alert-success">{{ session()->get('success') }}</p>
                    @endif
                    @if(session()->has('warning'))
                        <p class="alert alert-warning">{{ session()->get('warning') }}</p>
                    @endif
                    <div class="row">
                        <div class="col-md-7">
                            <h1>@lang('admin.users')</h1>
                        </div>
                        <div class="col-md-5">
                            <a class="btn add" href="{{ route('users.create') }}"><i class="fa-solid fa-plus"></i>
                                @lang('admin.add')</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>@lang('admin.name')</th>
                            <th>@lang('admin.role')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user) }}" method="post">
                                        <ul>
                                            <li><a class="btn edit" href="{{ route('users.edit', $user)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn delete"><i class="fa-regular fa-trash"></i></button>
                                        </ul>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
