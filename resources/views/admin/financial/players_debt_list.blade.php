@extends('layouts.app_admin')




@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'لیست بازیکنان'])
                <table class="table table-bordered table-hover" id="datatbl">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">نام خانوادگی</th>
                        <th scope="col">تعداد جلسات پرداخت شده</th>
                        <th scope="col">تعداد جلسات استفاده شده</th>
                        <th scope="col">تعداد دقایق استفاده شده</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>{{$player->first_name}}</td>
                            <td>{{$player->last_name}}</td>
                            @if($player->balance)
                                <td>@faNum($player->balance->amount,false)</td>
                            @else
                                <td>۰</td>
                            @endif
                            <td>@faNum($player->deptLessonsCount(),false)</td>
                            @if($player->deptLessonMinutes())
                                <td>@toHours($player->deptLessonMinutes())</td>
                            @else
                                <td>۰</td>
                            @endif
                            <td>
                                <a href="{{route('admin.financial.player_pay_form',$player)}}"
                                   class="btn btn-sm btn-success">
                                    بروزرسانی
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{$players->links()}}</div>
            @endcomponent
        </div>
    </div>

@endsection
