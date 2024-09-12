@extends('auth/layouts.master')

@section('title', 'Главная')

@section('content')

    <div class="page admin dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth/layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <p class="alert alert-success">{{ session()->get('success') }}</p>
                    @endif
                    @if(session()->has('warning'))
                        <p class="alert alert-warning">{{ session()->get('warning') }}</p>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="sliders">
                                <h2>Слайды</h2>
                                <p>Количество слайдов: {{ $sliders->count() }}</p>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Изображение</th>
                                        <th>Название</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <td><img src="{{ Storage::url($slider->image) }}" alt=""></td>
                                            <td>{{ $slider->title }}</td>
                                            <td>
                                                <form action="{{ route('sliders.destroy', $slider) }}" method="post">
                                                    <ul>
                                                        <li><a class="btn edit" href="{{ route('sliders.edit', $slider)
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
                                <a class="btn add" href="{{ route('sliders.create') }}"><i class="fa-solid
                                fa-plus"></i> Добавить слайд</a>
                                {{ $sliders->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
