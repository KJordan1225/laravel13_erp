<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'currency',
        'tax_rate',
        'logo_path',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
    ];
}
