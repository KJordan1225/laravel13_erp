@extends('layouts.app')

@section('title', 'Vendor Purchases')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Vendor Purchase Report</h1>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th class="text-end">Total Purchased</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->name }}</td>
                            <td class="text-end">${{ number_format($vendor->total_purchased ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $vendors->links() }}</div>
    </div>
</div>
@endsection
