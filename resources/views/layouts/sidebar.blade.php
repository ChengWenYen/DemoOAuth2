<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Demo OAuth 2.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(Auth::user()->picture))
                    <img src="{{ asset('images/avatardefault.png') }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ Auth::user()->picture }}" class="img-circle elevation-2" alt="User Image">
                @endif
                
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (Auth::user()->is_admin)
                    <li class="nav-header">MANAGEMENTS</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.notify.index') }}" class="nav-link @if (Route::is('admin.notify.index')) active @endif">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>
                                LINE Notify
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link @if (Route::is('admin.users.index')) active @endif">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-header">MISCELLANEOUS</li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link @if (Route::is('home')) active @endif">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logoutForm" method="post" action="{{ route('logout') }}" hidden>
                        @csrf
                    </form>
                    <a href="#" class="nav-link" role="button" onclick="$('#logoutForm').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
