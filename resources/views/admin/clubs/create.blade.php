@extends('layouts.app')


@section('content')




    <div class="container">
        Create court
        <hr>


        <form action="{{route('admin.clubs.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <textarea name="description" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="number" name="courts_count" class="form-control">
            </div>
            <div class="form-group">
                <input type="time" name="opening_time" class="form-control">
            </div>
            <div class="form-group">
                <input type="time" name="closing_time" class="form-control">
            </div>
            <button type="submit">save</button>

        </form>

    </div>


@endsection