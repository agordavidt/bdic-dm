<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('devices.index') ? 'active' : '' }}" href="{{ route('devices.index') }}">
        <i class="fas fa-mobile-alt"></i>
        Device Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.inventory.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-boxes"></i>
        Inventory
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.sales.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-shopping-cart"></i>
        Sales
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-clipboard-list"></i>
        Orders
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.customers.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-user-friends"></i>
        Customers
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('vendor.reports.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-chart-bar"></i>
        Reports
    </a>
</li>
