@extends('layouts.app_admin')

@section('content')

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
