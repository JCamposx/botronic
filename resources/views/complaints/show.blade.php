@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Administrar reclamos</h2>

    <h3>Reclamo #{{ $complaint->id }}</h3>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Detalle del reclamo</div>

          <div class="card-body">
            <h4>{{ $complaint->title }}</h4>

            <h5>{{ $complaint->message }}</h4>

            <div class="card mt-3">
              <div class="card-header">Información del usuario</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">
                    <h5>{{ $user->name }}</h5>
                    <h5>{{ $user->email }}</h5>
                  </div>

                  <div class="col-md-3">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                      Ver usuario
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="mt-3 text-center">
          <form method="POST"
            action="{{ route('complaints.destroy', $complaint->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
