@extends('layouts.app')

@section('title')
   Главная
@endsection

@section('content')
    @auth
        <form action="{{route('logout')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Logout">
        </form>
    @endauth
@endsection
