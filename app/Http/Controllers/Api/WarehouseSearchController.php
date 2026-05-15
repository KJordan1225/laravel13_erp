<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;

class WarehouseSearchController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => Warehouse::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'location']),
        ]);
    }
}
