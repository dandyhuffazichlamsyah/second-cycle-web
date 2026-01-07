<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SecondCycle</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .admin-sidebar.collapsed {
            width: 70px;
        }
        
        .admin-sidebar.collapsed .sidebar-brand h2 span {
            display: none;
        }
        
        .admin-sidebar.collapsed .nav-section {
            text-align: center;
            font-size: 0.6rem;
        }
        
        .admin-sidebar.collapsed .nav-link span {
            display: none;
        }
        
        .admin-sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }
        
        .admin-sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .admin-sidebar.collapsed .nav-badge {
            display: none;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h2 {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }
        
        .admin-sidebar.collapsed .sidebar-brand span {
            display: none;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            padding: 0.5rem 1rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            font-weight: 700;
        }
        
        .admin-sidebar.collapsed .nav-section {
            display: none;
        }
        
        .sidebar-nav .nav-item {
            margin: 0.25rem 0.5rem;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }
        
        .sidebar-nav .nav-link i {
            width: 1.5rem;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 0.9rem;
        }
        
                
        .nav-badge {
            margin-left: auto;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        /* Main Content Area */
        .admin-wrapper {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            transition: left 0.3s ease;
            overflow: hidden;
        }
        
        .admin-wrapper.expanded {
            left: 70px;
        }
        
        /* Top Header */
        .admin-header {
            height: var(--header-height);
            min-height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 999;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .toggle-sidebar:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }
        
        .header-search {
            position: relative;
        }
        
        .header-search input {
            width: 300px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e3e6f0;
            border-radius: 2rem;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .header-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78,115,223,.25);
        }
        
        .header-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--light-color);
            color: var(--secondary-color);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .header-icon:hover {
            background: #e2e6ea;
            color: var(--primary-color);
        }
        
        .header-icon .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            font-size: 0.6rem;
            padding: 0.25rem 0.4rem;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .user-dropdown:hover {
            background: var(--light-color);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-info .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark-color);
        }
        
        .user-info .role {
            font-size: 0.75rem;
            color: var(--secondary-color);
        }
        
        /* Main Content */
        .admin-content {
            padding: 1.5rem;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #f4f6f9;
        }
        
        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }
        
        .page-breadcrumb {
            font-size: 0.85rem;
            color: var(--secondary-color);
        }
        
        .page-breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        /* Cards */
        .admin-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.1);
            border: none;
            margin-bottom: 1.5rem;
        }
        
        .admin-card .card-header {
            background: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .admin-card .card-body {
            padding: 1.25rem;
        }
        
        /* Stats Cards */
        .stat-card {
            border-left: 4px solid;
            border-radius: 0.5rem;
        }
        
        .stat-card.primary { border-left-color: var(--primary-color); }
        .stat-card.success { border-left-color: var(--success-color); }
        .stat-card.info { border-left-color: var(--info-color); }
        .stat-card.warning { border-left-color: var(--warning-color); }
        .stat-card.danger { border-left-color: var(--danger-color); }
        
        /* Footer */
        .admin-footer {
            padding: 1rem 1.5rem;
            background: white;
            border-top: 1px solid #e3e6f0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--secondary-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-wrapper {
                left: 0 !important;
            }
            
            .header-search {
                display: none;
            }
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <h2>
                <i class="fas fa-motorcycle"></i>
                <span>SecondCycle</span>
            </h2>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            @auth
                @if(auth()->user()->canManageContacts())
                <div class="nav-item">
                    <a href="{{ route('admin.contacts') }}" class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan Kontak</span>
                        <span class="badge bg-danger nav-badge" id="sidebarUnreadBadge" style="display: none;">0</span>
                    </a>
                </div>
                @endif
                
                @if(auth()->user()->canManageProducts())
                <div class="nav-item">
                    <a href="{{ route('admin.products') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <i class="fas fa-motorcycle"></i>
                        <span>Produk</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pesanan</span>
                    </a>
                </div>
                @endif
                
                @if(auth()->user()->canManageUsers())
                <div class="nav-section">Manajemen</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Pengguna</span>
                    </a>
                </div>
                @endif
                
                @if(auth()->user()->hasCeoAccess())
                <div class="nav-section">CEO Tools</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.system-settings') }}" class="nav-link {{ request()->routeIs('admin.system-settings*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>System Settings</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.audit-log') }}" class="nav-link {{ request()->routeIs('admin.audit-log*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Audit Log</span>
                    </a>
                </div>
                @endif
            @endauth
            
            <div class="nav-section">Lainnya</div>
            
            <div class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Lihat Website</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>
    
    <!-- Main Wrapper -->
    <div class="admin-wrapper" id="adminWrapper">
        <!-- Top Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="toggle-sidebar" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari..." id="globalSearch">
                </div>
            </div>
            
            <div class="header-right">
                <div class="header-icon" onclick="window.location.href='{{ route('admin.contacts') }}'">
                    <i class="fas fa-envelope"></i>
                    <span class="badge bg-danger" id="headerUnreadBadge" style="display: none;">0</span>
                </div>
                
                <div class="header-icon" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i>
                </div>
                
                @auth
                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="user-avatar" style="object-fit: cover;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                        <div class="user-info d-none d-md-block">
                            <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="role">{{ auth()->user()->getRoleLabel() ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2 text-muted"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="admin-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="admin-footer">
            <span>&copy; {{ date('Y') }} SecondCycle Admin Panel. All rights reserved.</span>
        </footer>
    </div>
    
    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    @yield('modals')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Clear old sidebar state to fix layout issue
        if (!localStorage.getItem('sidebarStateFixed')) {
            localStorage.removeItem('sidebarCollapsed');
            localStorage.setItem('sidebarStateFixed', 'true');
        }
        
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const wrapper = document.getElementById('adminWrapper');
            sidebar.classList.toggle('collapsed');
            wrapper.classList.toggle('expanded');
            
            // Save state to localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
        
        // Restore sidebar state - default to expanded
        document.addEventListener('DOMContentLoaded', function() {
            // Reset to expanded by default for better UX
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const sidebar = document.getElementById('adminSidebar');
            const wrapper = document.getElementById('adminWrapper');
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                wrapper.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                wrapper.classList.remove('expanded');
            }
            
            // Load unread count
            loadUnreadCount();
        });
        
        // Load unread message count
        function loadUnreadCount() {
            fetch('/admin/contacts/unread-count', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.count > 0) {
                    document.getElementById('sidebarUnreadBadge').textContent = data.count;
                    document.getElementById('sidebarUnreadBadge').style.display = 'inline-block';
                    document.getElementById('headerUnreadBadge').textContent = data.count;
                    document.getElementById('headerUnreadBadge').style.display = 'inline-block';
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        // Refresh page
        function refreshPage() {
            location.reload();
        }
        
        // Global search
        document.getElementById('globalSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    // Implement global search logic here
                    alert('Mencari: ' + query);
                }
            }
        });
        
        // Show alert
        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            setTimeout(() => {
                const alert = document.querySelector('.alert.position-fixed');
                if (alert) alert.remove();
            }, 5000);
        }
        
        // Auto-refresh unread count every 30 seconds
        setInterval(loadUnreadCount, 30000);
    </script>
    
    @yield('scripts')
</body>
</html>
