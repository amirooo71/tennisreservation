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
                        <th scope="col">بدهی</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coaches as $coach)
                        <tr>
                            <td>{{$coach->first_name}}</td>
                            <td>{{$coach->last_name}}</td>
                            <td>
                                <a href="{{route('admin.financial.coach_pay_form',$coach)}}"
                                   class="btn btn-sm btn-success">
                                    مشاهده
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
