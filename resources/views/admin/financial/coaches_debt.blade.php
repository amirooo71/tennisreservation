@extends('layouts.app_admin')




@section('content')

    <div class="row">
        <div class="col">
            <a href="{{route('admin.coaches.create')}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>
            @component('components.portletWithoutFooter',['title' => 'لیست مربیان'])
                <table class="table table-bordered table-hover" id="datatbl">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">نام خانوادگی</th>
                        <th scope="col">بدهکاری</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coaches as $coach)
                        <tr>
                            <td>{{$coach->first_name}}</td>
                            <td>{{$coach->last_name}}</td>
                            <td>@faNum($coach->debtAmount(),true) تومان</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success">
                                    پرداخت
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>

@endsection
