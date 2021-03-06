@extends('layouts.app_admin')

@section('content')

    <div class="row">
        <div class="col-md-6">

            @if($club)

                @component('components.portlet',['title' => 'اطلاعات کلاب'])

                    <div class="form-group">
                        <label>نام کلاب</label>
                        <input type="text" value="{{$club->name}}" class="form-control" disabled>
                    </div>


                    <div class="form-group">
                        <label>تعداد زمین تنیس های کلاب</label>
                        <input type="text" value="{{$club->courts_count}}" class="form-control" disabled>
                    </div>


                    <div class="form-group">
                        <label>ساعت شروع به کار کلاب</label>
                        <input type="text" value="{{$club->opening_time}}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>ساعت اتمام کار کلاب</label>
                        <input type="text" value="{{$club->closing_time}}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>مدت زمان کنسلی</label>
                        <input type="text" value="{{$club->cancellation_time}}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>تعداد روزهای مورد نیاز برای رزرو فیکسی</label>
                        <input type="text" value="{{$club->fix_amount}}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>توضیحات تکمیلی کلاب</label>
                        <textarea class="form-control" cols="30" rows="5" disabled>{{$club->description}}</textarea>
                    </div>

                    @slot('footer')

                        <div class="d-flex">
                            <a class="btn btn-primary" href="{{route('admin.clubs.edit',$club)}}">
                                ویرایش اطلاعات
                            </a>

                            <form class="ml-2" action="{{route('admin.clubs.delete',$club)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        href="{{route('admin.clubs.delete',$club)}}">
                                    حذف کلاب
                                </button>
                            </form>
                        </div>

                    @endslot

                @endcomponent

            @else
                <div class="kt-portlet kt-callout">
                    <div class="kt-portlet__body">
                        <div class="kt-callout__body">
                            <div class="kt-callout__content">
                                <h3 class="kt-callout__title">کلاب یافت نشد</h3>
                                <p class="kt-callout__desc">
                                    سیستم برای راه اندازی نیاز به تعریف کلاب دارد
                                </p>
                            </div>
                            <div class="kt-callout__action">
                                <a href="{{route('admin.clubs.create')}}"
                                   class="btn btn-custom btn-bold btn-upper btn-font-sm  btn-brand">تعریف کلاب</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
