<footer class="bg-light text-dark pt-5 pb-4 mt-5 border-top">
  <div class="container text-center text-md-start">
    <div class="row">

      <!-- 🏢 About -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold text-primary">Giftora</h5>
        <p>Making every moment special with thoughtful and personalized gifts for your loved ones.</p>
        <div class="mt-3">
          <a href="#" class="text-dark me-3"><i class="bi bi-facebook fs-4"></i></a>
          <a href="#" class="text-dark me-3"><i class="bi bi-instagram fs-4"></i></a>
          <a href="#" class="text-dark"><i class="bi bi-twitter fs-4"></i></a>
        </div>
      </div>

      <!-- 🔗 Quick Links -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold text-uppercase">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="{{ route('home') }}" class="text-dark text-decoration-none d-block py-1">Home</a></li>
          <li><a href="{{ route('products.index') }}" class="text-dark text-decoration-none d-block py-1">Products</a></li>
          <li><a href="{{ route('about') }}" class="text-dark text-decoration-none d-block py-1">About</a></li>
          <li><a href="{{ route('contact') }}" class="text-dark text-decoration-none d-block py-1">Contact</a></li>
        </ul>
      </div>

      <!-- 📞 Contact Info -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold text-uppercase">Contact</h6>
        <p><i class="bi bi-geo-alt me-2"></i> Karachi, Pakistan</p>
        <p><i class="bi bi-envelope me-2"></i> support@giftora.com</p>
        <p><i class="bi bi-telephone me-2"></i> +92 300 1234567</p>
      </div>

      <!-- 🕒 Hours -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold text-uppercase">Working Hours</h6>
        <p>Mon - Fri: 9am - 7pm</p>
        <p>Sat: 10am - 6pm</p>
        <p>Sun: Closed</p>
      </div>
    </div>
    <hr>
    <div class="text-center small text-muted">
      © {{ date('Y') }} <strong>Giftora</strong> — Made with ❤️ by Team Giftora
    </div>
  </div>
</footer>
