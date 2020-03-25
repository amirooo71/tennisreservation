@extends('layouts.app_admin')

@section('content')

    <a href="{{route('admin.courts.create',$club)}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>

    @component('components.portletWithoutFooter',['title' => 'لیست زمین تنیس ها'])

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">نام</th>
                            <th scope="col">نوع</th>
                            <th scope="col">قیمت</th>
                            <th scope="col">سرپوشیده</th>
                            <th scope="col">سنتر کورت</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($club->courts as $court)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$court->name}}</td>
                                @if($court->type === 'clay')
                                    <td>خاک</td>
                                @elseif($court->type === 'hard')
                                    <td>هارد</td>
                                @else
                                    <td>چمن</td>
                                @endif
                                <td>{{$court->price}}</td>
                                <td>
                                    @if($court->is_indoor)
                                        <span class="kt-badge kt-badge--success kt-badge--inline">بله</span>
                                    @else
                                        <span class="kt-badge kt-badge--brand kt-badge--inline">خیر</span>
                                    @endif
                                </td>
                                <td>
                                    @if($court->is_center)
                                        <span class="kt-badge kt-badge--success kt-badge--inline">بله</span>
                                    @else
                                        <span class="kt-badge kt-badge--brand kt-badge--inline">خیر</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.courts.edit',['club' => $club,'court' => $court])}}"
                                       class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ویرایش">
                                        <i class="la la-edit text-success"></i>
                                    </a>
                                    <a href="{{route('admin.courts.delete',['club' => $club,'court' => $court])}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="حذف">
                                        <i class="la la-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endcomponent

@endsection