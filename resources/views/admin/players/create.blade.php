@extends('layouts.app_admin')


@section('content')

    <div class="row">

        <div class="col-md-6">

            <form class="kt-form" action="{{route('admin.players.store')}}" method="POST">
                @csrf

                @component('components.portlet',['title' => 'فرم ساخت بازیکن'])

                    @include('admin.players._form',['player' => new \App\Player])

                    @slot('footer')
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    @endslot

                @endcomponent

            </form>

        </div>

    </div>

@endsection
