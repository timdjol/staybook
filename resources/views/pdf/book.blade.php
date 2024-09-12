<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <title>StayBook</title>
</head>
<body>

<style>
    body {
        font-family: DejaVu Sans
    }

    table {
        width: 100%;
    }

    table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="page admin">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table>
                    <tr>
                        <td>
                            <div class="logo"><img src="{{ public_path("img/logo.png") }}" width="120px"
                                                   alt="Logo"></div>
                        </td>
                        <td>
                            <div class="phone"><a href="0999999999">0999999999</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @php
                                $hotel = \App\Models\Hotel::where('id', $book->hotel_id)->firstOrFail();
                            @endphp
                            {{ $hotel->title }}<br>
                            {{ $hotel->address }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Guest</td>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td>Meal</td>
                        <td>
                            @php
                                $room = \App\Models\Room::where('id', $book->room_id)->firstOrFail();
                            @endphp
                            {{ $room->include }}
                        </td>
                    </tr>
                    <tr>
                        <td>Check In</td>
                        <td>{{ $book->showStartDate() }} from {{ $hotel->checkin }}</td>
                    </tr>
                    <tr>
                        <td>Check Out</td>
                        <td>{{ $book->showEndDate() }} until {{ $hotel->checkout }}</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ storage_path('app/public/'.$room->image) }}" width="220px" alt="Logo">
                        </td>
                        <td>{{ $room->title }}</td>
                    </tr>
                    <tr>
                        <td>ID</td>
                        <td>{{ $book->book_id }}</td>
                    </tr>
                    <tr>
                        <td>Booking made on</td>
                        <td>{{ $book->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Payment type</td>
                        <td>{{ $book->status }}</td>
                    </tr>
                    <tr>
                        <td>Rate</td>
                        <td>B2B</td>
                    </tr>
                    <tr>
                        <td>Beddings</td>
                        <td>{{ $room->bed }}</td>
                    </tr>
                    <tr>
                        <td>Free cancellation</td>
                        <td>
                            @php
                                $date = \Carbon\Carbon::parse($book->end_d);
                                //$date->locale('ru');
                                $exp = $date->subDays($room->cancel_day);
                                $month = $exp->getTranslatedMonthName('Do MMMM');
                                $get = $exp->day . ' ' . $month;
                            @endphp
                            until {{ $get }}
                        </td>
                    </tr>
                    <tr>
                        <td>Meal price</td>
                        <td>Included</td>
                    </tr>
                    <tr>
                        <td>Accommodation price</td>
                        <td>{{ $book->sum }}</td>
                    </tr>
                    <tr>
                        <td>Price per day</td>
                        <td>{{ $room->price }} $</td>
                    </tr>
                </table>
            </div>
        </div>

        {{--        <div class="row">--}}
        {{--            <div class="col-md-12 modal-content">--}}

        {{--                <div class="date">Дата создания: {{ $date }}</div>--}}
        {{--                <h1>Бронь #{{ $book->id }}</h1>--}}

        {{--                <div class="row wrap">--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">ID</div>--}}
        {{--                            <span># {{ $book->id }}</span>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">ФИО</div>--}}
        {{--                            {{ $book->title }} <br>--}}
        {{--                            @isset($book->title2)--}}
        {{--                                {{ $book->title2 }}<br>--}}
        {{--                            @endisset--}}
        {{--                            @isset($book->titlec1)--}}
        {{--                                {{ $book->titlec1 }} - ({{$book->age1}})<br>--}}
        {{--                            @endisset--}}
        {{--                            @isset($book->titlec2)--}}
        {{--                                {{ $book->titlec2 }} - ({{$book->age2}})<br>--}}
        {{--                            @endisset--}}
        {{--                            @isset($book->titlec3)--}}
        {{--                                {{ $book->titlec3 }} - ({{$book->age3}})--}}
        {{--                            @endisset--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Кол-во</div>--}}
        {{--                            <div>{{ $book->count }} взрос.</div>--}}
        {{--                            @if($book->countc > 0)--}}
        {{--                                <div>{{ $book->countc }} дет.</div>--}}
        {{--                            @endif--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Дата заезда/выезда</div>--}}
        {{--                            {{ $book->showStartDate() }} - {{ $book->showEndDate() }}--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="col-md-4">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            @php--}}
        {{--                                $room = \App\Models\Room::where('id', $book->room_id)->firstOrFail();--}}
        {{--                            @endphp--}}
        {{--                            <div class="img" style="margin-top: 40px"><img src="{{ storage_path('app/public/'--}}
        {{--                            .$room->image) }}"--}}
        {{--                                alt="Logo" style="width: 200px; height: 150px;"></div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-4">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Отель</div>--}}
        {{--                            <div class="title">{{ $room->hotel->title }}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-4">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Номер</div>--}}
        {{--                            <div class="title">{{ $room->title }}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Стоимость</div>--}}
        {{--                            <div class="title">{{ $book->sum }}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="dashboard-item">--}}
        {{--                            <div class="name">Статус</div>--}}
        {{--                            <div class="status" style="color: green"><i class="fa-regular fa-money-bill"></i>--}}
        {{--                                Оплачено--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
</div>

</body>
</html>