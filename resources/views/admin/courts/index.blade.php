@extends('layouts.app')

@section('content')


    <a href="{{route('admin.courts.create',$club)}}">Add court</a>
    <hr>
    <ul>
        @foreach($club->courts as $court)
            <li>{{$court->name}} <a href="{{route('admin.courts.edit',compact('club','court'))}}">edit</a></li>
            <form action="{{route('admin.courts.delete',compact('club','court'))}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit">delete</button>
            </form>
        @endforeach
    </ul>

@endsection