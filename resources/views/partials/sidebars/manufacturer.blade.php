<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('device-categories.index') ? 'active' : '' }}" href="{{ route('device-categories.index') }}">
        <i class="fas fa-tags"></i>
        Device Categories
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.products.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-cogs"></i>
        Product Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.specifications.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-list-alt"></i>
        Specifications
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.quality.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-award"></i>
        Quality Control
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.production.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-industry"></i>
        Production
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.distributors.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-truck"></i>
        Distributors
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.warranty.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-shield-alt"></i>
        Warranty Management
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.analytics.*') ? 'active' : '' }}" href="#">
        <i class="fas fa-chart-pie"></i>
        Analytics
    </a>
</li>
