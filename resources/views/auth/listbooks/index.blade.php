@extends('auth.layouts.master')

@section('title', 'Bookings')

@section('content')

    <div class="page admin bookings">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if($books->isNotEmpty())
                        <form>
                            <div class="form-group">
                                <input type="text" name="search" id="search" placeholder="@lang('admin.search')"
                                       class="form-control"
                                       onfocus="this.value=''">
                            </div>
                        </form>

                        <h1>@lang('admin.bookings')</h1>
                        <div id="search_list"></div>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.booking')</th>
                                <th>@lang('admin.guests')</th>
                                <th>@lang('admin.plans')</th>
                                <th>@lang('admin.dates_of_stay')</th>
                                <th>@lang('admin.price')</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $book->id }}</td>
                                    <td>
                                        <div class="title"># {{ $book->book_id }}</div>
                                        <div class="stick">B2B</div>
                                        <div class="date">@lang('admin.created') {{ $book->created_at }}</div>
                                    </td>
                                    <td>
                                        <div class="title">{{ $book->title }}</div>
                                        <div class="count">{{ $book->count }} @lang('admin.adult')</div>
                                        @if($book->countc > 0)
                                            <div class="count">{{ $book->countc }} @lang('admin.child')</div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $room = \App\Models\Room::where('id', $book->room_id)->first();
                                            $plan = \App\Models\Category::where('room_id', $book->room_id)->first();
                                        @endphp
                                        <div class="title">{{ $room->__('title') }}</div><br>
                                        @isset($plan)
                                            <div class="title">{{ $plan->__('title') }}</div>
                                        @endisset
                                    </td>
                                    <td>{{ $book->showStartDate() }} - {{ $book->showEndDate() }}</td>
                                    <td>
                                        <div class="title">{{ $book->sum }}</div>
                                        <div class="status"><i class="fa-regular fa-money-bill"></i> {{ $book->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('listbooks.destroy', $book) }}" method="post">
                                            <ul>
                                                <a href="{{ route('listbooks.show', $book)}}" class="more"><i
                                                            class="fa-regular fa-eye"></i></a>
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
                    @else
                        <h2 style="text-align: center">@lang('admin.bookings_not_found')</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                var query = $(this).val();
                $.ajax({
                    url: "searchbook",
                    type: "GET",
                    data: {'search': query},
                    success: function (data) {
                        $('#search_list').html(data);
                    }
                });
                //end of ajax call
            });
        });
    </script>

@endsection
