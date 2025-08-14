
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-3">
       <img src="{{ asset('img/persa-logo.png') }}" class="img-fluid navbar-brand-img" style="max-height: 100px;" alt="main_logo">
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">

        @can('coordinador')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Usuarios</span>
          </a>
        </li>
        @endcan

        @can('aprendiz')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}" href="{{ route('permission.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-folder text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Permisos</span>
          </a>
        </li>
        @endcan

        @can('coordinador')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('permission_type.*') ? 'active' : '' }}" href="{{ route('permission_type.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-folder-open text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tipo de permiso</span>
          </a>
        </li>
        @endcan
        
        @can('administrador')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('career.*') ? 'active' : '' }}" href="{{ route('career.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users-viewfinder text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Programa</span>
          </a>
        </li>
        @endcan
        
        @can('coordinador')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('location.*') ? 'active' : '' }}" href="{{ route('location.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-search text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sede</span>
          </a>
        </li>
        @endcan
        
        @can('coordinador')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('course.*') ? 'active' : '' }}" href="{{ route('course.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-book-open text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Grupos</span>
          </a>
        </li>
        @endcan

        @can('coordinador-instructor')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-warning text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Reportes</span>
          </a>
        </li>
        @endcan


        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Cuenta</h6>
        </li>

        @canany(['coordinador-instructor','aprendiz'])
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('auth*') ? 'active' : '' }}" href="{{ route('user.profile') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Perfil</span>
          </a>
        </li>
        @endcanany

        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Cerrar sesión</span>
            </a>
        </li>
      </ul>
    </div>    
  </aside>