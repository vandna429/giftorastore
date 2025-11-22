@extends('layouts.app')

@section('title', 'Contact - Giftora')

@section('content')
<style>
  /* 🌸 Giftora Contact Page Custom Styling */
  body {
    background: linear-gradient(to bottom right, #ffe6f0, #ffffff);
  }

  .contact-wrapper {
    padding: 80px 0;
  }

  .contact-card {
    background: #fff;
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
  }

  .contact-card:hover {
    transform: translateY(-5px);
  }

  .form-control:focus {
    border-color: #ff69b4;
    box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
  }

  .btn-pink {
    background-color: #ff69b4;
    color: white;
    border-radius: 10px;
  }

  .btn-pink:hover {
    background-color: #ff4fa0;
    color: #fff;
  }

  .contact-info {
    background: #fff0f6;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  }

  .contact-info i {
    color: #ff69b4;
    font-size: 1.5rem;
    margin-right: 10px;
  }
</style>

<div class="contact-wrapper">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-dark"><i class="bi bi-envelope-heart-fill text-pink me-2"></i>Contact Us</h2>
      <p class="text-muted">Have a question or need help? Fill out the form and we’ll get back to you as soon as possible.</p>
    </div>

    <div class="row g-4 justify-content-center align-items-start">
      <!-- 📨 Contact Form -->
      <div class="col-md-7">
        <div class="p-5 contact-card">
          <form action="#" method="POST">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Name</label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>

            <div class="mb-3">
              <label for="message" class="form-label fw-semibold">Message</label>
              <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write your message here" required></textarea>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-pink px-5 py-2 fw-semibold shadow-sm">
                <i class="bi bi-send-fill me-1"></i> Send Message
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- 📞 Contact Info Section -->
      <div class="col-md-4">
        <div class="contact-info">
          <h5 class="fw-bold mb-3 text-center text-dark">Get in Touch</h5>
          <p><i class="bi bi-geo-alt-fill"></i> 123 Giftora Street, Karachi, Pakistan</p>
          <p><i class="bi bi-envelope-fill"></i> support@giftora.com</p>
          <p><i class="bi bi-telephone-fill"></i> +92 300 1234567</p>
          <p><i class="bi bi-clock-fill"></i> Mon - Fri: 9:00am - 6:00pm</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
