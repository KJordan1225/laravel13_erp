<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $orders = SalesOrder::query()
            ->with('customer')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('order_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('order_date', '<=', $request->to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $total = (clone $orders->getCollection())->sum('total');

        return view('reports.sales', compact('orders', 'total'));
    }

    public function expenses(Request $request)
    {
        $expenses = Expense::query()
            ->with('vendor')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('expense_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('expense_date', '<=', $request->to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $total = Expense::query()
            ->when($request->filled('from'), fn ($q) => $q->whereDate('expense_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('expense_date', '<=', $request->to))
            ->sum('amount');

        return view('reports.expenses', compact('expenses', 'total'));
    }

    public function inventory()
    {
        $products = Product::query()
            ->with('category')
            ->orderBy('name')
            ->paginate(20);

        return view('reports.inventory', compact('products'));
    }

    public function customerBalances()
    {
        $customers = Customer::query()
            ->withSum('invoices as total_invoiced', 'total')
            ->withSum('payments as total_paid', 'amount')
            ->orderBy('name')
            ->paginate(20);

        return view('reports.customer-balances', compact('customers'));
    }

    public function vendorPurchases()
    {
        $vendors = Vendor::query()
            ->withSum('purchaseOrders as total_purchased', 'total')
            ->orderBy('name')
            ->paginate(20);

        return view('reports.vendor-purchases', compact('vendors'));
    }
}
