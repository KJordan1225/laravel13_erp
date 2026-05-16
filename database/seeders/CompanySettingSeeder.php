<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    public function run(): void
    {
        CompanySetting::firstOrCreate([], [
            'company_name' => 'Laravel ERP',
            'email' => 'admin@example.com',
            'phone' => '555-555-5555',
            'address' => '123 Business Street, Roanoke, VA',
            'currency' => 'USD',
            'tax_rate' => 0,
        ]);
    }
}


