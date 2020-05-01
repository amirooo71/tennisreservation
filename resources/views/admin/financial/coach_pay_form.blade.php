@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    @component('components.portletWithoutFooter',['title' => 'فرم پرداخت مربی'])
                        <form action="{{route('admin.financial.coach_pay',$coach)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>مبلغ به تومان</label>
                                <input type="number" class="form-control" name="amount">
                                @component('components.validation',['field' => 'amount'])
                                @endcomponent
                            </div>
                            <div>
                                <button class="btn btn-success">ذخیره</button>
                            </div>
                        </form>
                    @endcomponent
                </div>
                <div class="col-md-12">
                    @include('admin.financial._coach_increase_debt_form')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @component('components.portletWithoutFooter',['title' => "مبلغ بدهکاری {$coach->first_name} {$coach->last_name}"])
                <h2 class="text-danger">@faNum($coach->debtAmount(),true) تومان</h2>
            @endcomponent
        </div>
    </div>

@endsection