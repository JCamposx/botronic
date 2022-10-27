@extends('layouts.app')

@section('content')
  <script>
    var botmanWidget = {
      title: '{{ $bot->name }}',
      aboutText: "Escriba algo",
      introMessage: "{{ $bot->greeting }}"
    };
  </script>

  <script
    src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'>
  </script>
@endsection
