<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Get all orders with optional filtering
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $status = $request->query('status');
            $perPage = $request->query('per_page', 15);
            $page = $request->query('page', 1);

            // Validate pagination parameters
            $perPage = max(1, min(100, (int)$perPage));
            $page = max(1, (int)$page);

            $orders = Order::with(['user', 'items.product']);

            // Filter by status
            if ($status) {
                $orders->where('status', $status);
            }

            $orders = $orders->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $orders->map(function ($order) {
                    return $this->formatOrder($order);
                }),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                ],
            ]);
        } catch (QueryException $e) {
            Log::error('Order API Error (index): ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching orders',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Order API Error (index): ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching orders',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get a single order by ID
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order ID',
                ], 400);
            }

            $order = Order::with(['user', 'items.product'])->find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $this->formatOrder($order),
            ]);
        } catch (QueryException $e) {
            Log::error('Order API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while fetching order',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Exception $e) {
            Log::error('Order API Error (show): ' . $e->getMessage(), [
                'exception' => $e,
                'id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching order',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Format order data for JSON response
     *
     * @param Order $order
     * @return array
     */
    private function formatOrder(Order $order): array
    {
        try {
            return [
                'id' => $order->id,
                'user' => $order->user ? [
                    'id' => $order->user->id,
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                ] : null,
                'name' => $order->name,
                'phone' => $order->phone,
                'email' => $order->email,
                'address' => $order->address,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product' => $item->product ? [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'slug' => $item->product->slug,
                            'image' => $item->product->image,
                        ] : null,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->quantity * $item->price,
                    ];
                }),
                'items_count' => $order->items->count(),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        } catch (Exception $e) {
            Log::error('Order API Error (formatOrder): ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $order->id ?? null
            ]);
            
            // Return basic order data if formatting fails
            return [
                'id' => $order->id ?? null,
                'error' => 'Error formatting order data',
            ];
        }
    }
}

