<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li> -->

<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.devices.*') ? 'active' : '' }}" href="{{ route('vendor.devices.index') }}">
        <i class="fas fa-mobile-alt"></i>
        My Devices
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.fault_reports.*') ? 'active' : '' }}" href="{{ route('vendor.fault_reports.index') }}">
        <i class="fas fa-exclamation-triangle"></i>
        Fault Reports
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}" href="{{ route('vendor.orders.index') }}">
        <i class="fas fa-box"></i>
        Orders
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.analytics.*') ? 'active' : '' }}" href="{{ route('vendor.analytics.index') }}">
        <i class="fas fa-chart-bar"></i>
        Analytics
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}" href="{{ route('vendor.products.index') }}">
        <i class="fas fa-th-list"></i>
        Products
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.reports.*') ? 'active' : '' }}" href="{{ route('vendor.reports.sales') }}">
        <i class="fas fa-file-alt"></i>
        Reports
    </a>
</li> -->



<li class="nav-item nav-category">Vendor Operations</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.devices.*') ? 'active' : '' }}" href="{{ route('vendor.devices.index') }}">
        <i class="menu-icon mdi mdi-cellphone"></i>
        <span class="menu-title">My Devices</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.fault_reports.*') ? 'active' : '' }}" href="{{ route('vendor.fault_reports.index') }}">
        <i class="menu-icon mdi mdi-alert-circle-outline"></i>
        <span class="menu-title">Fault Reports</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}" href="{{ route('vendor.orders.index') }}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Orders</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.analytics.*') ? 'active' : '' }}" href="{{ route('vendor.analytics.index') }}">
        <i class="menu-icon mdi mdi-chart-bar"></i>
        <span class="menu-title">Analytics</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}" href="{{ route('vendor.products.index') }}">
        <i class="menu-icon mdi mdi-view-list"></i>
        <span class="menu-title">Products</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.reports.*') ? 'active' : '' }}" href="{{ route('vendor.reports.sales') }}">
        <i class="menu-icon mdi mdi-file-document"></i>
        <span class="menu-title">Reports</span>
    </a>
</li>
