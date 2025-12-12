<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                       href="{{ route('admin.products.index') }}">
                        Products
                    </a>
                </li>

                <!-- ✅ Categories Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
                       href="{{ route('admin.categories.index') }}">
                        Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}"
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
