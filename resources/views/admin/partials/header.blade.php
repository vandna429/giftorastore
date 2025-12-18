<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #e8d5ff 0%, #f5c2e8 100%);">
    <div class="container-fluid">

        <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('admin/products*') ? 'active' : '' }}"
                       href="{{ route('admin.products.index') }}">
                        Products
                    </a>
                </li>

                <!-- ✅ Categories Link -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('admin/categories*') ? 'active' : '' }}"
                       href="{{ route('admin.categories.index') }}">
                        Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('admin/orders*') ? 'active' : '' }}"
                       href="{{ route('admin.orders.index') }}">
                        Orders
                    </a>
                </li>

            </ul>

            <form method="POST" action="{{ route('admin.logout') }}" class="d-flex">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>

    </div>
</nav>
