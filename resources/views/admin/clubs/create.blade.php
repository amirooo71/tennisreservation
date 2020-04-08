@extends('layouts.app_admin')


@section('content')




    <div class="row">
        <div class="col-md-12">
            <form class="kt-form" action="{{route('admin.clubs.store')}}" method="POST">
                @csrf
                @component('components.portlet',['title' => 'فرم ساخت کلاب'])

                    @include('admin.clubs._form',['club' => new \App\Club])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot
                @endcomponent
            </form>
        </div>
    </div>

@endsection