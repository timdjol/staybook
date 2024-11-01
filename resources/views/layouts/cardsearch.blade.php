<div class="row rooms-item">
    <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-duration="2000">
        <a href="{{ route('room', [isset($hotel) ? $hotel->code ?? '' : $room->hotel->code ?? '', $room->code])}}">
            <div class="img" style="background-image: url({{ Storage::url($room->image) }})"></div>
        </a>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="start">@lang('main.start_d') {{ $room->hotel->checkin ?? '' }}</div>
        <div class="end">@lang('main.end_d') {{ $room->hotel->checkout ?? '' }}</div>
        <div class="title">{{ $room->hotel->__('title') ?? '' }}</div>
        <h3>{{ $room->__('title') ?? '' }}</h3>
        <div class="address">{{ $room->hotel->__('address') ?? '' }}</div>
        <div class="d-xl-none d-lg-none d-block">
            <div class="price">
                @php
                    //$comission = \Illuminate\Support\Facades\Auth::user()->comission;
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
            <a href="{{ route('room', [isset($hotel) ? $hotel->code ?? '' : $room->hotel->code ?? '', $room->code])
            }}" class="more">@lang('main.more')</a>
            <a href="#" class="book-item more">@lang('main.book')
                <div class="hidden">
                    <div class="book-popup">
                        <form action="{{ route('book_mail') }}" method="post"
                              id="callback"
                              class="form-callback">
                            @csrf
                            <h3>@lang('main.book') {{ $room->__('title') ?? '' }} <br> {{ $room->hotel->__('title')
                            ?? ''
                            }}</h3>
                            <input type="hidden" name="room_id" value="{{ $room->id}}">
                            <input type="hidden" name="hotel_id" value="{{ $room->hotel->id ?? ''}}">
                            @if($start_d != '' && $end_d != '')
                                <input type="hidden" id="start_d" name="start_d"
                                       value="{{ $start_d }}">
                                <input type="hidden" id="end_d" name="end_d"
                                       value="{{ $end_d }}">
                            @else
                                <div class="form-group">
                                    <label class="col-xs-4" for="end_d">@lang('main.date')</label>
                                    <input type="text" id="date">
                                    <input type="hidden" id="start_d"
                                           @php
                                           $now = \Carbon\Carbon::now();
                                               $date = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
                                              //$date = date('Y-m-d H:s:i');
                                             @endphp
                                           name="start_d" value="{{ date('Y-m-d H:s:i') }}">
                                    <input type="hidden" id="end_d" name="end_d" value="{{ $date->addDays(1) }}">
                                </div>
                            @endif

                            @if($count == 1)
                                <div class="form-group">
                                    <label class="col-xs-4" for="title">@lang('main.adult_name1')</label>
                                    <input type="text" class="form-control" name="title"
                                           id="title"
                                    />
                                </div>
                                <input type="hidden" name="count" value="{{ $count }}">
                            @elseif($count == 2)
                                <input type="hidden" name="count" value="{{ $count }}">
                                <div class="form-group">
                                    <label class="col-xs-4" for="title">@lang('main.adult_name1')</label>
                                    <input type="text" class="form-control" name="title"
                                           id="title"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="title2">@lang('main.adult_name2')</label>
                                    <input type="text" class="form-control" name="title2"
                                           id="title2"/>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="col-xs-4" for="count">@lang('main.search-count')</label>
                                    <select name="count" id="count" onchange="countCheck(this);" required>
                                        <option value="">@lang('main.choose')</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>

                                <div class="form-group" id="title">
                                    <label class="col-xs-4" for="title">@lang('main.adult_name1')</label>
                                    <input type="text" class="form-control" name="title"
                                           id="title" required/>
                                </div>
                                <div class="form-group" id="title2">
                                    <label class="col-xs-4" for="title2">@lang('main.adult_name2')</label>
                                    <input type="text" class="form-control" name="title2"/>
                                </div>
                            @endif

                            @if($countc == 1)
                                <input type="hidden" name="countc" class="countc" id="countc" value="{{ $countc }}">
                                <input type="hidden" name="age1" value="{{ $age1 }}">
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec1">@lang('main.child_name1') ({{ $age1 }})
                                    </label>
                                    <input type="text" class="form-control" name="titlec1"
                                           id="titlec1"/>
                                </div>
                            @elseif($countc == 2)
                                <input type="hidden" name="countc" class="countc" id="countc" value="{{ $countc }}">
                                <input type="hidden" name="age1" value="{{ $age1 }}">
                                <input type="hidden" name="age2" value="{{ $age2 }}">
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec1">@lang('main.child_name1') ({{ $age1 }})
                                    </label>
                                    <input type="text" class="form-control" name="titlec1"
                                           id="titlec1"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec2">@lang('main.child_name2') ({{ $age2 }})
                                    </label>
                                    <input type="text" class="form-control" name="titlec2"
                                           id="titlec2"/>
                                </div>
                            @elseif($countc == 3)
                                <input type="hidden" name="countc" class="countc" id="countc" value="{{ $countc }}">
                                <input type="hidden" name="age1" value="{{ $age1 }}">
                                <input type="hidden" name="age2" value="{{ $age2 }}">
                                <input type="hidden" name="age3" value="{{ $age3 }}">
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec1">@lang('main.child_name1') ({{ $age1 }})</label>
                                    <input type="text" class="form-control" name="titlec1"
                                           id="titlec1" required/>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec2">@lang('main.child_name2') ({{ $age2 }})
                                    </label>
                                    <input type="text" class="form-control" name="titlec2"
                                           id="titlec2"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4" for="titlec3">@lang('main.child_name3') ({{ $age3 }})
                                    </label>
                                    <input type="text" class ="form-control" name="titlec3"
                                           id="titlec3"/>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="">@lang('main.count_child')</label>
                                    <select name="countc" class="countc" id="countc" onchange="ageCheck(this);">
                                        <option value="">@lang('main.choose')</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="row" id="child1">
                                    <div class="col-md-4">
                                        <select name="age1">
                                            <option value="@lang('main.1_year')">@lang('main.1_year')</option>
                                            <option value="@lang('main.2_year')">@lang('main.2_year')</option>
                                            <option value="@lang('main.3_year')">@lang('main.3_year')</option>
                                            <option value="@lang('main.4_year')">@lang('main.4_year')</option>
                                            <option value="@lang('main.5_year')">@lang('main.5_year')</option>
                                            <option value="@lang('main.6_year')">@lang('main.6_year')</option>
                                            <option value="@lang('main.7_year')">@lang('main.7_year')</option>
                                            <option value="@lang('main.8_year')">@lang('main.8_year')</option>
                                            <option value="@lang('main.9_year')">@lang('main.9_year')</option>
                                            <option value="@lang('main.10_year')">@lang('main.10_year')</option>
                                            <option value="@lang('main.11_year')">@lang('main.11_year')</option>
                                            <option value="@lang('main.12_year')">@lang('main.12_year')</option>
                                            <option value="@lang('main.13_year')">@lang('main.13_year')</option>
                                            <option value="@lang('main.14_year')">@lang('main.14_year')</option>
                                            <option value="@lang('main.15_year')">@lang('main.15_year')</option>
                                            <option value="@lang('main.16_year')">@lang('main.16_year')</option>
                                            <option value="@lang('main.17_year')">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec1"
                                                   id="titlec1" placeholder="@lang('main.child_name1')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="child2">
                                    <div class="col-md-4">
                                        <select name="age2">
                                            <option value="@lang('main.1_year')">@lang('main.1_year')</option>
                                            <option value="@lang('main.2_year')">@lang('main.2_year')</option>
                                            <option value="@lang('main.3_year')">@lang('main.3_year')</option>
                                            <option value="@lang('main.4_year')">@lang('main.4_year')</option>
                                            <option value="@lang('main.5_year')">@lang('main.5_year')</option>
                                            <option value="@lang('main.6_year')">@lang('main.6_year')</option>
                                            <option value="@lang('main.7_year')">@lang('main.7_year')</option>
                                            <option value="@lang('main.8_year')">@lang('main.8_year')</option>
                                            <option value="@lang('main.9_year')">@lang('main.9_year')</option>
                                            <option value="@lang('main.10_year')">@lang('main.10_year')</option>
                                            <option value="@lang('main.11_year')">@lang('main.11_year')</option>
                                            <option value="@lang('main.12_year')">@lang('main.12_year')</option>
                                            <option value="@lang('main.13_year')">@lang('main.13_year')</option>
                                            <option value="@lang('main.14_year')">@lang('main.14_year')</option>
                                            <option value="@lang('main.15_year')">@lang('main.15_year')</option>
                                            <option value="@lang('main.16_year')">@lang('main.16_year')</option>
                                            <option value="@lang('main.17_year')">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec2"
                                                   id="titlec2" placeholder="@lang('main.child_name2')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="child3">
                                    <div class="col-md-4">
                                        <select name="age3">
                                            <option value="@lang('main.1_year')">@lang('main.1_year')</option>
                                            <option value="@lang('main.2_year')">@lang('main.2_year')</option>
                                            <option value="@lang('main.3_year')">@lang('main.3_year')</option>
                                            <option value="@lang('main.4_year')">@lang('main.4_year')</option>
                                            <option value="@lang('main.5_year')">@lang('main.5_year')</option>
                                            <option value="@lang('main.6_year')">@lang('main.6_year')</option>
                                            <option value="@lang('main.7_year')">@lang('main.7_year')</option>
                                            <option value="@lang('main.8_year')">@lang('main.8_year')</option>
                                            <option value="@lang('main.9_year')">@lang('main.9_year')</option>
                                            <option value="@lang('main.10_year')">@lang('main.10_year')</option>
                                            <option value="@lang('main.11_year')">@lang('main.11_year')</option>
                                            <option value="@lang('main.12_year')">@lang('main.12_year')</option>
                                            <option value="@lang('main.13_year')">@lang('main.13_year')</option>
                                            <option value="@lang('main.14_year')">@lang('main.14_year')</option>
                                            <option value="@lang('main.15_year')">@lang('main.15_year')</option>
                                            <option value="@lang('main.16_year')">@lang('main.16_year')</option>
                                            <option value="@lang('main.17_year')">@lang('main.17_year')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="titlec3"
                                                   id="titlec3" placeholder="@lang('main.child_name3')"/>
                                        </div>
                                    </div>
                                </div>


                                <style>
                                    #title2, #child1, #child2, #child3 {
                                        display: none;
                                    }
                                </style>
                            @endif


                            <div class="form-group">
                                <label class="col-xs-4" for="phone">@lang('main.phone')</label>
                                <input type="number" class="form-control"
                                       name="phone" id="phone" required
                                >
                                <div id="output" class="output"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="email">Email</label>
                                <input type="email" class="form-control"
                                       name="email" id="email" required/>
                            </div>
                            {{--                            <input type="hidden" id="price" class="price" value="--}}
                            {{--                                                                @if(isset($comission))--}}
                            {{--                                                            {{ $room->price + ($room->price * $comission / 100) }}--}}
                            {{--                                                            @else--}}
                            {{--                                                            {{ $room->price }}--}}
                            {{--                                                        @endif">--}}
                            <input type="hidden" id="price" class="price" value="{{ $room->price }}">
                            <input type="hidden" id="price2" class="price2" value="{{ $room->price2 }}">
                            <input type="hidden" id="count" class="count" value="{{ $count }}">
                            <input type="hidden" id="countc" class="countc" value="{{ $countc }}">
                            <div class="form-group">
                                <label for="">@lang('main.sum')</label>
                                <input type="text" id="sum" name="sum" class="sum" readonly>
                            </div>
                            <button class="more" id="saveBtn">@lang('main.book')</button>
                        </form>
                    </div>
                </div>
            </a>


        </div>
    </div>
    <div class="col-lg-2 d-xl-block d-lg-block d-none" data-aos="fade-left" data-aos-duration="2000">
        <div class="price">
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
