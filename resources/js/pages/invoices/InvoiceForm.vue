<template>
    <form @submit.prevent="submit">
        <div v-if="store.error" class="alert alert-danger">
            {{ store.error }}
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">Customer & Invoice Details</div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <customer-selector @selected="store.setCustomer" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice Date</label>
                        <input v-model="store.invoiceDate" type="date" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Due Date</label>
                        <input v-model="store.dueDate" type="date" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select v-model="store.status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="paid">Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Notes</label>
                        <input
                            v-model="store.notes"
                            type="text"
                            class="form-control"
                            placeholder="Optional invoice notes"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Add Invoice Items</span>

                <button
                    type="button"
                    class="btn btn-sm btn-orange"
                    @click="store.addManualLine"
                >
                    Add Manual Line
                </button>
            </div>

            <div class="card-body">
                <product-selector @selected="addProduct" />
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">Invoice Items</div>

            <div class="card-body p-0">
                <div v-if="store.items.length === 0" class="p-4 text-center text-muted">
                    No invoice items added yet.
                </div>

                <div v-else class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Description</th>
                                <th style="width: 130px;">Qty</th>
                                <th style="width: 160px;">Unit Price</th>
                                <th style="width: 160px;">Line Total</th>
                                <th style="width: 90px;"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(item, index) in store.items" :key="index">
                                <td>
                                    <input
                                        v-model="item.sku"
                                        type="text"
                                        class="form-control form-control-sm"
                                    >
                                </td>

                                <td>
                                    <input
                                        v-model="item.description"
                                        type="text"
                                        class="form-control form-control-sm"
                                        required
                                    >
                                </td>

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
            <div class="card-header">Invoice Totals</div>

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
                        <label class="form-label">Discount</label>
                        <input
                            v-model.number="store.discountAmount"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Amount Paid</label>
                        <input
                            v-model.number="store.amountPaid"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-4">
                        <div class="erp-total-box mt-3">
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

                            <div class="d-flex justify-content-between">
                                <span>Paid:</span>
                                <strong>{{ currency(store.amountPaid) }}</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fs-5">
                                <span>Total:</span>
                                <strong>{{ currency(store.total) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between fs-5 text-danger">
                                <span>Balance:</span>
                                <strong>{{ currency(store.balanceDue) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" @click="store.reset">
                    Reset
                </button>

                <button type="submit" class="btn btn-primary" :disabled="store.loading">
                    {{ store.loading ? 'Saving...' : 'Save Invoice' }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useInvoiceStore } from '../../stores/invoiceStore'
import { useNotificationStore } from '../../stores/notificationStore'

const store = useInvoiceStore()
const notifications = useNotificationStore()

function addProduct(product) {
    store.addProduct(product)
    notifications.success(`${product.name} added to invoice.`)
}

async function submit() {
    if (!store.customer) {
        notifications.error('Please select a customer.')
        return
    }

    if (store.items.length === 0) {
        notifications.error('Please add at least one invoice item.')
        return
    }

    try {
        const response = await store.submit()

        notifications.success('Invoice saved successfully.')

        if (response.redirect_url) {
            window.location.href = response.redirect_url
        }
    } catch (error) {
        notifications.error('Invoice could not be saved.')
    }
}

function currency(value) {
    return Number(value ?? 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    })
}
</script>
