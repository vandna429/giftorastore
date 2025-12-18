# API Testing Guide

## Base URL
Your API endpoints are available at: `http://localhost/my-app (2)/my-app/public/api`

**Important:** Since your project is in `C:\xampp\htdocs\my-app (2)\my-app`, the correct URL structure is:
- Base: `http://localhost/my-app (2)/my-app/public/`
- API Base: `http://localhost/my-app (2)/my-app/public/api`

**Alternative:** If you want cleaner URLs, you can:
1. Set up a virtual host in XAMPP
2. Or use Laravel's built-in server: `php artisan serve` (then use `http://127.0.0.1:8000/api`)

---

## Method 1: Using Browser (GET requests only)

Simply open these URLs in your browser:

### Products API
- **List all products:** `http://localhost/my-app/public/api/products`
- **Get single product:** `http://localhost/my-app/public/api/products/{slug}`
  - Example: `http://localhost/my-app/public/api/products/luxury-chocolate-box`
- **Products by category:** `http://localhost/my-app/public/api/products/category/{categorySlug}`
  - Example: `http://localhost/my-app/public/api/products/category/chocolates`
- **Search products:** `http://localhost/my-app/public/api/products/search/{query}`
  - Example: `http://localhost/my-app/public/api/products/search/chocolate`

### Categories API
- **List all categories:** `http://localhost/my-app/public/api/categories`
- **Get single category:** `http://localhost/my-app/public/api/categories/{slug}`
  - Example: `http://localhost/my-app/public/api/categories/chocolates`
- **Products in category:** `http://localhost/my-app/public/api/categories/{slug}/products`
  - Example: `http://localhost/my-app/public/api/categories/chocolates/products`

### Orders API
- **List all orders:** `http://localhost/my-app/public/api/orders`
- **Get single order:** `http://localhost/my-app/public/api/orders/{id}`
  - Example: `http://localhost/my-app/public/api/orders/1`

---

## Method 2: Using cURL (Command Line)

### Windows PowerShell
```powershell
# List all products
Invoke-WebRequest -Uri "http://localhost/my-app/public/api/products" | Select-Object -ExpandProperty Content

# Get single product
Invoke-WebRequest -Uri "http://localhost/my-app/public/api/products/luxury-chocolate-box" | Select-Object -ExpandProperty Content

# List all categories
Invoke-WebRequest -Uri "http://localhost/my-app/public/api/categories" | Select-Object -ExpandProperty Content

# List all orders
Invoke-WebRequest -Uri "http://localhost/my-app/public/api/orders" | Select-Object -ExpandProperty Content
```

### Using curl (if installed)
```bash
# List all products
curl http://localhost/my-app/public/api/products

# Get single product
curl http://localhost/my-app/public/api/products/luxury-chocolate-box

# List all categories
curl http://localhost/my-app/public/api/categories

# List all orders
curl http://localhost/my-app/public/api/orders
```

---

## Method 3: Using Postman

1. Download and install [Postman](https://www.postman.com/downloads/)
2. Create a new request
3. Set method to `GET`
4. Enter the API URL (e.g., `http://localhost/my-app/public/api/products`)
5. Click "Send"
6. View the JSON response

---

## Method 4: Using PHP Artisan Tinker (Quick Test)

```bash
php artisan tinker
```

Then in tinker:
```php
// Test ProductController
$response = app(\App\Http\Controllers\Api\ProductController::class)->index(new \Illuminate\Http\Request());
$response->getContent();

// Test CategoryController
$response = app(\App\Http\Controllers\Api\CategoryController::class)->index();
$response->getContent();
```

---

## Method 5: Using JavaScript/Fetch (Browser Console)

Open browser console (F12) and run:

```javascript
// Test products API
fetch('http://localhost/my-app/public/api/products')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));

// Test categories API
fetch('http://localhost/my-app/public/api/categories')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));

// Test orders API
fetch('http://localhost/my-app/public/api/orders')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

---

## Query Parameters

### Products List
- `?category=chocolates` - Filter by category slug
- `?search=chocolate` - Search term
- `?per_page=10` - Items per page
- `?page=2` - Page number

Example: `http://localhost/my-app/public/api/products?category=chocolates&per_page=5`

### Orders List
- `?status=pending` - Filter by status
- `?per_page=10` - Items per page
- `?page=2` - Page number

Example: `http://localhost/my-app/public/api/orders?status=pending`

---

## Expected Response Format

### Success Response
```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 10,
    "last_page": 1
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Product not found"
}
```

---

## Troubleshooting

1. **404 Not Found:**
   - Check if your server is running (XAMPP Apache)
   - Verify the base URL is correct
   - Make sure `routes/api.php` exists and is loaded

2. **500 Internal Server Error:**
   - Check Laravel logs: `storage/logs/laravel.log`
   - Verify database connection
   - Check if models exist and have data

3. **Empty Response:**
   - Check if you have data in your database
   - Verify database tables exist

4. **CORS Issues:**
   - If testing from a different domain, you may need to configure CORS middleware

---

## Quick Test Checklist

- [ ] Server is running (XAMPP/Apache)
- [ ] Database is connected
- [ ] Routes are registered (`php artisan route:list --path=api`)
- [ ] Test `/api/products` endpoint
- [ ] Test `/api/categories` endpoint
- [ ] Test `/api/orders` endpoint
- [ ] Verify JSON responses are valid

