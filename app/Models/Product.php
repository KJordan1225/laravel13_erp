<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'slug',
        'description',
        'category',
        'brand',
        'cost_price',
        'sale_price',
        'wholesale_price',
        'quantity_on_hand',
        'reorder_level',
        'reorder_quantity',
        'unit_of_measure',
        'weight',
        'weight_unit',
        'is_taxable',
        'is_active',
        'image_path',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'quantity_on_hand' => 'integer',
        'reorder_level' => 'integer',
        'reorder_quantity' => 'integer',
        'weight' => 'decimal:2',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function getProfitAttribute(): float
    {
        return (float) $this->sale_price - (float) $this->cost_price;
    }

    public function getProfitMarginAttribute(): float
    {
        if ((float) $this->sale_price <= 0) {
            return 0;
        }

        return round(($this->profit / (float) $this->sale_price) * 100, 2);
    }

    public function getNeedsReorderAttribute(): bool
    {
        return $this->quantity_on_hand <= $this->reorder_level;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('quantity_on_hand', '>', 0);
    }

    public function scopeNeedsReorder(Builder $query): Builder
    {
        return $query->whereColumn('quantity_on_hand', '<=', 'reorder_level');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        });
    }
}
