<nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="/img/logo.png" alt="Logo" width="24" height="24"
        class="d-inline-block align-text-top me-2">
      <strong>{{ config('app.name', 'Laravel') }}</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">
        <!-- Localization to change language -->
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" v-pre>
            {{ __('messages/navbar.dropdowns.language.title') }}
          </a>

          <div class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('localization', 'es') }}"
              onclick={{ session()->has('localization') &&
              session()->get('localization') === 'es'
                  ? 'event.preventDefault();'
                  : '' }}>
              {{ __('messages/navbar.dropdowns.language.spanish') }}
            </a>
            <a class="dropdown-item" href="{{ route('localization', 'en') }}"
              onclick={{ session()->has('localization') &&
              session()->get('localization') === 'en'
                  ? 'event.preventDefault();'
                  : '' }}>
              {{ __('messages/navbar.dropdowns.language.english') }}
            </a>
          </div>
        </li>

        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">
                {{ __('messages/navbar.auth.login') }}
              </a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">
                {{ __('messages/navbar.auth.register') }}
              </a>
            </li>
          @endif
        @else
          @if (Auth::user()->type === 0)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('suggestions.create') }}">
                {{ __('messages/navbar.suggestions.create') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('complaints.create') }}">
                {{ __('messages/navbar.complaints.create') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('bots.index') }}">
                {{ __('messages/navbar.bots.index') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('bots.create') }}">
                {{ __('messages/navbar.bots.create') }}
              </a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('default-answers.index') }}"
                onclick={{ Route::is('default-answers.index') ? 'event.preventDefault();' : '' }}>
                {{ __('messages/navbar.default_answers.index') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('suggestions.index') }}"
                onclick={{ Route::is('suggestions.index') ? 'event.preventDefault();' : '' }}>
                {{ __('messages/navbar.suggestions.index') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('complaints.index') }}"
                onclick={{ Route::is('complaints.index') ? 'event.preventDefault();' : '' }}>
                {{ __('messages/navbar.complaints.index') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('users.index') }}"
                onclick={{ Route::is('users.index') ? 'event.preventDefault();' : '' }}>
                {{ __('messages/navbar.users.index') }}
              </a>
            </li>
          @endif

          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
              role="button" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false" v-pre>
              {{ __('messages/navbar.dropdowns.profile.title') }}
            </a>

            <div class="dropdown-menu dropdown-menu-end"
              aria-labelledby="navbarDropdown">

              <a class="dropdown-item" href="{{ route('profile.index') }}"
                onclick={{ Route::is('profile.index') ? 'event.preventDefault();' : '' }}>
                {{ __('messages/navbar.dropdowns.profile.check_profile') }}
              </a>

              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('messages/navbar.dropdowns.profile.logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}"
                method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
