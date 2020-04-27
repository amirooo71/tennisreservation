@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'نمودار کنسلی ها'])

                <canceled-chart></canceled-chart>

            @endcomponent

        </div>
    </div>

@endsection