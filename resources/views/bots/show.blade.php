@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h2>Estadísticas de {{ $bot->name }}</h2>
      </div>

      <div class="col-md-2">
        <a class="btn btn-primary" href="{{ route('bots.edit', $bot->id) }}">Editar</a>
      </div>
    </div>

    <div class="row justify-content-center">
      @if (count($user_answers[0]) !== 0)
        <div class="col-md-6">
          <user-bot-dashboard
            :labels="[{{ "'" . implode("','", $user_answers[0]) . "'" }}]"
            :data="[{{ "'" . implode("','", $user_answers[1]) . "'" }}]"
            :title="'TOP 5 PALABRAS SIN RESPUESTA'" />
        </div>

        <div class="col-md-6">
          <user-bot-dashboard
            :labels="[{{ "'" . implode("','", $table_answers[0]) . "'" }}]"
            :data="[{{ "'" . implode("','", $table_answers[1]) . "'" }}]"
            :title="'TOP 5 TABLAS MÁS CONSULTADAS'" />
        </div>
      @else
        <div class="col-md-4">
          <div class="card card-body text-center">
            <p>{{ $bot->name }} aún no cuenta con estadísticas</p>
            <p> Empiece a hablar con él!</p>
          </div>
        </div>
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
