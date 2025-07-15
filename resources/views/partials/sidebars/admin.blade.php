<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-crown"></i>
        Admin Dashboard
    </a>
</li> -->

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-users"></i>
        User Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
        <i class="fas fa-box"></i>
        Product Catalog
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
        <i class="fas fa-shopping-cart"></i>
        Order Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}" href="{{ route('admin.analytics.index') }}">
        <i class="fas fa-chart-line"></i>
        Analytics
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('devices.index') ? 'active' : '' }}" href="{{ route('devices.index') }}">
        <i class="fas fa-mobile-alt"></i>
        Device Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.faults.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-exclamation-triangle"></i>
        Report Fault
    </a>
</li>