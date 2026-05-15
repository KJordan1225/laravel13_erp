<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class DashboardStatsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'stats' => [
                'totalSales' => 0,
                'totalExpenses' => 0,
                'totalCustomers' => Customer::count(),
                'totalProducts' => Product::count(),
                'lowStockProducts' => Product::whereColumn('stock_quantity', '<=', 'reorder_level')->count(),
                'pendingInvoices' => 0,
            ],
            'recentOrders' => [],
            'recentPayments' => [],
        ]);
    }
}