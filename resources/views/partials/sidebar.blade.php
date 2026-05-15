{{-- resources/views/partials/sidebar.blade.php --}}

<aside class="bg-dark text-white vh-100 position-fixed start-0 top-0" style="width: 260px;">
    <div class="p-3 border-bottom border-secondary">
        <h4 class="mb-0">Laravel ERP</h4>
        <small class="text-secondary">Business Management</small>
    </div>

    <nav class="p-3">
        <ul class="nav flex-column gap-1">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary rounded' : '' }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-header text-uppercase text-secondary small mt-3 mb-1">
                Sales
            </li>

            <li class="nav-item">
                <a href="{{ route('customers.index') }}"
                   class="nav-link text-white {{ request()->routeIs('customers.*') ? 'active bg-primary rounded' : '' }}">
                    Customers
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('sales-orders.index') }}"
                   class="nav-link text-white {{ request()->routeIs('sales-orders.*') ? 'active bg-primary rounded' : '' }}">
                    Sales Orders
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('invoices.index') }}"
                   class="nav-link text-white {{ request()->routeIs('invoices.*') ? 'active bg-primary rounded' : '' }}">
                    Invoices
                </a>
            </li>

            <li class="nav-header text-uppercase text-secondary small mt-3 mb-1">
                Inventory
            </li>

            <li class="nav-item">
                <a href="{{ route('products.index') }}"
                   class="nav-link text-white {{ request()->routeIs('products.*') ? 'active bg-primary rounded' : '' }}">
                    Products
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('inventory.index') }}"
                   class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'active bg-primary rounded' : '' }}">
                    Inventory
                </a>
            </li>

            <li class="nav-header text-uppercase text-secondary small mt-3 mb-1">
                Purchasing
            </li>

            <li class="nav-item">
                <a href="{{ route('vendors.index') }}"
                   class="nav-link text-white {{ request()->routeIs('vendors.*') ? 'active bg-primary rounded' : '' }}">
                    Vendors
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('purchase-orders.index') }}"
                   class="nav-link text-white {{ request()->routeIs('purchase-orders.*') ? 'active bg-primary rounded' : '' }}">
                    Purchase Orders
                </a>
            </li>

            <li class="nav-header text-uppercase text-secondary small mt-3 mb-1">
                Accounting
            </li>

            <li class="nav-item">
                <a href="{{ route('payments.index') }}"
                   class="nav-link text-white {{ request()->routeIs('payments.*') ? 'active bg-primary rounded' : '' }}">
                    Payments
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('reports.index') }}"
                   class="nav-link text-white {{ request()->routeIs('reports.*') ? 'active bg-primary rounded' : '' }}">
                    Reports
                </a>
            </li>

            <li class="nav-header text-uppercase text-secondary small mt-3 mb-1">
                System
            </li>

            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-primary rounded' : '' }}">
                    Users
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('settings.index') }}"
                   class="nav-link text-white {{ request()->routeIs('settings.*') ? 'active bg-primary rounded' : '' }}">
                    Settings
                </a>
            </li>

            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</aside>