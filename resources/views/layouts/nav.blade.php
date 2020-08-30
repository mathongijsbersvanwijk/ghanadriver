<!-- Right side of navbar -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('createyourown') }}">Create your own</a>
    </li>
    <li class="nav-item dropdown">
        <a id="testsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Members tests <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="testsDropdown">
            <a class="dropdown-item" href="{{ route('tests.all') }}">Do a test</a>
            <a class="dropdown-item" href="{{ route('tests.results') }}">Popularity</a>
        </div>
    </li>
    <!-- li class="nav-item">
        <a class="nav-link" href="{{ route('dvla') }}">DVLA</a>
    </li -->
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @if(Auth::user()->role->id > 1)
                    <a class="dropdown-item" href="{{ route('questions.index') }}">Questions I created</a>
                    <a class="dropdown-item" href="{{ route('tests.index') }}">Tests I created</a>
                @else
                    <a class="dropdown-item" href="{{ route('admin.questions.index') }}">Status questions</a>
                @endif
            </div>
        </li>
    @endguest
</ul>
