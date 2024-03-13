
@extends('layouts.app')

@section('main')

    <h1>Login Page</h1>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
            </ul>        
        </div>
    @endif

        <form action="{{route('user.login')}}" method="post">
            @csrf
            <div>
                <label for="">Email</label>
                <input name="email" value="" type="email">
            </div>

            <div>
                <label for="password"> Password</label>
                <input type="password" name="password" value="" >
            </div>
            @if ($errors->has('password'))
                    <div>{{ $errors->first('password') }}</div>
            @endif


            <div>
                <button type="submit"> Submit</button>
            </div>
            
        </form>


@endsection