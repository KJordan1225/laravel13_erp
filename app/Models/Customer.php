<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_number',
        'company_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'tax_id',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'credit_limit',
        'balance',
        'payment_terms',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getDisplayNameAttribute(): string
    {
        if ($this->company_name) {
            return $this->company_name;
        }

        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getFullBillingAddressAttribute(): string
    {
        return collect([
            $this->billing_address,
            $this->billing_city,
            $this->billing_state,
            $this->billing_zip,
            $this->billing_country,
        ])->filter()->implode(', ');
    }

    public function getFullShippingAddressAttribute(): string
    {
        return collect([
            $this->shipping_address,
            $this->shipping_city,
            $this->shipping_state,
            $this->shipping_zip,
            $this->shipping_country,
        ])->filter()->implode(', ');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_number', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }
}
