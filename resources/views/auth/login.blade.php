@extends('layouts.app')

@section('content')
  <div class="background-image"></div>
  <div class="container center">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card pt-4 pb-4">
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex justify-content-center align-items-center">
                <img src="/img/logo.png" style="width: 6rem;">
              </div>

              <div class="d-flex justify-content-center align-items-center">
                <h4>Inicio de sesión</h4>
              </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="row mb-3">
                <label for="email"
                  class="col-md-4 col-form-label text-md-end">Email</label>

                <div class="col-md-6">
                  <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    autocomplete="email" autofocus>

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">
                  Contraseña
                </label>

                <div class="col-md-6">
                  <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" autocomplete="current-password">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                      name="remember" id="remember"
                      {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                      Mantener sesión iniciada
                    </label>
                  </div>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Iniciar sesión
                  </button>

                  <a class="btn btn-link text-decoration-none"
                    href="{{ route('register') }}">
                    También puede registrarse
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
