@extends('layouts.app')

@section('content')
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
