<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    {{-- Logo --}}
    <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('home') }}">
      <img src="{{ asset('images/logo-pink.png') }}" alt="Giftora Logo" height="40" class="me-2">
      <span>Giftora</span>
    </a>

    {{-- Mobile Toggle --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Navigation Links --}}
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>

        <!-- {{-- Admin Login / Logout --}}
        <li class="nav-item ms-3">
          @if(session('admin_logged_in'))
              <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger">
                      <i class="bi bi-box-arrow-right"></i> Logout
                  </button>
              </form>
          @else
              <a class="btn btn-outline-secondary" href="{{ route('admin.login') }}">
                  <i class="bi bi-person"></i> Admin Login
              </a>
          @endif
        </li> -->

        {{-- Cart Icon --}}
        @php
          $cart = session('cart', []);
          $totalQty = collect($cart)->sum('quantity');
        @endphp
        <li class="nav-item ms-3">
          <button class="btn btn-outline-primary position-relative" 
                  type="button" data-bs-toggle="offcanvas" 
                  data-bs-target="#cartSidebar" aria-controls="cartSidebar">
            <i class="bi bi-cart3 fs-5"></i>
            @if($totalQty > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $totalQty }}
              </span>
            @endif
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

{{-- 🧾 Offcanvas Cart Sidebar --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartSidebar" aria-labelledby="cartSidebarLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="cartSidebarLabel">
      <i class="bi bi-cart3 me-2 text-primary"></i>Your Cart
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    @if(!empty($cart))
      <ul class="list-group mb-3">
        @foreach($cart as $slug => $item)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" width="50" class="rounded me-2 shadow-sm">
              <div>
                <strong>{{ $item['name'] }}</strong><br>
                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
              </div>
            </div>
            <span class="fw-semibold text-secondary">
              PKR {{ number_format($item['price'] * $item['quantity']) }}
            </span>
          </li>
        @endforeach
      </ul>

      {{-- Cart Summary --}}
      @php
        $cartTotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
      @endphp
      <div class="mb-3 text-end">
        <h6>Total: <span class="text-primary fw-bold">PKR {{ number_format($cartTotal) }}</span></h6>
      </div>

      <div class="d-grid gap-2">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
          <i class="bi bi-bag me-1"></i> View Full Cart
        </a>
        <a href="{{ route('cart.checkout') }}" class="btn btn-success">
          <i class="bi bi-credit-card me-1"></i> Checkout
        </a>
      </div>
    @else
      <div class="text-center text-muted mt-5">
        <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
        <p>Your cart is empty.</p>
      </div>
    @endif
  </div>
</div>
