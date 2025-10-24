<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
<div class="container">
<a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
<span class="brand-icon">🎁</span>
<strong>Giftora</strong>
</a>


<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>


<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto align-items-lg-center">
<li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>


<li class="nav-item ms-2">

</li>
</ul>
</div>
</div>
</nav>