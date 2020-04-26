@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <div class="col">
            <a href="{{route('admin.coaches.create')}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>
            @component('components.portletWithoutFooter',['title' => 'لیست مربیان'])
                <table class="table table-bordered table-hover" id="datatbl">
                    <thead>
                    <tr>
                        <th scope="col">نام</th>
                        <th scope="col">نام خانوادگی</th>
                        <th scope="col">جنیست</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coaches as $coach)
                        <tr>
                            <td>{{$coach->first_name}}</td>
                            <td>{{$coach->last_name}}</td>
                            <td>{{$coach->gender === 'male' ? 'آقا' : 'خانم'}}</td>
                            <td>
                                <a href="{{route('admin.coaches.edit',$coach)}}"
                                   class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ویرایش">
                                    <i class="la la-edit text-success"></i>
                                </a>
                                <a href="{{route('admin.coaches.delete',$coach)}}"
                                   class="btn btn-sm btn-clean btn-icon btn-icon-md" title="حذف">
                                    <i class="la la-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>

@endsection