@extends('layouts.app_admin')


@section('content')

    <a href="{{route('admin.fix_bookings.index')}}" class="btn btn-light btn-elevate mb-3">بازگشت</a>

    <div class="row">
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'رزرو فیکسی'])
                <fix-booking :courts="{{json_encode($courts)}}" :hours="{{json_encode($openingHours)}}" :coaches="{{json_encode(\App\Coach::all())}}"></fix-booking>
            @endcomponent
        </div>
        <div class="col-md-6">
            <div class="alert alert-warning fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    تعداد فیکسی های شما @faNum(\App\FixBooking::all()->count(),false) می باشد
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
