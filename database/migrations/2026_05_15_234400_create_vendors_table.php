<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Basic Vendor Information
            |--------------------------------------------------------------------------
            */

            $table->string('vendor_number')->unique();

            $table->string('company_name');

            $table->string('contact_name')->nullable();

            $table->string('email')->nullable()->index();

            $table->string('phone')->nullable();

            $table->string('mobile')->nullable();

            $table->string('website')->nullable();

            $table->string('tax_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->string('address_line_1')->nullable();

            $table->string('address_line_2')->nullable();

            $table->string('city')->nullable();

            $table->string('state')->nullable();

            $table->string('postal_code')->nullable();

            $table->string('country')->default('USA');

            /*
            |--------------------------------------------------------------------------
            | Accounting Information
            |--------------------------------------------------------------------------
            */

            $table->string('payment_terms')->nullable();

            $table->string('currency', 10)->default('USD');

            $table->decimal('opening_balance', 12, 2)->default(0);

            $table->decimal('current_balance', 12, 2)->default(0);

            /*
            |--------------------------------------------------------------------------
            | Banking Information
            |--------------------------------------------------------------------------
            */

            $table->string('bank_name')->nullable();

            $table->string('bank_account_number')->nullable();

            $table->string('bank_routing_number')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ERP Metadata
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);

            $table->longText('notes')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('company_name');

            $table->index('vendor_number');

            $table->index([
                'company_name',
                'is_active'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};