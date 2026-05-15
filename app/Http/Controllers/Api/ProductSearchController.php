<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->string('q')->toString();

        $products = Product::query()
            ->with('category:id,name')
            ->where('status', 'active')
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'category_id',
                'sku',
                'name',
                'price',
                'cost',
                'stock_quantity',
                'reorder_level',
                'status',
            ]);

        return response()->json([
            'data' => $products,
        ]);
    }
}
