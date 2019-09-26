@extends('layouts.login')
@section('title' , $name)
@section('content')
    <form class="form-signin" action="Dashboard">
        <h1 class="h3 mb-3 font-weight-normal">Bienvenidos!! a {{ $name }}</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Accedor</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
    </form>

@endsection