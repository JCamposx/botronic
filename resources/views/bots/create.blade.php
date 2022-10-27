@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Nuevo bot</h3>

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('bots.store') }}">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-8">

          {{-- Información del bot --}}
          <div class="card mb-3">
            <div class="card-header">Información del bot</div>

            <div class="card-body">
              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">Nombre del
                  bot</label>

                <div class="col-md-6">
                  <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" autocomplete="name"
                    autofocus>

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
                    name="description" value="{{ old('description') }}"
                    autocomplete="description">

                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="greeting"
                  class="col-md-4 col-form-label text-md-end">Saludo</label>

                <div class="col-md-6">
                  <input id="greeting" type="text"
                    class="form-control @error('greeting') is-invalid @enderror"
                    name="greeting" value="{{ old('greeting') }}"
                    autocomplete="greeting" autofocus>

                  @error('greeting')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- Información de la base de datos a conectarse --}}
          <div class="card mb-3">
            <div class="card-header">Información de la base de datos</div>

            <div class="card-body">
              <div class="row mb-3">
                <label for="ip"
                  class="col-md-4 col-form-label text-md-end">IP</label>

                <div class="col-md-6">
                  <input id="ip" type="text" maxlength="15"
                    class="form-control @error('ip') is-invalid @enderror"
                    name="ip" value="{{ old('ip') }}" autocomplete="ip">

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
                    name="username" value="{{ old('username') }}"
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
                    name="db_name" value="{{ old('db_name') }}"
                    autocomplete="db_name" autofocus>

                  @error('db_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="table_names"
                  class="col-md-4 col-form-label text-md-end">Nombre de las
                  tablas</label>

                <div class="col-md-6">
                  <input id="table_names" type="text"
                    class="form-control @error('table_names') is-invalid @enderror"
                    name="table_names" value="{{ old('table_names') }}"
                    autocomplete="table_names" autofocus>

                  @error('table_names')
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
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
