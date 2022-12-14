<nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="/img/logo.png" alt="Logo" width="24" height="24"
        class="d-inline-block align-text-top">
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
        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Iniciar
                sesión</a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
            </li>
          @endif
        @else
          @if (Auth::user()->type === 0)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('complaints.create') }}">
                Nuevo reclamo
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('bots.index') }}">Mis bots</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('bots.create') }}">Nuevo bot</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('default-answers.index') }}"
                onclick={{ Route::is('default-answers.index') ? 'event.preventDefault();' : '' }}>
                Ver respuestas predeterminadas
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('complaints.index') }}"
                onclick={{ Route::is('complaints.index') ? 'event.preventDefault();' : '' }}>
                Ver reclamos
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('users.index') }}"
                onclick={{ Route::is('users.index') ? 'event.preventDefault();' : '' }}>
                Ver usuarios
              </a>
            </li>
          @endif

          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
              role="button" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end"
              aria-labelledby="navbarDropdown">

              <a class="dropdown-item" href="{{ route('profile.index') }}"
                onclick={{ Route::is('profile.index') ? 'event.preventDefault();' : '' }}>
                Ver mi perfil
              </a>

              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Cerrar sesión
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
