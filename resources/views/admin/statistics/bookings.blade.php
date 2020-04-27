@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'نمودار رزرو'])

                <bookings-chart></bookings-chart>

            @endcomponent

        </div>
    </div>

@endsection