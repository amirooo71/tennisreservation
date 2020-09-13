@extends('layouts.app_admin')

@section('content')

    <div class="row mb-3">
        <div class="col">
            <a href="{{route('admin.bookings.add_fixes')}}" class="btn btn-block btn-primary">
                اضافه کردن فیکسی ها
            </a>
        </div>
    </div>


    @component('components.portletWithoutFooter',['title' => 'جست و جو رزوری'])
        <form action="{{route('go.to.date')}}" method="GET" class="row">
            @csrf
            <div class="col-3 form-group">
                <input type="text" class="form-control" name="d"
                       value="{{\Hekmatinasser\Verta\Verta::now()->format('j')}}">
            </div>
            <div class="col-3 form-group">
                <input type="text" class="form-control" name="n"
                       value="{{\Hekmatinasser\Verta\Verta::now()->format('n')}}">
            </div>
            <div class="col-3 form-group">
                <input type="text" class="form-control" name="y"
                       value="{{\Hekmatinasser\Verta\Verta::now()->format('Y')}}">
            </div>
            <div class="col-3 form-group">
                <button class="btn btn-block btn-secondary" type="submit">برو به تاریخ</button>
            </div>
        </form>
    @endcomponent

    <div class="row">
        <div class="col">
            <div class="kt-portlet">
                <div class="kt-portlet__body  kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-md-12 col-lg-6 col-xl-4">
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            رزرو
                                        </h4>
                                        <span class="kt-widget24__desc">
                                            کل ساعات رزروی امروز
                                        </span>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand">
                                        @toHours($bookingMinutes)
                                    </span>
                                </div>
                                <div class="progress progress--sm">
                                    <div class="progress-bar kt-bg-brand" role="progressbar"
                                         style="width: {{$bookingPercent}}%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="kt-widget24__action">
									<span class="kt-widget24__change">
										آمار
									</span>
                                    <span class="kt-widget24__number">
										%@faNum($bookingPercent,false)
									</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-4">
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            کنسلی
                                        </h4>
                                        <span class="kt-widget24__desc">
											کل کنسلی های امروز
										</span>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-danger">
									   @toHours($canceledMinutes)
									</span>
                                </div>
                                <div class="progress progress--sm">
                                    <div class="progress-bar kt-bg-danger" role="progressbar"
                                         style="width: {{$canceledPercent}}%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="kt-widget24__action">
                                    <span class="kt-widget24__change">آمار</span>
                                    <span class="kt-widget24__number">
                                        %@faNum($canceledPercent,false)
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-4">
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            تاریخ امروز
                                        </h4>
                                        <span class="kt-widget24__desc">
                                            {{\Hekmatinasser\Verta\Verta::now()->formatWord('l')}} {{\App\FaNumber::toPersianNumbers(\Hekmatinasser\Verta\Verta::now()->formatTime()) }}
                                        </span>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-success">
                                        {{\App\FaNumber::toPersianNumbers(\Hekmatinasser\Verta\Verta::now()->formatDate())}}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="flaticon-cancel"></i>
                            </span>
                        <h3 class="kt-portlet__head-title">
                            کنسلی ها
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="200"
                         data-scrollbar-shown="true" style="height: 200px; overflow: hidden;">

                        @foreach(\App\Debtor::where('is_paid',false)->get() as $debtor)
                            <div class="kt-widget1">
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">{{$debtor->booked->renter_name}}</h3>
                                        <span class="kt-widget1__desc">@faNum($debtor->booked->date,false) @faNum($debtor->booked->time,false)</span>
                                    </div>
                                    @if($debtor->is_paid)
                                        <span class="kt-widget1__number kt-font-success">پرداخت شده</span>
                                    @else
                                        <span class="kt-widget1__number kt-font-danger">پرداخت نشده</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="ps__rail-x" style="left: 0px; bottom: -52px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 52px; height: 200px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 26px; height: 100px;"></div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <a href="{{route('admin.debtors.index')}}" class="btn btn-secondary btn-sm">مشاهده
                                بدهکاران</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="flaticon-cancel"></i>
                            </span>
                        <h3 class="kt-portlet__head-title">
                            صورت حساب شاگردان
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="200"
                         data-scrollbar-shown="true" style="height: 200px; overflow: hidden;">

                        @foreach(\App\Player::whereHas('balance')->get() as $player)
                            @if($player->balance->amount === 1)
                                <div class="kt-widget1">
                                    <div class="kt-widget1__item">
                                        <div class="kt-widget1__info">
                                            <h3 class="kt-widget1__title">{{$player->fullname}}</h3>
                                            <span class="kt-widget1__desc">
                                            <span class="text-muted">تعداد جلسات باقی مانده: @faNum($player->balance->amount,false)</span>
                                        </span>
                                        </div>
                                        <a href="{{route('admin.financial.player_pay',$player)}}"
                                           class="btn btn-secondary btn-sm">مدیریت حساب</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="ps__rail-x" style="left: 0px; bottom: -52px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 52px; height: 200px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 26px; height: 100px;"></div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <a href="{{route('admin.financial.players_debt_list')}}" class="btn btn-secondary btn-sm">مشاهده
                                وضعیت مالی شاگردان</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="flaticon-cancel"></i>
                            </span>
                        <h3 class="kt-portlet__head-title">
                            صورت حساب مربیان
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="200"
                         data-scrollbar-shown="true" style="height: 200px; overflow: hidden;">

                        @foreach(\App\Coach::all() as $coach)
                            <div class="kt-widget1">
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">{{$coach->fullname}}</h3>
                                        <span class="kt-widget1__desc">
                                            <span class="text-muted">تعداد جلسات پرداخت نشده: @faNum($coach->deptLessonCount(),false)</span>
                                        </span>
                                    </div>
                                    <a href="{{route('admin.financial.coach_pay',$coach)}}"
                                       class="btn btn-secondary btn-sm">مدیریت حساب</a>
                                </div>
                            </div>
                        @endforeach

                        <div class="ps__rail-x" style="left: 0px; bottom: -52px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 52px; height: 200px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 26px; height: 100px;"></div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <a href="{{route('admin.financial.coaches_debt_list')}}" class="btn btn-secondary btn-sm">مشاهده
                                وضعیت مالی مربیان</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="kt-portlet kt-callout">
                <div class="kt-portlet__body">
                    <div class="kt-callout__body">
                        <div class="kt-callout__content">
                            @if($bookingPercent > 70)
                                <h3 class="kt-callout__title text-danger">شلوغ</h3>
                                <p class="kt-callout__desc">
                                    امروز روز شلوغی را در پیش دارید، امیدواریم که امروز رو به بهترین نحو پشت سر بزارید.
                                </p>
                            @elseif($bookingPercent > 40 && $bookingPercent < 70)
                                <h3 class="kt-callout__title text-info">متعادل</h3>
                                <p class="kt-callout__desc">
                                    امروز وضعیت مجموعه مثل همیشه عادی هست پس نگران چیزی نباش.
                                </p>
                            @else
                                <h3 class="kt-callout__title text-success">خلوت</h3>
                                <p class="kt-callout__desc">
                                    امروز روز خلوتی را در پیش دارید، خوب هست که واسه فردا یه برنامه ریزی عالی کنی.
                                </p>
                            @endif
                        </div>
                        <div class="kt-callout__action">
                            <a href="{{route('admin.bookings.index')}}"
                               class="btn btn-custom btn-bold btn-upper btn-font-sm  btn-brand" target="_blank">لیست
                                رزروی ها</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($courts as $c)
            <div class="col-md-3">
                <div class="kt-portlet">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{$c->name}}
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-actions">
                                @if($c->isPlaying())
                                    <span class="pulsating-circle"></span>
                                    <span class="pulsating-label">در حال بازی</span>
                                @else
                                    <span class="kt-badge kt-badge--danger kt-badge--inline">خالی</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <img src="{{asset('images/court-h-512x512.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="row align-items-center">
                            <div class="col-md-12 d-flex justify-content-between">
                                <span class="text-muted">مدت زمان رزوی: </span>
                                @if($c->todayBookedMinutes())
                                    <span class="kt-badge kt-badge--brand kt-badge--inline">@toHours($c->todayBookedMinutes())</span>
                                @else
                                    <span class="kt-badge kt-badge--danger kt-badge--inline">بدون رزرو</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection
