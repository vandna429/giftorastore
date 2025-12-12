<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">
        © {{ date('Y') }} Admin Panel — 
        <a href="{{ route('admin.dashboard') }}" class="text-warning">Dashboard</a> |
        <a href="{{ route('admin.products.index') }}" class="text-warning">Products</a> |
        <a href="{{ route('admin.categories.index') }}" class="text-warning">Categories</a> |
        <a href="{{ route('admin.orders.index') }}" class="text-warning">Orders</a> |
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</a>
    </p>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</footer>
