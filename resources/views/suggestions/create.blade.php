@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Nueva sugerencia</h3>

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('suggestions.store') }}">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-header">Información de la sugerencia</div>

            <div class="card-body">
              <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label text-md-end">
                  Titulo
                </label>

                <div class="col-md-6">
                  <input id="title" type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    name="title" value="{{ old('title') }}"
                    autocomplete="title" autofocus>

                  @error('title')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="message"
                  class="col-md-4 col-form-label text-md-end">Mensaje</label>

                <div class="col-md-6">
                  <textarea id="message" type="text" rows="7" style="resize:none;"
                    class="form-control @error('message') is-invalid @enderror"
                    name="message" value="{{ old('message') }}"
                    autocomplete="message" autofocus>
                  </textarea>

                  @error('message')
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
