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
                        <th scope="col">پرداختی مربی</th>
                        <th scope="col">مبلغ</th>
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
                                <td>
                                    <span class="kt-badge kt-badge--info kt-badge--inline">خیر</span>
                                </td>
                            @elseif($p->partTimeBooked)
                                <td>{{$p->partTimeBooked->booking->date}}</td>
                                <td>{{$p->partTimeBooked->booking->time}}</td>
                                <td>{{$p->partTimeBooked->booking->court->name}}</td>
                                <td>{{$p->partTimeBooked->booking->renter_name}}</td>
                                <td>
                                    <span class="kt-badge kt-badge--info kt-badge--inline">خیر</span>
                                </td>
                            @else
                                <td>{{$p->coach->first_name . ' ' . $p->coach->last_name}}</td>
                                <td> - </td>
                                <td> - </td>
                                <td> - </td>
                                <td>
                                    <span class="kt-badge kt-badge--success kt-badge--inline">بله</span>
                                </td>
                            @endif
                            <td>{{$p->amount}} تومان</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{$payments->links()}}</div>
            @endcomponent
        </div>
    </div>


@endsection