@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => 'فرم ویرایش مربی'])


                <form class="kt-form" action="{{route('admin.coaches.update',$coach)}}" method="POST">

                    @csrf
                    @method('PATCH')

                    @include('admin.coaches._form',['coach' => $coach])

                </form>


            @endcomponent
        </div>
    </div>

@endsection