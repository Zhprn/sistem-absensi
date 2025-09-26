<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
        </form>
        <ul class="navbar-nav navbar-right">
          @if (Auth::check())
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Akun</div>
              <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
            
              <div class="dropdown-divider"></div>
              
                <a href="#" class="dropdown-item has-icon text-danger" onclick="document.getElementById('postForm').submit();">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="postForm" action="{{ route('logout') }}" method="post" style="display: none">
                  @csrf
                </form>
               
            </div>
            @endif
          </li>
        </ul>
      </nav>