<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }

        /* Top Navbar */
        .navbar {
            background: #111;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #ddd;
            margin-left: 20px;
            text-decoration: none;
            font-size: 15px;
        }

        .navbar a:hover {
            color: white;
        }

        /* Main Content */
        .container {
            text-align: center;
            margin-top: 50px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 40px;
        }

        /* Two-card layout */
        .card-wrapper {
            display: flex;
            justify-content: center;
            gap: 40px;
        }

        .card {
            background: white;
            width: 320px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h2 {
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            margin-bottom: 20px;
        }

        .btn-blue, .btn-green, .btn-yellow {
            display: inline-block;
            padding: 12px 20px;
            width: 80%;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
        }

        .btn-blue { background: #0d6efd; }
        .btn-blue:hover { background: #0a58ca; }

        .btn-green { background: #198754; }
        .btn-green:hover { background: #146c43; }

        .btn-yellow { background: #ffc107; color: black; }
        .btn-yellow:hover { background: #e0a800; color: black; }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <div class="navbar">
        <div><strong>Admin Panel</strong></div>
        <div>
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/products">Products</a>
            <a href="/admin/categories">Categories</a> <!-- ✅ FIXED -->
            <a href="/admin/orders">Orders</a>
            <a href="/admin/logout">Logout</a>
        </div>
    </div>

    <!-- Main Section -->
    <div class="container">
        <h1>Welcome Admin 🎉</h1>

        <div class="card-wrapper">

            <!-- Products Card -->
            <div class="card">
                <h2>Product Management</h2>
                <p>Manage all products</p>
                <a href="/admin/products" class="btn-blue">Go to Products</a>
            </div>

            <!-- Categories Card -->
            <div class="card">
                <h2>Category Management</h2>
                <p>Manage product categories</p>
                <a href="/admin/categories" class="btn-yellow">Go to Categories</a>
            </div>

            <!-- Orders Card -->
            <div class="card">
                <h2>Order Management</h2>
                <p>View and manage orders</p>
                <a href="/admin/orders" class="btn-green">Go to Orders</a>
            </div>

        </div>
    </div>

</body>
</html>
