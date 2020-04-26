@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'فرم اضافه کردن مربی'])


                <form class="kt-form" action="{{route('admin.coaches.store')}}" method="POST">

                    @csrf


                    @include('admin.coaches._form',['coach' => new \App\Coach])

                </form>


            @endcomponent
        </div>
    </div>

@endsection