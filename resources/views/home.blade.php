@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @forelse ($bots as $bot)
        <div class="col-md-4 mb-3 mx-auto">
          <div class="card text-center">
            <div class="card-body">
              <a class="text-decoration-none text-white"
                href="{{ route('bots.show', $bot->id) }}">
                <h3 class="card-title text-capitalize">
                  {{ $bot->name }}
                </h3>
              </a>

              <p>{{ $bot->description }}</p>

              <a href="{{ route('bots.edit', $bot->id) }}"
                class="btn btn-secondary mb-2">Editar</a>

              <form action="{{ route('bots.destroy', $bot->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" href="#"
                  class="btn btn-danger mb-2">Borrar</button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-md-4 mx-auto">
          <div class="card card-body text-center">
            <p>No cuenta todavía con ningún bot</p>
            <a class="btn btn-primary" href="/bots/create">Cree uno!</a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
@endsection
