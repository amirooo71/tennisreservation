@extends('layouts.app_admin')

@section('content')

    <div class="row">

        <div class="col-md-6">

            <form class="kt-form" action="{{route('admin.courts.update',compact('club','court'))}}" method="POST">
                @csrf
                @method('PATCH')
                @component('components.portlet',['title' => 'فرم ویرایش زمین تنیس'])

                    @include('admin.courts._form',['court' => $court])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot

                @endcomponent

            </form>

        </div>

    </div>

@endsection