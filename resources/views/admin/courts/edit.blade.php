@extends('layouts.app_admin')


@section('content')

    <div class="row">
        <form class="col-md-6" action="{{route('admin.courts.update',compact('club','court'))}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <input class="form-control" type="text" name="name" value="{{$court->name}}">
            </div>

            <div class="form-group">
                <select name="type" class="form-control">
                    <option value="clay">Clay</option>
                    <option value="hard">Hard</option>
                    <option value="grass">Grass</option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="price" class="form-control" value="{{$court->price}}">
            </div>

            <div class="form-group">
                <input type="checkbox" name="is_indoor" {{$court->is_indoor === 1 ? 'checked' : ''}}> Indoor
            </div>

            <div class="form-group">
                <input type="checkbox" name="is_center" {{$court->is_center === 1 ? 'checked' : ''}}> Center court
            </div>

            <button type="submit" class="btn btn-primary">Save</button>

        </form>
    </div>

@endsection