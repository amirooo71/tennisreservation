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
                        <th scope="col">تعداد جلسات پرداخت نشده</th>
                        <th scope="col">تعداد دقایق پرداخت نشده</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>{{$player->first_name}}</td>
                            <td>{{$player->last_name}}</td>
                            <td>@faNum($player->deptLessonsCount(),false)</td>
                            <td>@toHours($player->deptLessonMinutes())</td>
                            <td>
                                <a href="{{route('admin.financial.player_pay_form',$player)}}"
                                   class="btn btn-sm btn-success">
                                    پرداخت
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
