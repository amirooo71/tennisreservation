@extends('layouts.app_admin')

@section('content')
    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'لیست بستانکاران'])
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
                    @foreach($creditors as $c)

                        <tr>
                            <td>{{$c->name}}</td>
                            @if($c->booked)
                                <td>{{$c->booked->date}}</td>
                                <td>{{$c->booked->time}}</td>
                                <td>{{$c->booked->court->name}}</td>
                            @else
                                <td>{{$c->partTimeBooked->booking->date}}</td>
                                <td>{{$c->partTimeBooked->booking->time}}</td>
                                <td>{{$c->partTimeBooked->booking->court->name}}</td>
                            @endif
                            <td>{{$c->amount}}</td>
                            <td>
                                <form action="{{route('admin.refund_creditors.index',$c)}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-redo"></i>
                                        <span>مبلغ بازگشت داده شد</span>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>
@endsection