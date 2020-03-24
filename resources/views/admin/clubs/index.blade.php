@extends('layouts.app')

@section('content')

    <h2>Clubs</h2>
    <hr>

    @if($club)
        <h4>{{$club->name}}</h4>
        <a href="{{route('admin.courts.create',$club)}}">add court</a>
        <a href="{{route('admin.clubs.edit',$club)}}">edit</a>
        <form action="{{route('admin.clubs.delete',$club)}}" method="POST">
            @method('DELETE')
            @csrf
                <button type="submit">delete</button>
        </form>
        @else
        <a href="{{route('admin.clubs.create')}}">Add Club</a>
    @endif

@endsection