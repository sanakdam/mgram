<header>
  <nav class="navbar navbar-default navbar-fixed-top">
  <div style="background-color: #CE433F;" class="container-fluid">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" style="color: white;" href="{{ route('dashboard') }}">BBMIN</a>
      </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::user())
          <li><a style="color: white;" href="{{ route('account') }}">Account</a></li>
          <li><a style="color: white;" href="{{ route('logout') }}">Logout</a></li>
        @endif
      </ul>
    </div>
    </div>
  </div>
</nav>
</header>