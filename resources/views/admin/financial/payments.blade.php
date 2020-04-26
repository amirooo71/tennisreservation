@extends('layouts.app_admin')

@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'پرداختی ها'])
                <table class="table table-bordered table-hover" id="datatbl">
                    <thead>
                    <tr>
                        <th scope="col">نام رزرو کننده</th>
                        <th scope="col">تاریخ رزرو</th>
                        <th scope="col">ساعت رزرو</th>
                        <th scope="col">زمین</th>
                        <th scope="col">مبلغ</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $p)

                        <tr>
                            @if($p->booked)
                                <td>{{$p->booked->renter_name}}</td>
                                <td>{{$p->booked->date}}</td>
                                <td>{{$p->booked->time}}</td>
                                <td>{{$p->booked->court->name}}</td>
                            @else
                                <td>{{$p->partTimeBooked->booking->date}}</td>
                                <td>{{$p->partTimeBooked->booking->time}}</td>
                                <td>{{$p->partTimeBooked->booking->court->name}}</td>
                                <td>{{$p->partTimeBooked->booking->renter_name}}</td>
                            @endif
                            <td>{{$p->amount}}</td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm">پرداخت نکرده</a>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>


@endsection