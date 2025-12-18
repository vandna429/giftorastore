# API Testing Guide

## Base URL
Your API endpoints are available at: `http://localhost/api` (or your configured domain)

**Note:** If you're using XAMPP, your base URL might be:
- `http://localhost/my-app/public/api` (if accessing via public folder)
- `http://localhost/api` (if you have a virtual host configured)

---

## Method 1: Using Browser (GET requests only)

Simply open these URLs in your browser:

### Products API
- **List all products:** `http://localhost/api/products`
- **Get single product:** `http://localhost/api/products/{slug}`
  - Example: `http://localhost/api/products/luxury-chocolate-box`
- **Products by category:** `http://localhost/api/products/category/{categorySlug}`
  - Example: `http://localhost/api/products/category/chocolates`
- **Search products:** `http://localhost/api/products/search/{query}`
  - Example: `http://localhost/api/products/search/chocolate`

### Categories API
- **List all categories:** `http://localhost/api/categories`
- **Get single category:** `http://localhost/api/categories/{slug}`
  - Example: `http://localhost/api/categories/chocolates`
- **Products in category:** `http://localhost/api/categories/{slug}/products`
  - Example: `http://localhost/api/categories/chocolates/products`

### Orders API
- **List all orders:** `http://localhost/api/orders`
- **Get single order:** `http://localhost/api/orders/{id}`
  - Example: `http://localhost/api/orders/1`

---

## Method 2: Using cURL (Command Line)

### Windows PowerShell
```powershell
# List all products
Invoke-WebRequest -Uri "http://localhost/api/products" | Select-Object -ExpandProperty Content

# Get single product
Invoke-WebRequest -Uri "http://localhost/api/products/luxury-chocolate-box" | Select-Object -ExpandProperty Content

# List all categories
Invoke-WebRequest -Uri "http://localhost/api/categories" | Select-Object -ExpandProperty Content

# List all orders
Invoke-WebRequest -Uri "http://localhost/api/orders" | Select-Object -ExpandProperty Content
```

### Using curl (if installed)
```bash
# List all products
curl http://localhost/api/products

# Get single product
curl http://localhost/api/products/luxury-chocolate-box

# Search products
curl http://localhost/api/products/search/chocolate

# List categories
curl http://localhost/api/categories

# List orders
curl http://localhost/api/orders
```

---

## Method 3: Using Postman

1. **Download Postman** from https://www.postman.com/downloads/
2. Create a new request
3. Set method to `GET`
4. Enter the API URL (e.g., `http://localhost/api/products`)
5. Click "Send"
6. View the JSON response

---

## Method 4: Using JavaScript/Fetch (Browser Console)

Open browser console (F12) and run:

```javascript
// Test Products API
fetch('http://localhost/api/products')
  .then(response => response.json())
  .then(data => console.log(data));

// Test Categories API
fetch('http://localhost/api/categories')
  .then(response => response.json())
  .then(data => console.log(data));

// Test Orders API
fetch('http://localhost/api/orders')
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## Method 5: Verify Routes with Laravel Artisan

Run this command to see all registered API routes:

```bash
php artisan route:list --path=api
```

Or to see all routes:
```bash
php artisan route:list
```

---

## Expected Response Format

All successful API responses follow this format:

```json
{
  "success": true,
  "data": [...],
  "pagination": { ... }  // Only for paginated endpoints
}
```

Error responses:
```json
{
  "success": false,
  "message": "Error message here"
}
```

---

## Query Parameters

Some endpoints support query parameters:

### Products List
- `?category=chocolates` - Filter by category
- `?search=chocolate` - Search term
- `?per_page=10` - Items per page
- `?page=2` - Page number

Example: `http://localhost/api/products?category=chocolates&per_page=5`

### Orders List
- `?status=pending` - Filter by status
- `?per_page=10` - Items per page
- `?page=2` - Page number

Example: `http://localhost/api/orders?status=pending`

---

## Troubleshooting

1. **404 Not Found:**
   - Check if your server is running
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

