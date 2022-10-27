@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Editar bot</h3>

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('bots.update', $bot->id) }}">
      @csrf
      @method('PUT')

      <div class="row justify-content-center">
        <div class="col-md-8">

          {{-- Datos del bot --}}
          <div class="card mb-3">
            <div class="card-header">Datos del bot</div>

            <div class="card-body">

              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">Nombre del
                  bot</label>

                <div class="col-md-6">
                  <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') ?? $bot->name }}"
                    autocomplete="name" autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="description"
                  class="col-md-4 col-form-label text-md-end">Descripción</label>

                <div class="col-md-6">
                  <input id="description" type="text"
                    class="form-control @error('description') is-invalid @enderror"
                    name="description"
                    value="{{ old('description') ?? $bot->description }}"
                    autocomplete="description">

                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- Datos de la base de datos a conectarse --}}
          <div class="card mb-3">
            <div class="card-header">Datos de la base de datos</div>

            <div class="card-body">
              <div class="row mb-3">
                <label for="ip"
                  class="col-md-4 col-form-label text-md-end">IP</label>

                <div class="col-md-6">
                  <input id="ip" type="text" maxlength="15"
                    class="form-control @error('ip') is-invalid @enderror"
                    name="ip" value="{{ old('ip') ?? $bot->ip }}"
                    autocomplete="ip">

                  @error('ip')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="username"
                  class="col-md-4 col-form-label text-md-end">Username</label>

                <div class="col-md-6">
                  <input id="username" type="text"
                    class="form-control @error('username') is-invalid @enderror"
                    name="username"
                    value="{{ old('username') ?? $bot->username }}"
                    autocomplete="username">

                  @error('username')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="password"
                  class="col-md-4 col-form-label text-md-end">Contraseña</label>

                <div class="col-md-6">
                  <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}"
                    autocomplete="password">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="db_name"
                  class="col-md-4 col-form-label text-md-end">Nombre de la
                  BD</label>

                <div class="col-md-6">
                  <input id="db_name" type="text"
                    class="form-control @error('db_name') is-invalid @enderror"
                    name="db_name" value="{{ old('db_name') ?? $bot->db_name }}"
                    autocomplete="db_name" autofocus>

                  @error('db_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
              <button type="submit" class="btn btn-primary">
                Guardar cambios
              </button>

            </div>
            <div class="col-md-6 offset-md-4">
              <a href="{{ route('home') }}"
                class="btn btn-secondary mt-3">Cancelar</a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
