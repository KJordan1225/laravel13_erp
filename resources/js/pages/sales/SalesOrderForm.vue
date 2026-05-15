<template>
    <form @submit.prevent="submit">
        <div v-if="store.error" class="alert alert-danger">
            {{ store.error }}
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Customer & Order Details
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <customer-selector @selected="store.setCustomer" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Order Date</label>
                        <input
                            v-model="store.orderDate"
                            type="date"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Due Date</label>
                        <input
                            v-model="store.dueDate"
                            type="date"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select v-model="store.status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Notes</label>
                        <input
                            v-model="store.notes"
                            type="text"
                            class="form-control"
                            placeholder="Optional order notes"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Add Products
            </div>

            <div class="card-body">
                <product-selector @selected="addProduct" />
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Order Items
            </div>

            <div class="card-body p-0">
                <div v-if="store.items.length === 0" class="p-4 text-center text-muted">
                    No products added yet.
                </div>

                <div v-else class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th style="width: 140px;">Qty</th>
                                <th style="width: 160px;">Unit Price</th>
                                <th style="width: 160px;">Line Total</th>
                                <th style="width: 90px;"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(item, index) in store.items" :key="item.product_id">
                                <td>{{ item.sku }}</td>
                                <td>{{ item.product_name }}</td>

                                <td>
                                    <input
                                        v-model.number="item.quantity"
                                        type="number"
                                        min="1"
                                        class="form-control form-control-sm"
                                        @input="store.updateItem(index)"
                                    >
                                </td>

                                <td>
                                    <input
                                        v-model.number="item.unit_price"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        class="form-control form-control-sm"
                                        @input="store.updateItem(index)"
                                    >
                                </td>

                                <td>{{ currency(item.line_total) }}</td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        @click="store.removeItem(index)"
                                    >
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Totals
            </div>

            <div class="card-body">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-3">
                        <label class="form-label">Tax Rate %</label>
                        <input
                            v-model.number="store.taxRate"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Discount Amount</label>
                        <input
                            v-model.number="store.discountAmount"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-4">
                        <div class="erp-total-box">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <strong>{{ currency(store.subtotal) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Tax:</span>
                                <strong>{{ currency(store.taxAmount) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Discount:</span>
                                <strong>{{ currency(store.discountAmount) }}</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fs-5">
                                <span>Total:</span>
                                <strong>{{ currency(store.total) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <button
                    type="button"
                    class="btn btn-secondary"
                    @click="store.reset"
                >
                    Reset
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="store.loading"
                >
                    {{ store.loading ? 'Saving...' : 'Save Sales Order' }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useSalesOrderStore } from '../../stores/salesOrderStore'
import { useNotificationStore } from '../../stores/notificationStore'

const store = useSalesOrderStore()
const notifications = useNotificationStore()

function addProduct(product) {
    store.addProduct(product)
    notifications.success(`${product.name} added to order.`)
}

async function submit() {
    if (!store.customer) {
        notifications.error('Please select a customer.')
        return
    }

    if (store.items.length === 0) {
        notifications.error('Please add at least one product.')
        return
    }

    try {
        const response = await store.submit()

        notifications.success('Sales order saved successfully.')

        if (response.redirect_url) {
            window.location.href = response.redirect_url
        }
    } catch (error) {
        notifications.error('Sales order could not be saved.')
    }
}

function currency(value) {
    return Number(value ?? 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    })
}
</script>

<style scoped>
.erp-total-box {
    background: #f8fafc;
    border-radius: .75rem;
    padding: 1rem;
    border-left: 5px solid var(--erp-orange);
}
</style>
