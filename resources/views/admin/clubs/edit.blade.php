@extends('layouts.app_admin')


@section('content')

    <div class="col-md-6">
        <form class="kt-form" action="{{route('admin.clubs.update',$club)}}" method="POST">
            @csrf
            @method('PATCH')

            @component('components.portlet',['title' => 'فرم ساخت کلاب'])

                @include('admin.clubs._form',['club' => $club])

                @slot('footer')
                    <button type="submit" class="btn btn-primary">ویرایش</button>
                @endslot

            @endcomponent
        </form>
    </div>

@endsection