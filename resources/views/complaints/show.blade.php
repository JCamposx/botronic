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
            <h4>
              Titulo <br>
              {{ $complaint->title }}
            </h4>

            <h5>
              Mensaje <br>
              {{ $complaint->message }}
            </h5>

            <h6>
              Fecha de creación:
              {{ date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($complaint->created_at->format('Y-m-d H:i:s')))) }}
            </h6>

            <h6>Estado: {{ $complaint->status ? 'Cerrado' : 'Abierto' }}</h6>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">Información del usuario</div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <h5>Nombre: {{ $user->name }}</h5>
                <h5>Email: {{ $user->email }}</h5>
              </div>

              <div class="col-md-3">
                <a href="{{ route('users.edit', $user->id) }}"
                  class="btn btn-primary">
                  Ver usuario
                </a>
              </div>
            </div>

          </div>
        </div>

        <div class="text-center">
          <form method="POST"
            action="{{ route('complaints.update', $complaint->id) }}">
            @csrf
            @method('PUT')

            <button class="btn btn-dark" type="submit">Cambiar estado</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
