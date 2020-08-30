@extends('layouts.app_admin')

@section('content')

    @component('components.portletWithoutFooter',['title' => $player->first_name . ' ' . $player->last_name])
        <ul class="nav nav-tabs  nav-tabs-line" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" role="tab">مشخصات</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_2" role="tab">فیکسی ها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_3" role="tab">کلاس ها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_4" role="tab">مالی</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>نام و نام خانوادگی</label>
                            <input readonly class="form-control" type="text"
                                   value="{{$player->first_name . ' ' . $player->last_name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>شماره تماس یک</label>
                            <input readonly class="form-control" type="text" value="{{$player->contact_number_one}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>شماره تماس دو</label>
                            <input readonly class="form-control" type="text" value="{{$player->contact_number_two}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>هزینه کلاس</label>
                            <input readonly class="form-control" type="text"
                                   value="{{$player->learning_price . ' تومان'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سن</label>
                            <input readonly class="form-control" type="text" value="{{$player->age}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ایمیل</label>
                            <input readonly class="form-control" type="text" value="{{$player->email}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>جنسیت</label>
                            <input readonly class="form-control" type="text"
                                   value="{{$player->gender === 'male' ? 'پسر' : 'دختر'}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>بیوگرافی</label>
                            <textarea class="form-control" readonly cols="30" rows="10">
                                {{$player->bio}}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="{{route('admin.players.edit',$player)}}" class="btn btn-primary">ویرایش اطلاعات</a>
                </div>

            </div>

            <div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
                <div class="kt-widget1">
                    @foreach($player->fixes as $fix)
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    <strong>مربی:</strong> {{$fix->coach->first_name . ' ' . $fix->coach->last_name}}
                                </h3>
                                <span class="kt-widget1__desc"><strong>ساعت:</strong> @faNum($fix->time,false)</span>
                            </div>
                            <span class="kt-widget1__number kt-font-brand">{{$fix->day}}</span>
                        </div>
                    @endforeach
                    <div class="form-group">
                        <a href="{{route('admin.fix_bookings.index')}}" class="btn btn-primary">نمایش فیکسی ها</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                <div class="kt-widget1">
                    @foreach($player->lessons as $lesson)
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title"><strong>تاریخ:</strong>
                                    @faNum(\Hekmatinasser\Verta\Verta::parse($lesson->date)->format('j-n-Y'),false)</h3>
                                <span class="kt-widget1__desc"><strong>ساعت:</strong> @faNum($lesson->time,false)</span>
                            </div>
                            @if($lesson->is_paid)
                                <span class="kt-widget1__number kt-font-success">پرداخت شده</span>
                            @else
                                <span class="kt-widget1__number kt-font-danger">پرداخت نشده</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="kt_tabs_1_4" role="tabpanel">
                <div class="alert alert-success" role="alert">
                    <div class="alert-text">
                        {{$player->first_name . ' ' . $player->last_name}} تاکنون هزینه
                        @faNum($player->paidLessonsCount(),false) جلسه را پرداخت کرده است.
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <div class="alert-text">
                        {{$player->first_name . ' ' . $player->last_name}} هزینه ی
                        @faNum($player->deptLessonsCount(),false) جلسه آموزشی را باید پرداخت کند.
                    </div>
                </div>

                <div class="alert alert-secondary" role="alert">
                    <div class="alert-text">
                        <div class="row d-flex justify-content-between">
                            <h4>پرداختی ها: </h4> <span class="kt-badge kt-badge--info">@faNum($player->paidLessonsCount(),false)</span>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <h4>بدهکاری ها: </h4> <span class="kt-badge kt-badge--info">@faNum($player->deptLessonsCount(),false)</span>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <h4>مجموع بدهکاری: </h4> <h3>@faNum($player->learning_price * $player->deptLessonsCount(),true) تومان</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent

@endsection
