@extends('layouts.app_admin')




@section('content')

    <div class="row">
        <div class="col">
            @component('components.portletWithoutFooter',['title' => 'لیست مربیان'])
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
                    @foreach($coaches as $coach)
                        <tr>
                            <td>{{$coach->first_name}}</td>
                            <td>{{$coach->last_name}}</td>
                            <td>@faNum($coach->deptLessonCount(),false)</td>
                            <td>@toHours($coach->deptLessonMinutes())</td>
                            <td>
                                <a href="{{route('admin.financial.coach_pay_form',$coach)}}"
                                   class="btn btn-sm btn-success">
                                    پرداخت
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{$coaches->links()}}</div>
            @endcomponent
        </div>
    </div>

@endsection
