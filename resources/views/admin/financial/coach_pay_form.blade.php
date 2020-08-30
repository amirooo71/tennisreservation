@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <h4>فرم صورت حساب {{$coach->fullname}}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    @component('components.portletWithoutFooter',['title' => 'فرم پرداخت جلسات'])
                        <form action="{{route('admin.financial.coach_pay',$coach)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>تعداد جلسات قابل پرداخت</label>
                                <input type="number" class="form-control" name="amount" value="{{$coach->deptLessonCount()}}">
                                @component('components.validation',['field' => 'amount'])
                                @endcomponent
                            </div>
                            <div>
                                <button class="btn btn-success">پرداخت</button>
                            </div>
                        </form>
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => "تعداد جلسات پرداخت نشده {$coach->first_name} {$coach->last_name}"])
                <h2 class="text-danger">@faNum($coach->deptLessonCount(),false) جلسه</h2>
                <h2 class="text-danger">@toHours($coach->deptLessonMinutes()) دقیقه</h2>
            @endcomponent
        </div>
    </div>

@endsection
