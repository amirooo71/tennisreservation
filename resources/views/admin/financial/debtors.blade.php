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
                        <th scope="col">مدت زمان بدهی</th>
                        <th scope="col">مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($debtors as $d)

                        <tr>
                            <td>{{$d->name}}</td>
                            @if($d->booked)
                                <td>@faNum($d->booked->date,false)</td>
                                <td>@faNum($d->booked->time,false)</td>
                                <td>{{$d->booked->court->name}}</td>
                            @else
                                <td>@faNum($d->partTimeBooked->booking->date,false)</td>
                                <td>@faNum($d->partTimeBooked->booking->time,false)</td>
                                <td>{{$d->partTimeBooked->booking->court->name}}</td>
                            @endif
                            <td>@toHours($d->booked->duration)</td>
                            <td>
                                <form action="{{route('admin.debtor_pay.index',$d)}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <input type="hidden" name="paid" value="paid">
                                        <div class="col">
                                            <button class="btn btn-success btn-sm">
                                                <i class="far fa-credit-card"></i>
                                                مبلغ پرداخت شد
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{$debtors->links()}}</div>
            @endcomponent
        </div>
    </div>


@endsection
