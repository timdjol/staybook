@extends('auth.layouts.master')

@section('title', 'Бронь ' . $book->title)

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-12 modal-content">
                    <h1>@lang('admin.booking') #{{ $book->book_id }}</h1>
                    <div class="print">
                        <a href="javascript:window.print();"><i class="fa-regular fa-print"></i>
                            @lang('admin.print')</a>
                    </div>
                    <div class="download">
                        <a href="{{ route('pdf', $book->id) }}"><i class="fa-regular fa-download"></i> @lang('admin.download')</a>
                    </div>
                    <div class="row wrap">
                        <div class="dashboard-item">
                            <div class="name">@lang('admin.booking_made_on') {{ $book->created_at }}</div>
                        </div>
{{--                        <div class="col-md-4">--}}
{{--                            <div class="dashboard-item">--}}
{{--                                <div class="name">ID</div>--}}
{{--                                <span># {{ $book->id }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.guests')</div>
                                {{ $book->title }}<br>
                                @isset($book->title2)
                                    {{ $book->title2 }}<br>
                                @endisset
                                @isset($book->titlec1)
                                    {{ $book->titlec1 }} - ({{$book->age1}})<br>
                                @endisset
                                @isset($book->titlec2)
                                    {{ $book->titlec2 }} - ({{$book->age2}})<br>
                                @endisset
                                @isset($book->titlec3)
                                    {{ $book->titlec3 }} - ({{$book->age3}})
                                @endisset
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.count')</div>
                                <div>{{ $book->count }} @lang('admin.adult')</div>
                                @if($book->countc > 0)
                                    <div>{{ $book->countc }} @lang('admin.child')</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.phone')</div>
                                <div>{{ $book->phone }}</div>
                            </div>
                            <div class="dashboard-item">
                                <div class="name">Email</div>
                                <div>{{ $book->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                @php
                                    $room = \App\Models\Category::where('id', $book->room_id)->firstOrFail();
                                @endphp
                                <div class="img"><img src="{{ Storage::url($room->image) }}"
                                                      alt="" width="200px"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.hotel')</div>
                                <div class="wrap">
                                    {{ $room->hotel_id }}
                                    <div class="name" style="margin-top: 20px">@lang('admin.room')</div>
                                    {{ $room->title }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.dates_of_stay')</div>
                                {{ $book->showStartDate() }} - {{ $book->showEndDate() }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name">@lang('admin.price')</div>
                                {{ $book->sum }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-item">
                                <div class="name" style="margin-top: 20px">@lang('admin.status')</div>
                                <div class="status"><i class="fa-regular fa-money-bill"></i>
                                    {{ $book->status }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
