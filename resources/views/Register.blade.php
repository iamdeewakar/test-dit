@extends('layouts.app')

@section('main')

    <h1> User Registeration </h1>
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{route('user.register')}}"> 
        @csrf
        <div>
            <label for="name"> Name: </label>
            <input type="text" name="name" id="name" value="" required>
        </div>

        <div>
            <label for="email"> Email </label>
            <input type="email" name="email" value="" required>
        </div>

        <div>
            <label for="password"> password </label>
            <input type="password" name="password" value="" required>
        </div>

        <div>
            <button type="submit"> Register </button>

        </div>
    </form>

@endsection