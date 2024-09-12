@extends('auth.layouts.buh.master')

@section('title', 'Отели')

@section('content')

    234

    <div class="page admin mainhotels">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        @foreach($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->id }}</td>
                                <td>{{ $hotel->title }}</td>
                                <td>{{ $hotel->address }}</td>
                                <td>
                                    <form action="{{ route('hotels.destroy', $hotel) }}" method="post">
                                        <ul>
                                            <a href="{{ route('hotels.show', $hotel) }}" class="more"><i class="fa-regular
                                fa-pen-to-square"></i> Choose</a>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn delete"><i class="fa-regular fa-trash"></i></button>
                                        </ul>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $hotels->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
