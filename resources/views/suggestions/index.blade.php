@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Administrar sugerencias</h2>

    {{ $suggestions->links() }}

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
      @if (count($suggestions) === 0)
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>No hay sugerencias</p>
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
            @foreach ($suggestions as $suggestion)
              <tr>
                <td>{{ $suggestion->id }}</td>

                <td>
                  {{ strlen($suggestion->title) <= 30
                      ? $suggestion->title
                      : substr($suggestion->title, 0, 30) . '...' }}
                </td>

                <td>
                  {{ strlen($suggestion->message) <= 180
                      ? $suggestion->message
                      : substr($suggestion->message, 0, 180) . '...' }}
                </td>

                <td>{{ $suggestion->status ? 'Cerrado' : 'Abierto' }}</td>

                <td>
                  <div class="d-flex justify-content-end">
                    <div class="me-2">
                      <a href="{{ route('suggestions.show', $suggestion->id) }}"
                        class="btn btn-primary">Ver detalle</a>
                    </div>

                    <div>
                      <form method="POST"
                        action="{{ route('suggestions.update', $suggestion->id) }}">
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
