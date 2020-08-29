@extends('layouts.app_admin')


@section('content')

    <div class="row">

        <div class="col-md-6">

            <form class="kt-form" action="{{route('admin.players.update',$player)}}" method="POST">
                @csrf
                @method('PATCH')
                @component('components.portlet',['title' => 'فرم ویرایش بازیکن'])

                    @include('admin.players._form',['player' => $player])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot

                @endcomponent

            </form>

        </div>

    </div>

@endsection
