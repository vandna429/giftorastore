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
        :root {
            --pink: #F4B6C2;
            --pink-dark: #E39AAE;
            --accent: #D16C8A;
            --bg: #F6F6F6;
            --white: #FFFFFF;
            --text: #333333;
            --muted: #777777;
            --border: #DDDDDD;
            --grey-light: #E5E5E5;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 1200px;
        }

        footer {
            padding: 40px 0;
        }

        footer a {
            text-decoration: none;
            transition: opacity 0.3s;
        }

        footer a:hover {
            opacity: 0.8;
        }
        
        .navbar a.nav-link:hover {
            opacity: 0.8;
        }
        
        /* Pink and Grey Theme Buttons */
        .btn-primary, .btn-success {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--white);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-success:hover {
            background-color: var(--pink-dark);
            border-color: var(--pink-dark);
            color: var(--white);
        }
        
        .btn-outline-primary {
            border-color: var(--accent);
            color: var(--accent);
            border-radius: 8px;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--white);
        }
        
        .btn-outline-light {
            border-color: var(--white);
            color: var(--white);
        }
        
        .btn-outline-light:hover {
            background-color: var(--white);
            color: var(--accent);
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: var(--white);
            border-radius: 8px;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: var(--white);
        }
        
        .badge {
            border-radius: 6px;
        }
        
        /* Cards */
        .card {
            background-color: var(--white);
            border-color: var(--border);
            border-radius: 12px;
        }
        
        /* Text Colors */
        .text-primary {
            color: var(--accent) !important;
        }
        
        .text-muted {
            color: var(--muted) !important;
        }
        
        /* Category Filter Buttons Active State */
        .btn-outline-primary.active {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--white);
        }
        
        /* Product Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(209, 108, 138, 0.2) !important;
        }
        
        /* Offcanvas Cart */
        .offcanvas-header {
            background: linear-gradient(135deg, #F4B6C2 0%, #D16C8A 100%);
        }
        
        .offcanvas-title {
            color: var(--white) !important;
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
