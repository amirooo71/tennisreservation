@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'نمودار درآمد'])

                <revenue-chart></revenue-chart>

            @endcomponent

        </div>
    </div>

@endsection