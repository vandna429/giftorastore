@extends('layouts.app')

@section('title', 'Contact - Giftora')

@section('content')
<div class="py-5">
    <h2 class="fw-bold text-center mb-4">Contact Us</h2>
    <p class="text-muted text-center mb-5">
        Have a question or need help? Fill out the form and we’ll get back to you as soon as possible.
    </p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="#" method="POST" class="shadow p-4 rounded bg-light">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" id="name" class="form-control" placeholder="Your name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="your@email.com" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Message</label>
                    <textarea id="message" class="form-control" rows="5" placeholder="Write your message here" required></textarea>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary px-4">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Giftora Contact Details -->
    <div class="mt-5 text-center">
        <h4 class="fw-bold mb-3">Our Contact Information</h4>
        <p class="mb-1"><i class="bi bi-envelope-fill text-primary"></i> <strong>Email:</strong> support@giftora.com</p>
        <p class="mb-1"><i class="bi bi-telephone-fill text-primary"></i> <strong>Phone:</strong> +92 300 1234567</p>
        <p><i class="bi bi-geo-alt-fill text-primary"></i> <strong>Address:</strong> Giftora HQ, Clifton Block 5, Karachi, Pakistan</p>
    </div>
</div>
@endsection
