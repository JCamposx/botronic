@extends('layouts.app')

@section('content')
  <div class="container">
    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <h2>Ver mi perfil</h2>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="row text-center">
              <h4>{{ $user->name }}</h4>
              <h5>{{ $user->email }}</h5>
              <h6>Bots permitidos: {{ $user->allowed_bots }}</h6>
              <h6>Bots creados: {{ $user->created_bots }}</h6>
            </div>

            <div class="text-center mt-2">
              <a class="btn btn-primary" href="{{ route('profile.edit') }}">
                Editar perfil
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
