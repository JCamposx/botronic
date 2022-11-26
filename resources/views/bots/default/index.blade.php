@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-10">
        <h2>Respuestas predeterminadas</h2>
      </div>

      <div class="col-md-2">
        <a class="btn btn-primary"
          href="{{ route('default-answers.create') }}">Nuevo</a>
      </div>
    </div>

    @if (count($default_answers) === 0)
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>No hay respuestas predeterminadas registradas</p>
          </div>
        </div>
      </div>
    @else
      <table class="table table-hover table-striped align-middle">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Pregunta</th>
            <th scope="col">Respuesta</th>
            <th scope="col"></th>
          </tr>
        </thead>

        <tbody>
          @foreach ($default_answers as $default_answer)
            <tr>
              <td>{{ $default_answer->id }}</td>

              <td>{{ $default_answer->question }}</td>

              <td>{{ $default_answer->answer }}</td>

              <td>
                <div class="d-flex justify-content-end">
                  <div class="me-2">
                    <a class="btn btn-primary"
                      href="{{ route('default-answers.edit', 1) }}">
                      Editar
                    </a>
                  </div>

                  <div>
                    <form method="POST"
                      action="{{ route('default-answers.destroy', $default_answer->id) }}">
                      @csrf
                      @method('DELETE')

                      <button class="btn btn-danger"
                        type="submit">Borrar</button>
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
@endsection
