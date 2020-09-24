@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <h4>فرم صورت حساب {{$player->fullname}}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    @component('components.portletWithoutFooter',['title' => 'تعداد جلسات دریافتی'])
                        <form action="{{route('admin.financial.player_pay',$player)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>تعداد جلسات را وارد کنید</label>
                                <input type="number" class="form-control" name="amount"
                                       value="{{$player->deptLessonsCount()}}">
                                @component('components.validation',['field' => 'amount'])
                                @endcomponent
                            </div>
                            <div>
                                <button class="btn btn-success">اعمال</button>
                            </div>
                        </form>
                    @endcomponent
                    @component('components.portletWithoutFooter',['title' => 'تعداد جلسات بدهکاری'])
                        <form action="{{route('admin.financial.edit_lessons_pay',$player)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>تعداد جلسات را وارد کنید</label>
                                <input type="number" class="form-control" name="amount">
                                @component('components.validation',['field' => 'amount'])
                                @endcomponent
                            </div>
                            <div>
                                <button class="btn btn-danger">اعمال</button>
                            </div>
                        </form>
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <a href="{{route('admin.financial.sync_player_balance',$player)}}" class="btn btn-block btn-success mb-3">
                <i class="fas fa-sync"></i>
                بروزرسانی
            </a>
            @component('components.portletWithoutFooter',['title' => 'صورت حساب جلسات'])
                @if($player->balance)
                    @if($player->balance->amount >= 0)
                        <h2 class="text-success">@faNum($player->balance->amount,false) جلسه طلبکار</h2>
                    @else
                        <h2 class="text-danger">@faNum($player->balance->amount,false) جلسه بدهکار</h2>
                    @endif
                @else
                    <h2 class="text-success">۰ جلسه</h2>
                @endif
            @endcomponent
            @component('components.portletWithoutFooter',['title' => "تعداد جلسات پرداخت نشده"])
                <h2 class="text-danger">@faNum($player->deptLessonsCount(),false) جلسه</h2>
                @if($player->deptLessonMinutes())
                    <h2 class="text-danger">@toHours($player->deptLessonMinutes()) دقیقه</h2>
                @endif
            @endcomponent
        </div>
    </div>

@endsection
