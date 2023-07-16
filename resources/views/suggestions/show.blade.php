@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>{{ __('messages/texts.suggestions.admin_title') }}</h2>

    <h3>
      {{ __('messages/texts.suggestions.admin_show') }} #{{ $suggestion->id }}
    </h3>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">
            {{ __('messages/texts.suggestions.detail') }}
          </div>

          <div class="card-body">
            <h4>
              {{ $suggestion->title }}
            </h4>

            <h5>
              {{ $suggestion->message }}
            </h5>

            <h6>
              {{ __('messages/texts.suggestions.creation_date_info') }}:
              {{ date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($suggestion->created_at->format('Y-m-d H:i:s')))) }}
            </h6>

            <h6>
              {{ __('messages/texts.suggestions.table_status') }}:
              <span class="badge text-dark {{ $suggestion->status ? 'bg-warning' : 'bg-info' }}">
                {{ $suggestion->status
                    ? __('messages/texts.suggestions.status_closed')
                    : __('messages/texts.suggestions.status_open') }}
              </span>
            </h6>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            {{ __('messages/texts.suggestions.user_info') }}
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <h5>
                  {{ __('messages/texts.suggestions.user_info_name') }}:
                  {{ $user->name }}
                </h5>
                <h5>
                  {{ __('messages/texts.suggestions.user_info_email') }}:
                  {{ $user->email }}
                </h5>
              </div>

              <div class="col-md-3">
                <a href="{{ route('users.edit', $user->id) }}"
                  class="btn btn-primary">
                  {{ __('messages/buttons.suggestions.check_user') }}
                </a>
              </div>
            </div>

          </div>
        </div>

        <div class="text-center">
          <form method="POST"
            action="{{ route('suggestions.update', $suggestion->id) }}">
            @csrf
            @method('PUT')

            <button class="btn btn-dark" type="submit">
              {{ __('messages/buttons.suggestions.status') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
