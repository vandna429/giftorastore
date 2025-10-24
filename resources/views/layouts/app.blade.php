<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Giftora - Make Every Moment Special')</title>


<!-- Bootstrap CSS (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@include('partials.header')


<div class="container">
@yield('content')
</div>


@include('partials.footer')

<li class="nav-item">
    <a class="nav-link" href="{{ route('about') }}">About Us</a>
</li>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>