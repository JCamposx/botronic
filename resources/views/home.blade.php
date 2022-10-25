@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bienvenido a la pagina principal, a continuacion se le mostrara los bots predeterminados para su negocio') }}
                </div>
            </div>
        </div>
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css" type="text/css">
            <script>
                var botmanWidget={
                        aboutText:"Bienvenido",
                        introMessage:"Escriba Hola para empezar "
                }
            </script>
        
        <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
    </div>
</div>
@endsection
