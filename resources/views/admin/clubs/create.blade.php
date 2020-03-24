@extends('layouts.app')


@section('content')




    <div class="container">
        Create court
        <hr>


        <form action="{{route('admin.clubs.create')}}" method="POST">
            @csrf

            <input type="text" name="name">
            <textarea name="description" cols="30" rows="10"></textarea>
            <input type="number" name="courts_count">
            <button type="submit">save</button>

        </form>

    </div>


@endsection