<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('category')->nullable()->index();
            $table->string('brand')->nullable();

            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('sale_price', 12, 2)->default(0);
            $table->decimal('wholesale_price', 12, 2)->nullable();

            $table->integer('quantity_on_hand')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->integer('reorder_quantity')->default(0);

            $table->string('unit_of_measure')->default('each');

            $table->decimal('weight', 10, 2)->nullable();
            $table->string('weight_unit')->default('lb');

            $table->boolean('is_taxable')->default(true);
            $table->boolean('is_active')->default(true);

            $table->string('image_path')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'name']);
            $table->index(['category', 'brand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
