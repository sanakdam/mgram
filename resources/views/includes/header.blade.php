<header class="col col-md-3 col-md-offset-5">
  <nav class="navbar navbar-default navbar-fixed-top">
  <div style="background-color: #CE433F;" class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
          <div class="navbar-header">
            <a class="navbar-brand" style="color: white;" href="{{ route('dashboard') }}">BBMIN</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              @if(Auth::user())
                <li class="dropdown">
                    <a class="dropdown-toggle" style="color: white; font-size: 20px;" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->username }} <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                      <li><a href="{{ route('account') }}">Account</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                 </li>

              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
</header>