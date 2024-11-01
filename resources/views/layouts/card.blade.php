<div class="row rooms-item">
    <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="2000">
        <a href="{{ route('room', [isset($hotel) ? $hotel->code : $room->hotel->code, $room->code])}}">
            <div class="img" style="background-image: url({{ Storage::url($room->image) }})"></div>
        </a>
    </div>
    <div class="col-lg-6 col-md-6">
        @isset($room->hotel)
            <div class="start">@lang('main.start_d') {{ $room->hotel->checkin }}</div>
            <div class="end">@lang('main.end_d') {{ $room->hotel->checkout }}</div>
            <div class="title">{{ $room->hotel->__('title') }}</div>
            <h3>{{ $room->__('title') }}</h3>
            <div class="address">{{ $room->hotel->__('address') }}</div>
            <div class="d-xl-none d-lg-none d-block">
                <div class="price">
                    @php
                        //$comission = \Illuminate\Support\Facades\Auth::user()->comission;
                        //$comission = 10;
                        $c = \App\Models\Category::where('room_id', $room->id)->first();
                    @endphp
                    @isset($c)
                        <td>
                            $ {{ $c->price }}
                        </td>
                    @endisset
                    </div>
                    @if($room->include != '')
                        <div class="breakfast">{{ $room->include }}</div>
                    @endif
                </div>
                <div class="btn-wrap">
                    <a href="{{ route('room', [isset($hotel) ? $hotel->code : $room->hotel->code, $room->code])
                }}" class="more">@lang('main.more')</a>
                </div>
            @endisset
        </div>
        <div class="col-lg-2 d-xl-block d-lg-block d-none" data-aos="fade-left" data-aos-duration="2000">
            <div class="price">
                @php
                    //$comission = \Illuminate\Support\Facades\Auth::user()->comission;
            @endphp
                @isset($c)
                    <td>
                        $ {{ $c->price }}
                    </td>
                @endisset
        </div>
        @if($room->include != null || $room->include != '' )
            <div class="breakfast">{{ $room->include }}</div>
        @endif
        @if($room->hotel->early_in ?? '')
            <div class="early">@lang('main.early')</div>
        @endif
        @if($room->hotel->early_out ?? '')
            <div class="early">@lang('main.late')</div>
        @endif
        @if($room->hotel->cancelled ?? '')
            @isset($end)
                @php
                    $end = $_GET['end_d'] ?? null;
                    $date = \Carbon\Carbon::parse($end);
                    $date->locale('ru');
                    $exp = $date->subDays($room->cancel_day);
                    $month = $exp->getTranslatedMonthName('Do MMMM');
                    $get = $exp->day . ' ' . $month;
                @endphp
                <div class="early">@lang('main.cancelled') до {{ $get }} </div>
            @endisset
        @endif
    </div>
</div>
