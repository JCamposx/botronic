@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>{{ __('messages/texts.home.admin.title') }}</h3>

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
          :title="'{{ __('messages/texts.home.admin.most_bots_allowed') }}'" />
      </div>
    </div>

    <div class="row justify-content-center mb-5">
      <div class="col-md-10">
        <bar-chart
          :labels="[{{ "'" . implode("','", $user_bots_created[0]) . "'" }}]"
          :data="[{{ "'" . implode("','", $user_bots_created[1]) . "'" }}]"
          :title="'{{ __('messages/texts.home.admin.most_bots_created') }}'" />
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <pie-chart
          :labels="[{{ "'" . implode("','", $questions_without_answer[0]) . "'" }}]"
          :data="[{{ "'" . implode("','", $questions_without_answer[1]) . "'" }}]"
          :title="'{{ __('messages/texts.home.admin.answers_without_response') }}'" />
      </div>

      <div class="col-md-6">
        <div
          style="color: #666666; font-size: 15px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;">
          <b>{{ __('messages/texts.home.admin.general_information') }}</b>
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
