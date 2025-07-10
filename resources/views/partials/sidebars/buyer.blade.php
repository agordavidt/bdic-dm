<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.browse.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-search"></i>
        Browse Devices
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-shopping-cart"></i>
        Shopping Cart
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-box"></i>
        My Orders
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.devices.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-mobile-alt"></i>
        My Devices
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.faults.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-exclamation-triangle"></i>
        Report Fault
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.warranty.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-shield-alt"></i>
        Warranty Claims
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.wishlist.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-heart"></i>
        Wishlist
    </a>
</li>
