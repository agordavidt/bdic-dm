<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('devices.*') ? 'active' : '' }}" href="{{ route('devices.index') }}">
        <i class="fas fa-mobile-alt"></i>
        My Devices
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.fault_reports.*') ? 'active' : '' }}" href="{{ route('buyer.fault_reports.index') }}">
        <i class="fas fa-exclamation-triangle"></i>
        My Fault Reports
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buyer.profile.*') ? 'active' : '' }}" href="{{ route('buyer.profile.show') }}">
        <i class="fas fa-user"></i>
        My Profile
    </a>
</li> 