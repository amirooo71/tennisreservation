@extends('layouts.app_admin')

@section('content')
    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'لیست کنسلی ها'])
                <table class="table table-bordered table-hover" id="datatbl">
                    <thead>
                    <tr>
                        <th scope="col">نام کنسل کننده</th>
                        <th scope="col">تاریخ رزرو</th>
                        <th scope="col">ساعت رزرو</th>
                        <th scope="col">زمین</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($canceled as $c)
                        <tr>
                            <td>{{$c->renter_name}}</td>
                            <td>{{$c->date}}</td>
                            <td>{{$c->time}}</td>
                            <td>{{$c->court->name}}</td>
                            <td>Action</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>
@endsection