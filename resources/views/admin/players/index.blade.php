@extends('layouts.app_admin')

@section('content')

    <a href="{{route('admin.players.create')}}" class="btn btn-light btn-elevate mb-3">اضافه کردن</a>

    @component('components.portletWithoutFooter',['title' => 'لیست بازیکنان'])

        <table class="table table-bordered table-hover" id="datatbl">
            <thead>
            <tr>
                <th scope="col">نام</th>
                <th scope="col">نام خانوادگی</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">جنسیت</th>
                <th scope="col">مالی</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $player)
                <tr>
                    <td>{{$player->first_name}}</td>
                    <td>{{$player->last_name}}</td>
                    <td>{{$player->contact_number_one}}</td>
                    <td>{{$player->gender === 'male' ? 'پسر' : 'دختر'}}</td>
                    <td>
                        <a href="{{route('admin.players.profile',$player)}}">
                            <i class="fas fa-eye"></i>
                            مشاهده
                        </a>
                    </td>
                    <td>
                        <a href="{{route('admin.players.edit',$player)}}"
                           class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ویرایش">
                            <i class="la la-edit text-success"></i>
                        </a>
                        <a href="{{route('admin.players.delete',$player)}}"
                           class="btn btn-sm btn-clean btn-icon btn-icon-md" title="حذف">
                            <i class="la la-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{$players->links()}}</div>
    @endcomponent

@endsection
