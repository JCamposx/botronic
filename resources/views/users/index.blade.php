@extends('layouts.app')

@section('content')
  <div class="container">
    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <h2>Administrar usuarios</h2>
    <div class="row justify-content-center">
      @if (count($users) === 0)
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>No hay usuarios registrados</p>
          </div>
        </div>
      @else
        <table class="table table-hover table-striped align-middle text-center">
          <thead>
            <tr>
              <th scope="col">Usuarios</th>
              <th scope="col">Email</th>
              <th scope="col">Bots permitidos</th>
              <th scope="col">Bots credos</th>
              <th scope="col"></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>
                  {{ $user->name }}
                </td>

                <td>
                  {{ $user->email }}
                </td>

                <td>
                  {{ $user->allowed_bots }}
                </td>

                <td>
                  {{ $user->created_bots }}
                </td>

                <td>
                  <div class="d-flex justify-content-end">
                    <div class="me-2">
                      <a href="{{ route('users.edit', $user->id) }}"
                        class="btn btn-primary">Editar</a>
                    </div>

                    <div>
                      <form method="POST"
                        action="{{ route('users.destroy', $user->id) }}">
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
  </div>
@endsection
