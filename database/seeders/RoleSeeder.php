<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        $manager = Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        $sales = Role::updateOrCreate(
            ['slug' => 'sales'],
            [
                'name' => 'Sales',
                'guard_name' => 'web',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        $inventory = Role::updateOrCreate(
            ['slug' => 'inventory'],
            [
                'name' => 'Inventory',
                'guard_name' => 'web',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        $accountant = Role::updateOrCreate(
            ['slug' => 'accountant'],
            [
                'name' => 'Accountant',
                'guard_name' => 'web',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Customers
            ['name' => 'View Customers', 'slug' => 'customers.view', 'module' => 'customers'],
            ['name' => 'Create Customers', 'slug' => 'customers.create', 'module' => 'customers'],
            ['name' => 'Edit Customers', 'slug' => 'customers.update', 'module' => 'customers'],
            ['name' => 'Delete Customers', 'slug' => 'customers.delete', 'module' => 'customers'],

            // Products
            ['name' => 'View Products', 'slug' => 'products.view', 'module' => 'products'],
            ['name' => 'Create Products', 'slug' => 'products.create', 'module' => 'products'],
            ['name' => 'Edit Products', 'slug' => 'products.update', 'module' => 'products'],
            ['name' => 'Delete Products', 'slug' => 'products.delete', 'module' => 'products'],

            // Inventory
            ['name' => 'View Inventory', 'slug' => 'inventory.view', 'module' => 'inventory'],
            ['name' => 'Adjust Inventory', 'slug' => 'inventory.adjust', 'module' => 'inventory'],

            // Sales Orders
            ['name' => 'View Sales Orders', 'slug' => 'sales_orders.view', 'module' => 'sales_orders'],
            ['name' => 'Create Sales Orders', 'slug' => 'sales_orders.create', 'module' => 'sales_orders'],
            ['name' => 'Edit Sales Orders', 'slug' => 'sales_orders.update', 'module' => 'sales_orders'],
            ['name' => 'Approve Sales Orders', 'slug' => 'sales_orders.approve', 'module' => 'sales_orders'],

            // Invoices
            ['name' => 'View Invoices', 'slug' => 'invoices.view', 'module' => 'invoices'],
            ['name' => 'Create Invoices', 'slug' => 'invoices.create', 'module' => 'invoices'],
            ['name' => 'Send Invoices', 'slug' => 'invoices.send', 'module' => 'invoices'],
            ['name' => 'Mark Invoices Paid', 'slug' => 'invoices.mark_paid', 'module' => 'invoices'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'module' => 'reports'],

            // Settings
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'module' => 'settings'],

            // Users
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'module' => 'users'],

            // Roles
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'module' => 'roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'],
                    'module' => $permission['module'],
                    'guard_name' => 'web',
                    'is_active' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        // Admin gets everything
        $admin->permissions()->sync(
            Permission::pluck('id')->toArray()
        );

        // Manager
        $manager->permissions()->sync(
            Permission::whereIn('slug', [
                'customers.view',
                'customers.create',
                'customers.update',

                'products.view',

                'inventory.view',

                'sales_orders.view',
                'sales_orders.create',
                'sales_orders.update',
                'sales_orders.approve',

                'invoices.view',

                'reports.view',
            ])->pluck('id')->toArray()
        );

        // Sales
        $sales->permissions()->sync(
            Permission::whereIn('slug', [
                'customers.view',
                'customers.create',

                'products.view',

                'sales_orders.view',
                'sales_orders.create',

                'invoices.view',
                'invoices.create',
            ])->pluck('id')->toArray()
        );

        // Inventory
        $inventory->permissions()->sync(
            Permission::whereIn('slug', [
                'products.view',
                'products.update',

                'inventory.view',
                'inventory.adjust',
            ])->pluck('id')->toArray()
        );

        // Accountant
        $accountant->permissions()->sync(
            Permission::whereIn('slug', [
                'invoices.view',
                'invoices.create',
                'invoices.send',
                'invoices.mark_paid',

                'reports.view',
            ])->pluck('id')->toArray()
        );
    }
}
