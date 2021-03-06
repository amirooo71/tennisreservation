@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col-md-6">
            <form class="kt-form" action="{{route('admin.clubs.update',$club)}}" method="POST">
                @csrf
                @method('PATCH')

                @component('components.portlet',['title' => 'فرم ویرایش کلاب'])

                    @include('admin.clubs._form',['club' => $club])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot

                @endcomponent
            </form>
        </div>
    </div>

@endsection