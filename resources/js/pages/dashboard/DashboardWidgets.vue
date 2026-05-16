<template>
    <div class="row g-4">
        <div
            v-for="widget in widgets"
            :key="widget.title"
            class="col-12 col-sm-6 col-xl-3"
        >
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">
                            {{ widget.title }}
                        </p>

                        <h4 class="fw-bold mb-1">
                            {{ widget.value }}
                        </h4>

                        <span
                            class="small"
                            :class="widget.trend >= 0 ? 'text-success' : 'text-danger'"
                        >
                            {{ widget.trend >= 0 ? '+' : '' }}{{ widget.trend }}%
                            {{ widget.trendLabel }}
                        </span>
                    </div>

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        :class="widget.bgClass"
                        style="width: 52px; height: 52px;"
                    >
                        <i :class="widget.icon" class="fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Sales Overview</h5>
                </div>

                <div class="card-body">
                    <div
                        v-for="sale in salesOverview"
                        :key="sale.month"
                        class="mb-3"
                    >
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold">{{ sale.month }}</span>
                            <span class="small text-muted">${{ sale.amount.toLocaleString() }}</span>
                        </div>

                        <div class="progress" style="height: 8px;">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                :style="{ width: sale.percent + '%' }"
                                :aria-valuenow="sale.percent"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>

                <div class="card-body d-grid gap-2">
                    <RouterLink
                        v-for="action in quickActions"
                        :key="action.label"
                        :to="action.to"
                        class="btn btn-outline-primary text-start"
                    >
                        <i :class="action.icon" class="me-2"></i>
                        {{ action.label }}
                    </RouterLink>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Recent Orders</h5>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="order in recentOrders" :key="order.number">
                                <td>{{ order.number }}</td>
                                <td>{{ order.customer }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="statusClass(order.status)"
                                    >
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    ${{ order.total.toLocaleString() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Low Stock Products</h5>
                </div>

                <div class="list-group list-group-flush">
                    <div
                        v-for="product in lowStockProducts"
                        :key="product.sku"
                        class="list-group-item d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <div class="fw-semibold">{{ product.name }}</div>
                            <small class="text-muted">SKU: {{ product.sku }}</small>
                        </div>

                        <span class="badge bg-danger">
                            {{ product.stock }} left
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const widgets = [
    {
        title: 'Total Revenue',
        value: '$128,450',
        trend: 12.5,
        trendLabel: 'this month',
        icon: 'bi bi-currency-dollar text-success',
        bgClass: 'bg-success-subtle',
    },
    {
        title: 'Customers',
        value: '1,284',
        trend: 8.2,
        trendLabel: 'growth',
        icon: 'bi bi-people text-primary',
        bgClass: 'bg-primary-subtle',
    },
    {
        title: 'Products',
        value: '642',
        trend: 3.1,
        trendLabel: 'added',
        icon: 'bi bi-box-seam text-warning',
        bgClass: 'bg-warning-subtle',
    },
    {
        title: 'Pending Invoices',
        value: '37',
        trend: -4.7,
        trendLabel: 'decrease',
        icon: 'bi bi-receipt text-danger',
        bgClass: 'bg-danger-subtle',
    },
]

const salesOverview = [
    { month: 'January', amount: 18000, percent: 45 },
    { month: 'February', amount: 26500, percent: 66 },
    { month: 'March', amount: 32000, percent: 80 },
    { month: 'April', amount: 41000, percent: 100 },
]

const quickActions = [
    {
        label: 'Create Customer',
        to: '/customers/create',
        icon: 'bi bi-person-plus',
    },
    {
        label: 'Add Product',
        to: '/products/create',
        icon: 'bi bi-plus-square',
    },
    {
        label: 'Create Sales Order',
        to: '/sales-orders/create',
        icon: 'bi bi-cart-plus',
    },
    {
        label: 'Generate Invoice',
        to: '/invoices/create',
        icon: 'bi bi-file-earmark-text',
    },
]

const recentOrders = [
    {
        number: 'SO-1001',
        customer: 'Acme Corporation',
        status: 'Approved',
        total: 4200,
    },
    {
        number: 'SO-1002',
        customer: 'Blue Ridge Supply',
        status: 'Pending',
        total: 1850,
    },
    {
        number: 'SO-1003',
        customer: 'Jordan Logistics',
        status: 'Draft',
        total: 960,
    },
]

const lowStockProducts = [
    {
        name: 'Wireless Barcode Scanner',
        sku: 'INV-1001',
        stock: 4,
    },
    {
        name: 'Thermal Receipt Printer',
        sku: 'INV-1002',
        stock: 7,
    },
    {
        name: 'POS Cash Drawer',
        sku: 'INV-1003',
        stock: 3,
    },
]

const statusClass = (status) => {
    return {
        Approved: 'bg-success',
        Pending: 'bg-warning text-dark',
        Draft: 'bg-secondary',
        Cancelled: 'bg-danger',
    }[status] ?? 'bg-light text-dark'
}
</script>