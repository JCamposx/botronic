@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Respuesta personalizada para {{ $bot->name }}</h3>

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('bots.customize.store', $bot->id) }}">
      @csrf

      <div class="row justify-content-center mt-3">
        <div class="col-md-8">

          <div class="card mb-3">
            <div class="card-header">Detalle</div>

            <div class="card-body">
              <div class="row mb-3">
                <label for="question" class="col-md-4 col-form-label text-md-end">
                  Pregunta
                </label>

                <div class="col-md-6">
                  <input id="question" type="text"
                    class="form-control @error('question') is-invalid @enderror"
                    name="question" value="{{ old('question') }}"
                    autocomplete="question" autofocus>

                  @error('question')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="answer" class="col-md-4 col-form-label text-md-end">
                  Respuesta
                </label>

                <div class="col-md-6">
                  <input id="answer" type="text"
                    class="form-control @error('answer') is-invalid @enderror"
                    name="answer" value="{{ old('answer') }}"
                    autocomplete="answer">

                  @error('answer')
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
