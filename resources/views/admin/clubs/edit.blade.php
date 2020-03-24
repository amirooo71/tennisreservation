@extends('layouts.app')


@section('content')




    <div class="container">
        Create court
        <hr>


        <form action="{{route('admin.clubs.update',$club)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <input type="text" name="name" class="form-control" value="{{$club->name}}">
            </div>
            <div class="form-group">
                <textarea name="description" cols="30" rows="10" class="form-control">{{$club->description}}</textarea>
            </div>
            <div class="form-group">
                <input type="number" name="courts_count" class="form-control" value="{{$club->courts_count}}">
            </div>
            <div class="form-group">
                <input type="time" name="opening_time" class="form-control" value="{{$club->opening_time}}">
            </div>
            <div class="form-group">
                <input type="time" name="closing_time" class="form-control" value="{{$club->closing_time}}">
            </div>
            <button type="submit">save</button>

        </form>

    </div>


@endsection