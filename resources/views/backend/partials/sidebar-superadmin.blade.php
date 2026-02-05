<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center">
            <i class="bi bi-heart-pulse-fill text-white fs-4 me-2"></i>
            <h4 class="mb-0">Prottoy Healthcare</h4>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('superadmin.dashboard') }}" class="menu-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-section">Users Management</div>

        <a href="{{ route('superadmin.divisional-chiefs.index') }}" class="menu-item {{ request()->routeIs('superadmin.divisional-chiefs.*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i>
            <span>Divisional Chiefs</span>
        </a>

        <a href="{{ route('superadmin.district-managers.index') }}" class="menu-item {{ request()->routeIs('superadmin.district-managers.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>District Managers</span>
        </a>

        <a href="{{ route('superadmin.upazila-supervisors.index') }}" class="menu-item {{ request()->routeIs('superadmin.upazila-supervisors.*') ? 'active' : '' }}">
            <i class="bi bi-pin-map-fill"></i>
            <span>Upazila Supervisors</span>
        </a>

        <a href="{{ route('superadmin.phos.index') }}" class="menu-item {{ request()->routeIs('superadmin.phos.*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard"></i>
            <span>PHOs</span>
        </a>

        <a href="{{ route('superadmin.customers.index') }}" class="menu-item {{ request()->routeIs('superadmin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Customers</span>
        </a>

        <a href="{{ route('superadmin.all-users') }}" class="menu-item {{ request()->routeIs('superadmin.all-users') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>All Users</span>
        </a>


        <div class="menu-section">Settings</div>

        <a href="#" class="menu-item">
            <i class="bi bi-gear"></i>
            <span>System Settings</span>
        </a>

        <a href="#" class="menu-item">
            <i class="bi bi-shield-lock"></i>
            <span>Security</span>
        </a>
    </div>
</aside>

<style>
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 998;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        color: white;
        overflow-y: auto;
        transition: transform 0.3s ease;
        z-index: 999;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        z-index: 10;
    }

    .sidebar-menu {
        padding: 20px 0;
    }

    .menu-section {
        padding: 15px 20px 10px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .menu-item.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left: 3px solid white;
    }

    .menu-item i {
        font-size: 18px;
        width: 30px;
    }

    .menu-item span {
        font-size: 14px;
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }

    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>
