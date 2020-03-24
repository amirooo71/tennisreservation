@extends('layouts.app_admin')

@section('content')

    <a href="{{route('admin.clubs.index')}}">Clubs</a>
    <a href="{{route('admin.courts.index',auth()->user()->clubs->first())}}">Courts</a>

@endsection