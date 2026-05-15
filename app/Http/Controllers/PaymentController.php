<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->with(['customer', 'invoice'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where('payment_number', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return redirect()
            ->route('invoices.index')
            ->with('error', 'Create payments from an invoice record.');
    }

    public function store(Request $request)
    {
        abort(501);
    }

    public function show(Payment $payment)
    {
        $payment->load(['customer', 'invoice']);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        abort(501);
    }

    public function update(Request $request, Payment $payment)
    {
        abort(501);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
