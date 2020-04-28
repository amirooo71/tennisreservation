@extends('layouts.app_admin')

@section('content')

    <div class="row">
        <div class="col">
            <div class="kt-portlet">
                <div class="kt-portlet__body  kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-md-12 col-lg-6 col-xl-3">
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
										{{\App\BladeHelper::toHours($bookings)}}
                                    </span>
                                </div>
                                <div class="progress progress--sm">
                                    <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{round($bookingPercent)}}%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="kt-widget24__action">
									<span class="kt-widget24__change">
										آمار
									</span>
                                    <span class="kt-widget24__number">
										%{{\App\BladeHelper::toPersianNumbers(round($bookingPercent))}}
									</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
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
									    {{\App\BladeHelper::toHours($canceled)}}
									</span>
                                </div>
                                <div class="progress progress--sm">
                                    <div class="progress-bar kt-bg-danger" role="progressbar" style="width: {{round($canceledPercent)}}%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="kt-widget24__action">
                                    <span class="kt-widget24__change">آمار</span>
                                    <span class="kt-widget24__number">
                                        %{{\App\BladeHelper::toPersianNumbers(round($canceledPercent))}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            پرداختی ها
                                        </h4>
                                        <span class="kt-widget24__desc">
										    کل پرداختی های امروز
										</span>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-success">{{\App\BladeHelper::toPersianNumbers($paids,true)}}</span>
                                </div>
                                <div class="progress progress--sm">
                                    <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{round($paidPercent)}}%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="kt-widget24__action">
                                    <span class="kt-widget24__change">آمار</span>
                                    <span class="kt-widget24__number">%{{\App\BladeHelper::toPersianNumbers(round($paidPercent))}}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            تاریخ امروز
                                        </h4>
                                        <span class="kt-widget24__desc">
                                            {{\Hekmatinasser\Verta\Verta::now()->formatWord('l')}} {{\App\BladeHelper::toPersianNumbers(\Hekmatinasser\Verta\Verta::now()->formatTime()) }}
                                        </span>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-success">
                                        {{\App\BladeHelper::toPersianNumbers(\Hekmatinasser\Verta\Verta::now()->formatDate())}}
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
                                <span class="pulsating-circle"></span>
                                <span class="pulsating-label">در حال بازی</span>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <img src="{{asset('images/court-h-512x512.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex justify-content-between">
                                <span class="text-muted">مربی فعال: </span>
                                <span class="kt-badge kt-badge--brand kt-badge--inline">امیر شجاعی</span>
                            </div>
                            <div class="col-md-6 d-flex justify-content-between">
                                <span class="text-muted">رزرو: </span>
                                <span class="kt-badge kt-badge--brand kt-badge--inline">۱۲ ساعت</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection