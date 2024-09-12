@extends('auth.layouts.master')

@section('title', 'Categories of rooms')

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center aic">
                        <div class="col-md-7">
                            <h1>Categories of rooms</h1>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('categories.create') }}"><i class="fa-solid
                                fa-plus"></i> @lang('admin.add_room')</a>
                            </div>
                        </div>
                    </div>

                    @if($categories->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.room')</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->room->title }}</td>
                                    <td>
                                        <form action="{{ route('categories.destroy', $category) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('categories.edit', $category)
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
                        {{ $categories->links('pagination::bootstrap-4') }}
                    @else
                        <h2 style="text-align: center">@lang('admin.rooms_not_found')</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
