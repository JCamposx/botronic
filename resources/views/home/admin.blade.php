@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Dashboard</h3>

    @if (session('alert'))
      <div
        class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
        role="alert">
        {{ session('alert')['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
          aria-label="Close"></button>
      </div>
    @endif

    <div class="row justify-content-center mb-5">
      <div class="col-md-10">
        <bar-chart
          :labels="[{{ "'" . implode("','", $user_bots_allowed[0]) . "'" }}]"
          :data="[{{ "'" . implode("','", $user_bots_allowed[1]) . "'" }}]"
          :title="'USUARIOS CON MÁS BOTS PERMITIDOS'" />
      </div>
    </div>

    <div class="row justify-content-center mb-5">
      <div class="col-md-10">
        <bar-chart
          :labels="[{{ "'" . implode("','", $user_bots_created[0]) . "'" }}]"
          :data="[{{ "'" . implode("','", $user_bots_created[1]) . "'" }}]"
          :title="'USUARIOS CON MÁS BOTS CREADOS'" />
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <pie-chart
          :labels="[{{ "'" . implode("','", $questions_without_answer[0]) . "'" }}]"
          :data="[{{ "'" . implode("','", $questions_without_answer[1]) . "'" }}]"
          :title="'INPUTS DEL USUARIO SIN RESPUESTA'" />
      </div>

      <div class="col-md-6">
        <div
          style="color: #666666; font-size: 15px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;">
          <b>INFORMACIÓN GENERAL</b>
        </div>

        <div class="row justify-content-center">
          @foreach ($db_info as $info)
            <div class="col-md-7">
              <div class="card card-body text-center mt-3">
                <b>{{ $info['field'] }}: {{ $info['quantity'] }}</b>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
