@extends('layouts.app_admin')


@section('content')

    <a href="{{route('admin.fix_bookings.create')}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>

    @component('components.portletWithoutFooter',['title' => 'لیست فیکسی'])

        <table class="table table-bordered table-hover" id="datatbl">
            <thead>
            <tr>
                <th scope="col">رزرو کننده</th>
                <th scope="col">روز</th>
                <th scope="col">ساعت</th>
                <th scope="col">نام پارتنر</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fixBookings as $fix)
                <tr>
                    <td>{{$fix->coach_id ? $fix->coach->full_name : $fix->renter_name}}</td>
                    <td>{{$fix->day}}</td>
                    <td>@faNum($fix->time,false)</td>
                    <td>{{$fix->partner_name ?? '-'}}</td>
                    <td>
                        <a href="{{route('admin.fix_bookings.edit',$fix)}}"
                           class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ویرایش">
                            <i class="la la-edit text-success"></i>
                        </a>
                        <a href="{{route('admin.fix_bookings.delete',$fix)}}"
                           class="btn btn-sm btn-clean btn-icon btn-icon-md" title="حذف">
                            <i class="la la-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{$fixBookings->links()}}</div>

    @endcomponent


@endsection
