@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>{{ __('messages/texts.bots.index.title') }}</h3>

    {{ $bots->links() }}

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <div class="row">
      <div class="row justify-content-center">
        @forelse ($bots as $bot)
          <div class="col-md-6 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title text-capitalize">
                  {{ $bot->name }}
                </h3>

                <p>{{ $bot->description }}</p>

                <a href="{{ route('bots.show', $bot->id) }}"
                  class="btn btn-primary mb-2 me-2">
                  {{ __('messages/buttons.bots.index.try') }}
                </a>

                <a href="{{ route('bots.edit', $bot->id) }}"
                  class="btn btn-secondary mb-2">
                  {{ __('messages/buttons.bots.index.edit') }}
                </a>

                <form action="{{ route('bots.destroy', $bot->id) }}"
                  method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" href="#" class="btn btn-danger mb-2">
                    {{ __('messages/buttons.bots.index.delete') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="col-md-4">
            <div class="card card-body text-center">
              <p>{{ __('messages/texts.bots.index.empty_bots') }}</p>
              <a class="btn btn-primary" href="/bots/create">
                {{ __('messages/buttons.bots.index.create') }}
              </a>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
@endsection
