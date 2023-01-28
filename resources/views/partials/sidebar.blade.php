<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ config('app.name') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
  </div>
  <ul class="sidebar-menu">
      <li class="menu-header">Menu</li>

      @can('dashboard-access')
          <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a href="{{ url('dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
      @endcan

      @can('company-access')
      <li class="{{ request()->is('companies') ? 'active' : '' }}"><a href="{{ url('companies') }}"><i class="fas fa-building"></i> <span>UMKM</span></a></li>
      @endcan

      @can('company-profile')
      <li class="{{ request()->is('companies/profile') ? 'active' : '' }}"><a href="{{ url('companies/profile') }}"><i class="fas fa-building"></i> <span>Profil UMKM</span></a></li>
      @endcan

      @can('category-access')
      <li class="{{ request()->is('categories') ? 'active' : '' }}"><a class="nav-link" href="{{ url('categories') }}"><i class="fas fa-columns"></i> <span>Kategori</span></a></li>
      @endcan

      @can('cashbook-access')
      <li class="{{ request()->is('cash-books') ? 'active' : '' }}"><a href="{{ url('cash-books') }}"><i class="fas fa-table"></i> <span>Pembukuan</span></a></li>
      @endcan

      @can('report-access')
          <li class="{{ request()->is('report') ? 'active' : '' }}"><a href="{{ url('report') }}"><i class="fas fa-file"></i> <span>Report</span></a></li>
      @endcan

      @can('user-access')
      <li class="menu-header">Users</li>
      <li><a class="nav-link {{ request()->is('users') ? 'active' : '' }}" href="{{ url('users') }}"><i class="fas fa-users"></i> <span>Users</span></a></li>
      @endcan

      @can(['role-access', 'permission-access'])
      <li class="menu-header">Roles & Permissions</li>
      <li><a class="nav-link {{ request()->is('roles') ? 'active' : '' }}" href="{{ url('roles') }}"><i class="fas fa-person-booth"></i> <span>Roles</span></a></li>
      <li><a class="nav-link {{ request()->is('permissions') ? 'active' : '' }}" href="{{ url('permissions') }}"><i class="fas fa-person-booth"></i> <span>Permissions</span></a></li>
      @endcan
  </ul>
</aside>
