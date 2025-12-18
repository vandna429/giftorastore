# API Testing Script for PowerShell
# Run this script to test all API endpoints

$baseUrl = "http://localhost/my-app/public/api"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "API Testing Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Function to test an endpoint
function Test-Endpoint {
    param(
        [string]$Url,
        [string]$Name
    )
    
    Write-Host "Testing: $Name" -ForegroundColor Yellow
    Write-Host "URL: $Url" -ForegroundColor Gray
    
    try {
        $response = Invoke-WebRequest -Uri $Url -UseBasicParsing
        $json = $response.Content | ConvertFrom-Json
        
        if ($json.success) {
            Write-Host "✓ SUCCESS" -ForegroundColor Green
            Write-Host "Response: $($response.StatusCode)" -ForegroundColor Green
            if ($json.data) {
                Write-Host "Items returned: $($json.data.Count)" -ForegroundColor Green
            }
        } else {
            Write-Host "✗ FAILED" -ForegroundColor Red
            Write-Host "Message: $($json.message)" -ForegroundColor Red
        }
    } catch {
        Write-Host "✗ ERROR" -ForegroundColor Red
        Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    }
    
    Write-Host ""
}

# Test Products API
Write-Host "=== PRODUCTS API ===" -ForegroundColor Magenta
Test-Endpoint "$baseUrl/products" "List All Products"
Test-Endpoint "$baseUrl/products?per_page=5" "List Products (Paginated)"

# Test Categories API
Write-Host "=== CATEGORIES API ===" -ForegroundColor Magenta
Test-Endpoint "$baseUrl/categories" "List All Categories"

# Test Orders API
Write-Host "=== ORDERS API ===" -ForegroundColor Magenta
Test-Endpoint "$baseUrl/orders" "List All Orders"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Testing Complete!" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

