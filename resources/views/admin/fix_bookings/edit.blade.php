@extends('layouts.app_admin')


@section('content')

    <a href="{{route('admin.fix_bookings.index')}}" class="btn btn-light btn-elevate mb-3">بازگشت</a>

    <div class="row">
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'رزرو فیکسی'])
                <form class="kt-form" action="{{route('admin.fix_bookings.update',$fixBooking)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    @include('admin.fix_bookings._form')
                </form>
            @endcomponent
        </div>
    </div>

@endsection