<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->string('q')->toString();

        $customers = Customer::query()
            ->where('status', 'active')
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('customer_number', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%");
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'customer_number',
                'name',
                'email',
                'phone',
                'status',
            ]);

        return response()->json([
            'data' => $customers,
        ]);
    }
}
