@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-10">
        <h2>{{ __('messages/texts.bots.show.title') }} {{ $bot->name }}</h2>
      </div>

      <div class="col-md-2">
        <a class="btn btn-primary" href="{{ route('bots.edit', $bot->id) }}">
          {{ __('messages/buttons.bots.show.edit') }}
        </a>
      </div>
    </div>

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
      @if (count($user_answers[0]) === 0 && count($table_answers[0]) === 0)
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>{{ $bot->name }} {{ __('messages/texts.bots.show.no_stats') }}
            </p>
            <p>{{ __('messages/texts.bots.show.start_talk') }}</p>
          </div>
        </div>
      @endif

      @if (count($user_answers[0]) !== 0)
        <div class="col-md-6">
          <pie-chart
            :labels="[{{ "'" . implode("','", $user_answers[0]) . "'" }}]"
            :data="[{{ "'" . implode("','", $user_answers[1]) . "'" }}]"
            :title="'{{ __('messages/texts.bots.show.no_answer_bots') }}'" />
        </div>
      @endif

      @if (count($table_answers[0]) !== 0)
        <div class="col-md-6">
          <pie-chart
            :labels="[{{ "'" . implode("','", $table_answers[0]) . "'" }}]"
            :data="[{{ "'" . implode("','", $table_answers[1]) . "'" }}]"
            :title="'{{ __('messages/texts.bots.show.most_consulted_tables') }}'" />
        </div>
      @endif
    </div>

    <div class="mt-4">
      <div class="row">
        <div class="col-md-10">
          <h3>{{ __('messages/texts.bots.show.custom_answers') }}</h3>
        </div>

        <div class="col-md-2">
          <a class="btn btn-primary"
            href="{{ route('bots.customize.create', $bot->id) }}">
            {{ __('messages/buttons.bots.show.new') }}
          </a>
        </div>
      </div>

      @if (count($custom_answers) === 0)
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="card card-body text-center">
              <p>{{ $bot->name }} {{ __('messages/texts.bots.show.no_custom_answers') }}</p>
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
            @foreach ($custom_answers as $custom_answer)
              <tr>
                <td>{{ $custom_answer->id }}</td>

                <td>{{ $custom_answer->question }}</td>

                <td>{{ $custom_answer->answer }}</td>

                <td>
                  <div class="d-flex justify-content-end">
                    <div class="me-2">
                      <a class="btn btn-primary"
                        href="{{ route('bots.customize.edit', [$bot->id, $custom_answer->id]) }}">
                        Editar
                      </a>
                    </div>

                    <div>
                      <form method="POST"
                        action="{{ route('bots.customize.destroy', [$bot->id, $custom_answer->id]) }}">
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

  <script>
    var botmanWidget = {
      title: '{{ $bot->name }}',
      aboutText: "Escriba algo",
      introMessage: "{{ $bot->greeting }}<br><br>Dime algo para empezar la conversación!"
    };
  </script>

  <script
    src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'>
  </script>
@endsection
