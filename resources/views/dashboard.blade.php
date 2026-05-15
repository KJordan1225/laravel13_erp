@extends('layouts.app')

@section('title', 'ERP Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">ERP Dashboard</h1>
            <p class="text-muted mb-0">Overview of your business activity.</p>
        </div>
    </div>

    <dashboard-stats></dashboard-stats>
    <dashboard-widgets></dashboard-widgets>
</div>
@endsection