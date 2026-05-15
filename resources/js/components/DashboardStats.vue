<template>
    <div>
        <div v-if="store.loading" class="alert alert-info">
            Loading dashboard stats...
        </div>

        <div v-if="store.error" class="alert alert-danger">
            {{ store.error }}
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3" v-for="card in cards" :key="card.label">
                <div class="card erp-stat-card">
                    <div class="card-body">
                        <div class="erp-stat-label">
                            {{ card.label }}
                        </div>

                        <div class="erp-stat-value">
                            {{ card.value }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useDashboardStore } from '../stores/dashboardStore'

const store = useDashboardStore()

onMounted(() => {
    store.fetchStats()
})

const cards = computed(() => [
    {
        label: 'Total Sales',
        value: currency(store.stats.totalSales),
    },
    {
        label: 'Total Expenses',
        value: currency(store.stats.totalExpenses),
    },
    {
        label: 'Customers',
        value: store.stats.totalCustomers ?? 0,
    },
    {
        label: 'Products',
        value: store.stats.totalProducts ?? 0,
    },
    {
        label: 'Low Stock',
        value: store.stats.lowStockProducts ?? 0,
    },
    {
        label: 'Pending Invoices',
        value: store.stats.pendingInvoices ?? 0,
    },
])

function currency(value) {
    const amount = Number(value ?? 0)

    return amount.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    })
}
</script>
