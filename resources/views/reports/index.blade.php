@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Reports</h1>

    <div class="row g-4">
        @php
            $reports = [
                ['title' => 'Sales Report', 'url' => route('reports.sales')],
                ['title' => 'Expense Report', 'url' => route('reports.expenses')],
                ['title' => 'Inventory Report', 'url' => route('reports.inventory')],
                ['title' => 'Customer Balance Report', 'url' => route('reports.customer-balances')],
                ['title' => 'Vendor Purchase Report', 'url' => route('reports.vendor-purchases')],
            ];
        @endphp

        @foreach($reports as $report)
            <div class="col-md-4">
                <div class="card erp-card h-100">
                    <div class="card-body">
                        <h5>{{ $report['title'] }}</h5>
                        <a href="{{ $report['url'] }}" class="btn btn-primary mt-3">Open Report</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
