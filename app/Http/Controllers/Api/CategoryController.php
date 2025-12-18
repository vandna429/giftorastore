<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Format category image URL
     *
     * @param string|null $imagePath
     * @param string|null $categorySlug Optional category slug for fallback icon lookup
     * @return string|null
     */
    private function formatImageUrl(?string $imagePath, ?string $categorySlug = null): ?string
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
     * Format product image URL (for products in category)
     *
     * @param string|null $imagePath
     * @return string|null
     */
    private function formatProductImageUrl(?string $imagePath): ?string
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
     * Get all categories
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::all();

            return response()->json([
                'success' => true,
                'count' => $categories->count(),
                'data' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image' => $this->formatImageUrl($category->image, $category->slug),
                        'image_path' => $category->image, // Keep original path for reference
                        'products_count' => $category->products()->count(),
                        'created_at' => $category->created_at,
                        'updated_at' => $category->updated_at,
                    ];
                }),
            ]);
        } catch (QueryException $e) {
            Log::error('Category API Error (index): ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching categories',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Category API Error (index): ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching categories',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get a single category by slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $this->formatImageUrl($category->image, $category->slug),
                    'image_path' => $category->image, // Keep original path for reference
                    'products_count' => $category->products()->count(),
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ],
            ]);
        } catch (QueryException $e) {
            Log::error('Category API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching category',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Category API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching category',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get all products in a category
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function products(string $slug): JsonResponse
    {
        try {
            $category = Category::where('slug', $slug)->first();

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
                    'image' => $this->formatImageUrl($category->image, $category->slug),
                ],
                'count' => $products->count(),
                'data' => $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'image' => $this->formatProductImageUrl($product->image),
                        'image_path' => $product->image,
                        'category' => $product->category ? [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                            'slug' => $product->category->slug,
                            'image' => $this->formatImageUrl($product->category->image),
                        ] : null,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ];
                }),
            ]);
        } catch (QueryException $e) {
            Log::error('Category API Error (products): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching category products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Category API Error (products): ' . $e->getMessage(), [
                'exception' => $e,
                'slug' => $slug
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching category products',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}

