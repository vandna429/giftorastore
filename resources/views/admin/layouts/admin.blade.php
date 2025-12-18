<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --pink: #F4B6C2;
            --pink-dark: #E39AAE;
            --accent: #D16C8A;
            --bg: #F6F6F6;
            --white: #FFFFFF;
            --text: #333333;
            --muted: #777777;
            --border: #DDDDDD;
            --sidebar-bg: #E5E5E5;
            --sidebar-active: #F4B6C2;
            --table-header: #F4B6C2;
            --table-hover: #F9E3E9;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            margin: 0;
            padding: 0;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-logo {
            width: 30px;
            height: 30px;
            background: var(--accent);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .sidebar-brand {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-item:hover {
            background-color: rgba(244, 182, 194, 0.2);
            color: var(--text);
        }
        
        .sidebar-item.active {
            background-color: var(--sidebar-active);
            color: var(--text);
            border-left-color: var(--accent);
        }
        
        .sidebar-item i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            background-color: var(--bg);
        }
        
        /* Top Header */
        .top-header {
            background-color: var(--white);
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .content-area {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 20px;
        }
        
        .add-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .add-btn:hover {
            background: var(--pink-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(209, 108, 138, 0.3);
            color: white;
        }
        
        /* Table Styles */
        .products-table {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .products-table table {
            margin: 0;
        }
        
        .products-table thead {
            background-color: var(--table-header);
        }
        
        .products-table th {
            padding: 15px 20px;
            font-weight: 600;
            color: var(--text);
            border-bottom: 2px solid var(--border);
        }
        
        .products-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }
        
        .products-table tbody tr:hover {
            background-color: var(--table-hover);
        }
        
        .action-menu {
            position: relative;
        }
        
        .action-btn {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 18px;
            padding: 5px 10px;
        }
        
        .action-btn:hover {
            color: var(--text);
        }
        
        .action-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--white);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 120px;
            display: none;
            z-index: 100;
        }
        
        .action-dropdown.show {
            display: block;
        }
        
        .action-dropdown a {
            display: block;
            padding: 8px 16px;
            color: var(--text);
            text-decoration: none;
            transition: background 0.2s;
        }
        
        .action-dropdown a:hover {
            background-color: var(--table-hover);
        }
        
        /* Dashboard Cards - Equal Height */
        .row > [class*='col-'] {
            display: flex;
        }
        
        .row > [class*='col-'] > div {
            width: 100%;
        }
        
        /* Button Styles */
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        
        .btn-primary:hover {
            background-color: var(--pink-dark);
            border-color: var(--pink-dark);
        }
        
        /* Card Title Color */
        .products-table h3 {
            color: var(--text) !important;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">G</div>
                <div class="sidebar-brand">Giftora</div>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-check-square"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                    <i class="bi bi-file-text"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Categories</span>
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <div class="top-header">
                <div>
                    <button class="btn btn-sm d-md-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
        
        // Close action dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-menu')) {
                document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });
        
        // Toggle action dropdown
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = this.nextElementSibling;
                document.querySelectorAll('.action-dropdown').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });
                dropdown.classList.toggle('show');
            });
        });
    </script>
</body>
</html>
