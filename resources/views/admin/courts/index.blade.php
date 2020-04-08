@extends('layouts.app_admin')

@section('content')

    @if($club->courts->count())
        @if($club->courts->count() !== $club->courts_count)
            <div class="alert alert-warning fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">تعداد کلی زمین تنیس های کلاب شما {{$club->courts_count}} عدد می باشد، اما شما
                    تنها
                    اطلاعات {{$club->courts->count()}} زمین تنیس را تا کنون وارد کرده اید.
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        @endif
    @endif


    <a href="{{route('admin.courts.create',$club)}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>

    @component('components.portletWithoutFooter',['title' => 'لیست زمین تنیس ها'])

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="datatbl">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">نام</th>
                            <th scope="col">نوع</th>
                            <th scope="col">قیمت</th>
                            <th scope="col">سرپوشیده</th>
                            <th scope="col">سنتر کورت</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($club->courts as $court)
                            <tr>
                                <th scope="row">{{$court->id}}</th>
                                <td>{{$court->name}}</td>
                                @if($court->type === 'clay')
                                    <td>خاک</td>
                                @elseif($court->type === 'hard')
                                    <td>هارد</td>
                                @else
                                    <td>چمن</td>
                                @endif
                                <td>{{$court->price}}</td>
                                <td>
                                    @if($court->is_indoor)
                                        <span class="kt-badge kt-badge--success kt-badge--inline">بله</span>
                                    @else
                                        <span class="kt-badge kt-badge--brand kt-badge--inline">خیر</span>
                                    @endif
                                </td>
                                <td>
                                    @if($court->is_center)
                                        <span class="kt-badge kt-badge--success kt-badge--inline">بله</span>
                                    @else
                                        <span class="kt-badge kt-badge--brand kt-badge--inline">خیر</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.courts.edit',['club' => $club,'court' => $court])}}"
                                       class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ویرایش">
                                        <i class="la la-edit text-success"></i>
                                    </a>
                                    <a href="{{route('admin.courts.delete',['club' => $club,'court' => $court])}}"
                                       class="btn btn-sm btn-clean btn-icon btn-icon-md" title="حذف">
                                        <i class="la la-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endcomponent

@endsection