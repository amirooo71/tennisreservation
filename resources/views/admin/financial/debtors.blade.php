@extends('layouts.app_admin')

@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'لیست بدهکاران'])
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
                        @foreach($debtors as $d)

                            <tr>
                                <td>{{$d->name}}</td>
                                @if($d->booked)
                                    <td>{{$d->booked->date}}</td>
                                    <td>{{$d->booked->time}}</td>
                                    <td>{{$d->booked->court->name}}</td>
                                @else
                                    <td>{{$d->partTimeBooked->booking->date}}</td>
                                    <td>{{$d->partTimeBooked->booking->time}}</td>
                                    <td>{{$d->partTimeBooked->booking->court->name}}</td>
                                @endif
                                <td>{{$d->amount}}</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">مبلغ پرداخت شد</a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
            @endcomponent
        </div>
    </div>


@endsection