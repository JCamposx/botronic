@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Editar perfil</h2>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('profile.update', $user->id) }}">
              @csrf
              @method('PATCH')

              <div class="row mb-3">
                <label for="allowed_bots"
                  class="col-md-4 col-form-label text-md-end">
                  Nombre
                  {{ $user->id }}
                </label>

                <div class="col-md-6">
                  <input id="name" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') ?? $user->name }}" autocomplete="name">

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="allowed_bots"
                  class="col-md-4 col-form-label text-md-end">
                  Email
                </label>

                <div class="col-md-6">
                  <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') ?? $user->email }}"
                    autocomplete="email">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="allowed_bots"
                  class="col-md-4 col-form-label text-md-end">
                  Bots permitidos
                </label>

                <div class="col-md-6">
                  <input id="allowed_bots" name="allowed_bots" type="number"
                    class="form-control @error('allowed_bots') is-invalid @enderror"
                    value="{{ $user->allowed_bots }}" readonly disabled
                    autocomplete="allowed_bots">
                </div>
              </div>

              <div class="row mb-3">
                <label for="allowed_bots"
                  class="col-md-4 col-form-label text-md-end">
                  Bots creados
                </label>

                <div class="col-md-6">
                  <input id="created_bots" name="created_bots" type="number"
                    class="form-control @error('created_bots') is-invalid @enderror"
                    value="{{ $user->created_bots }}" readonly disabled
                    autocomplete="created_bots">
                </div>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary">
                  Guardar cambios
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
