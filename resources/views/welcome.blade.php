@extends('layouts.app')

@section('content')
  <div class="background-image"></div>
  <div class="welcome d-flex justify-content-center align-items-center">
    <div class="text-center">
      <h1>Comienza a crear tu chatbot</h1>
      <a class="btn btn-lg btn-secondary" href="{{ route('login') }}">
        Empezar
      </a>
    </div>
  </div>
@endsection
