<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}" href="{{ route('buyer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li> -->
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}" href="{{ route('buyer.products.index') }}">
        <i class="fas fa-th-list"></i>
        Product Catalog
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}" href="{{ route('buyer.cart.index') }}">
        <i class="fas fa-shopping-cart"></i>
        My Cart
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}" href="{{ route('buyer.orders.index') }}">
        <i class="fas fa-box"></i>
        My Orders
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.devices.index') ? 'active' : '' }}" href="{{ route('buyer.devices.index') }}">
        <i class="fas fa-exclamation-triangle"></i>
        Report Fault
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.fault_reports.*') ? 'active' : '' }}" href="{{ route('buyer.fault_reports.index') }}">
        <i class="fas fa-clipboard-list"></i>
        My Fault Reports
    </a>
</li>
<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.profile.*') ? 'active' : '' }}" href="{{ route('buyer.profile.show') }}">
        <i class="fas fa-user"></i>
        My Profile
    </a>
</li> -->
