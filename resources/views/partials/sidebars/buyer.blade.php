<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}" href="{{ route('buyer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li> -->
<!-- <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}" href="{{ route('buyer.products.index') }}">
        <i class="fas fa-th-list"></i>
        Products
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}" href="{{ route('buyer.cart.index') }}">
        <i class="fas fa-shopping-cart"></i>
        Cart
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}" href="{{ route('buyer.orders.index') }}">
        <i class="fas fa-box"></i>
        Orders
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
        Fault Reports
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.profile.*') ? 'active' : '' }}" href="{{ route('buyer.profile.show') }}">
        <i class="fas fa-user"></i>
        Profile
    </a>
</li> -->





<li class="nav-item nav-category">Buyer Dashboard</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}" href="{{ route('buyer.products.index') }}">
        <i class="menu-icon mdi mdi-view-list"></i>
        <span class="menu-title">Products</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}" href="{{ route('buyer.cart.index') }}">
        <i class="menu-icon mdi mdi-cart"></i>
        <span class="menu-title">Cart</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}" href="{{ route('buyer.orders.index') }}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Orders</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.devices.index') ? 'active' : '' }}" href="{{ route('buyer.devices.index') }}">
        <i class="menu-icon mdi mdi-alert-circle-outline"></i>
        <span class="menu-title">Report Fault</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.fault_reports.*') ? 'active' : '' }}" href="{{ route('buyer.fault_reports.index') }}">
        <i class="menu-icon mdi mdi-clipboard-text"></i>
        <span class="menu-title">Fault Reports</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.profile.*') ? 'active' : '' }}" href="{{ route('buyer.profile.show') }}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Profile</span>
    </a>
</li>
