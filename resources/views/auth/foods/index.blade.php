@extends('auth.layouts.master')

@section('title', __('admin.foods'))

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center aic">
                        <div class="col-md-7">
                            <h1>@lang('admin.foods')</h1>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('foods.create') }}"><i class="fa-solid
                                fa-plus"></i> @lang('admin.add')</a>
                            </div>
                        </div>
                    </div>

                    @if($foods->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.title')</th>
                                <th>EN</th>
                                <th>@lang('admin.room')</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($foods as $food)
                                <tr>
                                    <td>{{ $food->id }}</td>
                                    <td>{{ $food->title }}</td>
                                    <td>{{ $food->title_en }}</td>
                                    <td>{{ $food->room->title }}</td>
                                    <td>
                                        <form action="{{ route('foods.destroy', $food) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('foods.edit', $food)
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
                        {{ $foods->links('pagination::bootstrap-4') }}
                    @else
                        <h2 style="text-align: center">@lang('admin.rooms_not_found')</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
