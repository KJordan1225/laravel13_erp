<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Http\JsonResponse;

class DashboardStatsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'stats' => [
                'totalSales' => SalesOrder::where('status', 'completed')->sum('total'),
                'totalExpenses' => 0,
                'totalCustomers' => Customer::count(),
                'totalProducts' => Product::count(),
                'lowStockProducts' => Product::whereColumn('stock_quantity', '<=', 'reorder_level')->count(),
                'pendingInvoices' => Invoice::whereIn('status', ['draft', 'sent', 'overdue'])->count(),
            ],

            'recentOrders' => SalesOrder::with('customer:id,name')
                ->latest()
                ->take(5)
                ->get(['id', 'customer_id', 'order_number', 'total', 'status', 'created_at']),

            'recentPayments' => Payment::with(['customer:id,name', 'invoice:id,invoice_number'])
                ->latest()
                ->take(5)
                ->get(['id', 'customer_id', 'invoice_id', 'payment_number', 'amount', 'status', 'created_at']),
        ]);
    }
}
