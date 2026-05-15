@extends('layouts.app')

@section('title', 'Vue Selector Test')

@section('content')
<div class="container-fluid">
    <div class="card erp-card">
        <div class="card-header">
            Vue Selector Test
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <customer-selector></customer-selector>
                </div>

                <div class="col-md-6">
                    <product-selector></product-selector>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
