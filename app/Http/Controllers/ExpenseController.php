<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::query()
            ->with(['vendor', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where('expense_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();

        return view('expenses.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'expense_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,approved,paid,rejected'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = auth()->id;
        $validated['expense_number'] = $this->generateExpenseNumber();

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['vendor', 'user']);

        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();

        return view('expenses.edit', compact('expense', 'vendors'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'expense_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,approved,paid,rejected'],
            'notes' => ['nullable', 'string'],
        ]);

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    private function generateExpenseNumber(): string
    {
        $prefix = 'EXP-' . now()->format('Ymd') . '-';

        $lastExpense = Expense::where('expense_number', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastExpense) {
            $lastSequence = (int) str_replace($prefix, '', $lastExpense->expense_number);
            $nextNumber = $lastSequence + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
