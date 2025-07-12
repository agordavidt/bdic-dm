<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li> -->
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}" href="{{ route('vendor.products.index') }}">
        <i class="fas fa-box"></i>
        My Products
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.inventory.*') ? 'active' : '' }}" href="{{ route('vendor.inventory.index') }}">
        <i class="fas fa-warehouse"></i>
        Inventory
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}" href="{{ route('vendor.orders.index') }}">
        <i class="fas fa-shopping-cart"></i>
        Orders
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.analytics.*') ? 'active' : '' }}" href="{{ route('vendor.analytics.index') }}">
        <i class="fas fa-chart-line"></i>
        Analytics
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.reports.*') ? 'active' : '' }}" href="{{ route('vendor.reports.sales') }}">
        <i class="fas fa-file-alt"></i>
        Reports
    </a>
</li>
