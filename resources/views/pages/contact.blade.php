@extends('layouts.app')

@section('title', 'Contact - Giftora')

@section('content')
<style>
  .contact-page {
    background-color: #F9E3E9;
    min-height: 100vh;
    padding: 80px 0;
  }

  .contact-header {
    text-align: center;
    margin-bottom: 50px;
  }

  .contact-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
  }

  .contact-header h2 i {
    color: #D16C8A;
    font-size: 2.2rem;
  }

  .contact-header p {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
  }

  .contact-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    height: 100%;
  }

  .contact-form-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 0.95rem;
  }

  .form-control {
    border: 1px solid #DDDDDD;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .form-control:focus {
    border-color: #D16C8A;
    box-shadow: 0 0 0 0.2rem rgba(209, 108, 138, 0.15);
    outline: none;
  }

  .form-control::placeholder {
    color: #999;
  }

  .contact-info-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    height: 100%;
  }

  .contact-info-card h5 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 30px;
    text-align: left;
  }

  .contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
    color: #333;
  }

  .contact-info-item i {
    color: #D16C8A;
    font-size: 1.4rem;
    margin-right: 15px;
    margin-top: 2px;
    flex-shrink: 0;
  }

  .contact-info-item p {
    margin: 0;
    font-size: 1rem;
    line-height: 1.6;
    color: #333;
  }

  .btn-submit {
    background-color: #D16C8A;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 40px;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(209, 108, 138, 0.3);
  }

  .btn-submit:hover {
    background-color: #E39AAE;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(209, 108, 138, 0.4);
    color: white;
  }

  @media (max-width: 768px) {
    .contact-page {
      padding: 50px 0;
    }

    .contact-header h2 {
      font-size: 2rem;
    }

    .contact-form-card,
    .contact-info-card {
      padding: 30px 20px;
      margin-bottom: 30px;
    }
  }
</style>

<div class="contact-page">
  <div class="container">
    <!-- Header Section -->
    <div class="contact-header">
      <h2>
        <i class="bi bi-envelope-heart-fill"></i>
        Contact Us
      </h2>
      <p>Have a question or need help? Fill out the form and we'll get back to you as soon as possible.</p>
    </div>

    <!-- Contact Form and Info Cards -->
    <div class="row g-4 align-items-stretch">
      <!-- Contact Form Card -->
      <div class="col-lg-7">
        <div class="contact-form-card">
          <form action="#" method="POST">
            @csrf
            <div class="mb-4">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
            </div>

            <div class="mb-4">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>

            <div class="mb-4">
              <label for="message" class="form-label">Message</label>
              <textarea id="message" name="message" class="form-control" rows="6" placeholder="Write your message here" required></textarea>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-submit">
                <i class="bi bi-send-fill me-2"></i>Send Message
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Get in Touch Card -->
      <div class="col-lg-5">
        <div class="contact-info-card">
          <h5>Get in Touch</h5>
          
          <div class="contact-info-item">
            <i class="bi bi-geo-alt-fill"></i>
            <p>123 Giftora Street, Karachi, Pakistan</p>
          </div>

          <div class="contact-info-item">
            <i class="bi bi-envelope-fill"></i>
            <p>support@giftora.com</p>
          </div>

          <div class="contact-info-item">
            <i class="bi bi-telephone-fill"></i>
            <p>+92 300 1234567</p>
          </div>

          <div class="contact-info-item">
            <i class="bi bi-clock-fill"></i>
            <p>Mon - Fri: 9:00am - 6:00pm</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
