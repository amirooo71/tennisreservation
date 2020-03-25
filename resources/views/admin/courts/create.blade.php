@extends('layouts.app_admin')


@section('content')

    <div class="row">

        <div class="col-md-6">

            <form class="kt-form" action="{{route('admin.courts.store',$club)}}" method="POST">
                @csrf

                @component('components.portlet',['title' => 'فرم ساخت زمین تنیس'])

                    @include('admin.courts._form',['court' => new \App\Court])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot

                @endcomponent

            </form>

        </div>

    </div>

@endsection