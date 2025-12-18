<footer class="text-white text-center py-3 mt-5" style="background: linear-gradient(135deg, #e8d5ff 0%, #f5c2e8 100%);">
    <p class="mb-0">
        © {{ date('Y') }} Admin Panel — 
        <a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a> |
        <a href="{{ route('admin.products.index') }}" class="text-white">Products</a> |
        <a href="{{ route('admin.categories.index') }}" class="text-white">Categories</a> |
        <a href="{{ route('admin.orders.index') }}" class="text-white">Orders</a> |
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white-50">Logout</a>
    </p>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</footer>
