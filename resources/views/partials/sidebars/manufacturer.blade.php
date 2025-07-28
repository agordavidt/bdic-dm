<!-- <li class="nav-item">
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
</li> -->




<!-- Manufacturer Navigation Category -->
<li class="nav-item nav-category">Manufacturer Dashboard</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('device-categories.index') ? 'active' : '' }}" href="{{ route('device-categories.index') }}">
        <i class="menu-icon mdi mdi-tag-multiple"></i>
        <span class="menu-title">Device Categories</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.products.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-cogs"></i>
        <span class="menu-title">Product Management</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.specifications.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-format-list-bulleted-type"></i>
        <span class="menu-title">Specifications</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.quality.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-ribbon"></i>
        <span class="menu-title">Quality Control</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.production.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-factory"></i>
        <span class="menu-title">Production</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.distributors.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-truck-delivery"></i>
        <span class="menu-title">Distributors</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.warranty.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-shield-check"></i>
        <span class="menu-title">Warranty Management</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manufacturer.analytics.*') ? 'active' : '' }}" href="#">
        <i class="menu-icon mdi mdi-chart-donut"></i>
        <span class="menu-title">Analytics</span>
    </a>
</li>
