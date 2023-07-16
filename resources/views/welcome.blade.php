@extends('layouts.app')

@section('content')
  @vite(['resources/js/welcome.js'])

  <div class="background-image"></div>

  <div class="welcome d-flex justify-content-center align-items-center">
    <div class="text-center">
      <h1>{{ __('messages/texts.welcome') }}</h1>
      <a class="btn btn-lg btn-secondary" href="{{ route('login') }}">
        {{ __('messages/buttons.start') }}
      </a>
    </div>
  </div>
@endsection
