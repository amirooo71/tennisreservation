@extends('layouts.app')


@section('content')




    <div class="container">
        Create court
        <hr>
        <div class="row">

                <form class="col-md-6" action="{{route('admin.courts.store',$club)}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input class="form-control" type="text" name="name">
                    </div>

                    <div class="form-group">
                        <select name="type" class="form-control">
                            <option value="clay">Clay</option>
                            <option value="hard">Hard</option>
                            <option value="grass">Grass</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" name="price" class="form-control">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="is_indoor"> Indoor
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="is_center"> Center court
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>

                </form>

        </div>
    </div>

@endsection