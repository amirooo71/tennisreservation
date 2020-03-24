@extends('layouts.app')

@section('content')


    <div class="container">

        Dashboard
        <hr>

        <a href="{{route('admin.clubs.index')}}">Clubs</a>
        <a href="{{route('admin.courts.index',auth()->user()->clubs->first())}}">Courts</a>

    </div>

@endsection