@extends('layouts.app')

@section('content')


    <a href="{{route('admin.courts.create',$club)}}">Add court</a>
    <hr>
    <ul>
        @foreach($club->courts as $court)
            <li>{{$court->name}}</li>
        @endforeach
    </ul>

@endsection