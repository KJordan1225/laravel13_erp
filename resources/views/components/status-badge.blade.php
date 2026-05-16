@props([
    'status' => 'inactive'
])

@php
    $classes = match($status) {
        'active' => 'bg-success',
        'inactive' => 'bg-secondary',
        'pending' => 'bg-warning text-dark',
        'cancelled' => 'bg-danger',
        default => 'bg-light text-dark',
    };
@endphp

<span {{ $attributes->merge(['class' => "badge {$classes}"]) }}>
    {{ ucfirst($status) }}
</span>