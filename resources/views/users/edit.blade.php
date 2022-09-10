@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Editar usuario</h2>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
              @csrf
              @method('PUT')

              <div class="row mb-3 text-center">
                <h4>{{ $user->name }}</h4>
                <h5>{{ $user->email }}</h5>
                <h6>Bots creados: {{ $user->created_bots }}</h6>
              </div>

              <div class="row mb-3">
                <label for="allowed_bots"
                  class="col-md-4 col-form-label text-md-end">
                  Bots permitidos
                </label>

                <div class="col-md-6">
                  <input id="created_bots" name="created_bots" type="hidden"
                    value="{{ $user->created_bots }}" autocomplete="created_bots">

                  <input id="allowed_bots" name="allowed_bots" type="number"
                    class="form-control @error('allowed_bots') is-invalid @enderror"
                    value="{{ old('allowed_bots') ?? $user->allowed_bots }}"
                    autocomplete="allowed_bots">

                  @error('allowed_bots')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-0 mt-4">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Guardar cambios
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
