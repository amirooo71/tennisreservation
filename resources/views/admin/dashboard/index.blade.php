@extends('layouts.app_admin')

@section('content')

    <a href="{{route('admin.clubs.index')}}">Clubs</a>
    @if(auth()->user()->clubs->count())
        <a href="{{route('admin.courts.index',auth()->user()->clubs->first())}}">Courts</a>
    @endif

@endsection