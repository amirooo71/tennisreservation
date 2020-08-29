@extends('layouts.app_admin')

@section('content')

    @component('components.portletWithoutFooter',['title' => $player->first_name . ' ' . $player->last_name])
        <ul class="nav nav-tabs  nav-tabs-line" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" role="tab">مشخصات</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="tab">کلاس ها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_3" role="tab">پرداختی ها</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>نام و نام خانوادگی</label>
                            <input readonly class="form-control" type="text" value="{{$player->first_name . ' ' . $player->last_name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>شماره تماس یک</label>
                            <input readonly class="form-control" type="text" value="{{$player->contact_number_one}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>شماره تماس دو</label>
                            <input readonly class="form-control" type="text" value="{{$player->contact_number_two}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>هزینه کلاس</label>
                            <input readonly class="form-control" type="text" value="{{$player->learning_price . ' تومان'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سن</label>
                            <input readonly class="form-control" type="text" value="{{$player->age}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ایمیل</label>
                            <input readonly class="form-control" type="text" value="{{$player->email}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>جنسیت</label>
                            <input readonly class="form-control" type="text" value="{{$player->gender === 'male' ? 'پسر' : 'دختر'}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>بیوگرافی</label>
                            <textarea class="form-control" readonly cols="30" rows="10">
                                {{$player->bio}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
            </div>
        </div>
    @endcomponent

@endsection
