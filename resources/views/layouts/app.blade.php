<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Giftora - Make Every Moment Special')</title>

    <!--  Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    

    

    <!--  Google Fonts (modern + elegant) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!--  Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!--  Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            color: #333;
        }

        .container {
            max-width: 1200px;
        }

        footer {
            background: #f8f9fa;
            color: #6c757d;
            padding: 40px 0;
        }

        footer a {
            color: #6c757d;
            text-decoration: none;
        }

        footer a:hover {
            color: #e91e63;
        }
    </style>
</head>
<body>

    <!--  Header / Navbar -->
    @include('partials.header')

    <!--  Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!--  Footer -->
    @include('partials.footer')

    <!--  Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
