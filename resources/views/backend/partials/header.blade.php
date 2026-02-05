<header class="top-header">
    <div class="header-left">
        <button class="btn btn-link text-dark" onclick="toggleSidebar()" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 ms-3 d-none d-md-block">@yield('page-title', 'Dashboard')</h5>
    </div>

    <div class="header-right">
        <div class="dropdown">
            <button class="btn btn-link text-dark dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar me-2">
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
                <div class="d-none d-md-block text-start">
                    <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="user-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role ?? 'User')) }}</div>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2"></i>Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .top-header {
        height: var(--header-height);
        background: white;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    .header-left {
        display: flex;
        align-items: center;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    #sidebarToggle {
        padding: 5px 10px;
        border: none;
    }

    #sidebarToggle:hover {
        background: #f8f9fa;
        border-radius: 5px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        line-height: 1.2;
    }

    .user-role {
        font-size: 12px;
        color: #666;
        line-height: 1.2;
    }

    .dropdown-toggle::after {
        margin-left: 8px;
    }

    .dropdown-menu {
        min-width: 200px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        padding: 10px 15px;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
    }

    .dropdown-item i {
        width: 20px;
    }
</style>
