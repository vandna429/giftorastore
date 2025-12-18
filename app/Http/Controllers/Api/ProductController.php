<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Format product image URL
     *
     * @param string|null $imagePath
     * @return string|null
     */
    private function formatImageUrl(?string $imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        // If already a full path starting with uploads/, use it
        if (str_starts_with($imagePath, 'uploads/')) {
            return asset($imagePath);
        }

        // If it's just a filename, assume it's in uploads/products/
        if (!str_contains($imagePath, '/')) {
            return asset('uploads/products/' . $imagePath);
        }

        // Otherwise, try to construct the path
        return asset('uploads/products/' . basename($imagePath));
    }

    /**
     * Format category image URL
     *
     * @param string|null $imagePath
     * @param string|null $categorySlug Optional category slug for fallback icon lookup
     * @return string|null
     */
    private function formatCategoryImageUrl(?string $imagePath, ?string $categorySlug = null): ?string
    {
        // If image path exists in database, try to use it
        if (!empty($imagePath)) {
            // If already a full path starting with uploads/, use it
            if (str_starts_with($imagePath, 'uploads/')) {
                $fullPath = public_path($imagePath);
                if (file_exists($fullPath)) {
                    return asset($imagePath);
                }
            }

            // If it's just a filename, try uploads/categories/ first
            if (!str_contains($imagePath, '/')) {
                $testPath = public_path('uploads/categories/' . $imagePath);
                if (file_exists($testPath)) {
                    return asset('uploads/categories/' . $imagePath);
                }
            }

            // Try the path as-is
            $fullPath = public_path(ltrim($imagePath, '/'));
            if (file_exists($fullPath)) {
                return asset(ltrim($imagePath, '/'));
            }
        }

        // Fallback: Check for icon images in public/images/ folder
        if ($categorySlug) {
            $iconMappings = [
                'chocolates' => 'chocolates-icon.jpg',
                'roses' => 'roses-icon.jpg',
                'candles' => 'candles-icon.jpg',
                'mugs' => 'mugs-icon.jpg',
            ];

            if (isset($iconMappings[$categorySlug])) {
                $iconPath = 'images/' . $iconMappings[$categorySlug];
                $fullIconPath = public_path($iconPath);
                if (file_exists($fullIconPath)) {
                    return asset($iconPath);
                }
            }
        }

        return null;
    }

    /**
     * Format product data for API response
     *
     * @param Product $product
     * @return array
     */
    private function formatProductData(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => $this->formatImageUrl($product->image),
            'image_path' => $product->image, // Keep original path for reference
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
                'image' => $this->formatCategoryImageUrl($product->category->image, $product->category->slug),
                'image_path' => $product->category->image, // Keep original path for reference
            ] : null,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    }

    /**
     * Get all products with optional filtering
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $categorySlug = $request->query('category');
            $query = $request->query('search');
            $perPage = $request->query('per_page', 15);
            $page = $request->query('page', 1);

            // Validate pagination parameters
            $perPage = max(1, min(100, (int)$perPage));
            $page = max(1, (int)$page);

            $products = Product::with('category');

            // Filter by category
            if ($categorySlug) {
                $products->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            // Search filter
            if ($query) {
                $products->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                      ->orWhere('description', 'like', "%$query%");
                });
            }

            $products = $products->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $products->map(function ($product) {
                    return $this->formatProductData($product);
                })->values(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'last_page' => $products->lastPage(),
                ],
            ]);
        } catch (QueryException $e) {
            Log::error('Product API Error (index): ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Product API Error (index): ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get a single product by slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $product = Product::with('category')->where('slug', $slug)->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $this->formatProductData($product),
            ]);
        } catch (QueryException $e) {
            Log::error('Product API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching product',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Product API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching product',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get products by category slug
     *
     * @param string $categorySlug
     * @return JsonResponse
     */
    public function byCategory(string $categorySlug): JsonResponse
    {
        try {
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found',
                ], 404);
            }

            $products = Product::where('category_id', $category->id)
                ->with('category')
                ->get();

            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $this->formatImageUrl($category->image),
                ],
                'data' => $products->map(function ($product) {
                    return $this->formatProductData($product);
                })->values(),
            ]);
        } catch (QueryException $e) {
            Log::error('Product API Error (byCategory): ' . $e->getMessage(), [
                'exception' => $e,
                'categorySlug' => $categorySlug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching products by category',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Product API Error (byCategory): ' . $e->getMessage(), [
                'exception' => $e,
                'categorySlug' => $categorySlug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching products by category',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Search products by query string
     *
     * @param string $query
     * @return JsonResponse
     */
    public function search(string $query): JsonResponse
    {
        try {
            if (empty(trim($query))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query cannot be empty',
                ], 400);
            }

            $products = Product::where('name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->with('category')
                ->get();

            return response()->json([
                'success' => true,
                'query' => $query,
                'count' => $products->count(),
                'data' => $products->map(function ($product) {
                    return $this->formatProductData($product);
                })->values(),
            ]);
        } catch (QueryException $e) {
            Log::error('Product API Error (search): ' . $e->getMessage(), [
                'exception' => $e,
                'query' => $query
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while searching products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Product API Error (search): ' . $e->getMessage(), [
                'exception' => $e,
                'query' => $query
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Update stock quantity for a product
     *
     * @param Request $request
     * @param string|int $identifier Product ID or slug
     * @return JsonResponse
     */
    public function updateStock(Request $request, $identifier): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'stock' => 'required|integer|min:0',
            ]);

            // Find product by ID or slug
            if (is_numeric($identifier)) {
                $product = Product::with('category')->find($identifier);
            } else {
                $product = Product::with('category')->where('slug', $identifier)->first();
            }

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            // Update stock
            $oldStock = $product->stock;
            $product->stock = $validated['stock'];
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Stock quantity updated successfully',
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock,
                    'stock_change' => $product->stock - $oldStock,
                    'updated_at' => $product->updated_at,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            Log::error('Product API Error (updateStock): ' . $e->getMessage(), [
                'exception' => $e,
                'identifier' => $identifier,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while updating stock',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Product API Error (updateStock): ' . $e->getMessage(), [
                'exception' => $e,
                'identifier' => $identifier,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating stock',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}

