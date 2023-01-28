@extends('layouts.app')

@section('main')
<form class="m-auto form-signin text-center" method="post" action="{{route('login')}}">
    @csrf
    <h1 class="h3 mb-3 fw-normal" 1>welcome</h1>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
</form>


@endsection