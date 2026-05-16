<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'manage customers',
            'manage vendors',
            'manage employees',
            'manage departments',
            'manage products',
            'manage categories',
            'manage warehouses',
            'manage inventory',
            'manage sales orders',
            'manage purchase orders',
            'manage invoices',
            'manage payments',
            'manage expenses',
            'view reports',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'slug' => Str::slug($permission),
            ], [
                'name' => ucwords($permission),
            ]);
        }

        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            $adminRole->permissions()->sync(
                Permission::pluck('id')->toArray()
            );
        }

        $managerRole = Role::where('slug', 'manager')->first();

        if ($managerRole) {
            $managerRole->permissions()->sync(
                Permission::whereIn('slug', [
                    'manage-customers',
                    'manage-vendors',
                    'manage-employees',
                    'manage-departments',
                    'manage-products',
                    'manage-categories',
                    'manage-warehouses',
                    'manage-inventory',
                    'manage-sales-orders',
                    'manage-purchase-orders',
                    'manage-invoices',
                    'manage-payments',
                    'manage-expenses',
                    'view-reports',
                ])->pluck('id')->toArray()
            );
        }

        $accountantRole = Role::where('slug', 'accountant')->first();

        if ($accountantRole) {
            $accountantRole->permissions()->sync(
                Permission::whereIn('slug', [
                    'manage-invoices',
                    'manage-payments',
                    'manage-expenses',
                    'view-reports',
                ])->pluck('id')->toArray()
            );
        }

        $salesRole = Role::where('slug', 'sales')->first();

        if ($salesRole) {
            $salesRole->permissions()->sync(
                Permission::whereIn('slug', [
                    'manage-customers',
                    'manage-sales-orders',
                    'manage-invoices',
                ])->pluck('id')->toArray()
            );
        }

        $inventoryRole = Role::where('slug', 'inventory-clerk')->first();

        if ($inventoryRole) {
            $inventoryRole->permissions()->sync(
                Permission::whereIn('slug', [
                    'manage-products',
                    'manage-categories',
                    'manage-warehouses',
                    'manage-inventory',
                ])->pluck('id')->toArray()
            );
        }
    }
}
