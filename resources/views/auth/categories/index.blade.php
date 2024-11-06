@extends('auth.layouts.master')

@section('title', __('admin.plans_and_rules'))

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('auth.layouts.subroom')
                    <h1>@lang('admin.plans_and_rules')</h1>
                    @if($rules->isNotEmpty())
                        <h3>@lang('admin.rules')</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rules as $rule)
                                <tr>
                                    <td>{{ $rule->id }}</td>
                                    <td>{{ $rule->title }}</td>
                                    <td>
                                        <form action="{{ route('rules.destroy', $rule) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('rules.edit', $rule)
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
                        {{ $rules->links('pagination::bootstrap-4') }}

                    @else
                        <h2 style="text-align: center">@lang('admin.rooms_not_found')</h2>
                    @endif
                    <div class="btn-wrap">
                        <a class="btn add" href="{{ route('rules.create') }}"><i class="fa-solid
                                fa-plus"></i> @lang('admin.add')</a>
                    </div>

                    @if($categories->isNotEmpty())
                        <h3>@lang('admin.plans')</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.room')</th>
                                <th>@lang('admin.food')</th>
                                <th>@lang('admin.rules')</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->room->title }}</td>
                                    <td>{{ $category->food->title }}</td>
                                    <td>{{ $category->rule->title }}</td>
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
                    <div class="btn-wrap">
                        <a class="btn add" href="{{ route('categories.create') }}"><i class="fa-solid
                                fa-plus"></i> @lang('admin.add')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
