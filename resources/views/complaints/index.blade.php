@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Administrar reclamos</h2>

    {{ $complaints->links() }}

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <div class="row justify-content-center">
      @if (count($complaints) === 0)
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>No hay reclamos</p>
          </div>
        </div>
      @else
        <table class="table table-hover table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Titulo</th>
              <th scope="col">Mensaje</th>
              <th scope="col">Estado</th>
              <th scope="col"></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($complaints as $complaint)
              <tr>
                <td>{{ $complaint->id }}</td>

                <td>
                  {{ strlen($complaint->title) <= 30
                      ? $complaint->title
                      : substr($complaint->title, 0, 30) . '...' }}
                </td>

                <td>
                  {{ strlen($complaint->message) <= 180
                      ? $complaint->message
                      : substr($complaint->message, 0, 180) . '...' }}
                </td>

                <td>{{ $complaint->status ? 'Cerrado' : 'Abierto' }}</td>

                <td>
                  <div class="d-flex justify-content-end">
                    <div class="me-2">
                      <a href="{{ route('complaints.show', $complaint->id) }}"
                        class="btn btn-primary">Ver detalle</a>
                    </div>

                    <div>
                      <form method="POST"
                        action="{{ route('complaints.update', $complaint->id) }}">
                        @csrf
                        @method('PUT')

                        <button class="btn btn-dark" type="submit">Cambiar
                          estado</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
