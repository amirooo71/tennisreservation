@extends('layouts.app_admin')


@section('content')

    <a href="{{route('admin.fix_bookings.index')}}" class="btn btn-light btn-elevate mb-3">بازگشت</a>

    <div class="row">
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'رزرو فیکسی'])
                <fix-booking :courts="{{json_encode($courts)}}" :hours="{{json_encode($openingHours)}}"
                             :coaches="{{json_encode(\App\Coach::all())}}"></fix-booking>
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'فیکسی ها'])
               <fix-list></fix-list>
            @endcomponent
        </div>
    </div>

@endsection
