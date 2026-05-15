<template>
    <form @submit.prevent="submit">
        <div v-if="store.error" class="alert alert-danger">
            {{ store.error }}
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Product
            </div>

            <div class="card-body">
                <product-selector @selected="store.setProduct" />

                <div v-if="store.product" class="alert alert-primary mt-3 mb-0">
                    <div><strong>Selected Product:</strong> {{ store.product.name }}</div>
                    <div><strong>SKU:</strong> {{ store.product.sku }}</div>
                    <div><strong>Current Stock:</strong> {{ store.product.stock_quantity }}</div>
                </div>
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">
                Movement Details
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Warehouse</label>
                        <select v-model="store.warehouseId" class="form-select">
                            <option value="">No warehouse selected</option>
                            <option
                                v-for="warehouse in store.warehouses"
                                :key="warehouse.id"
                                :value="warehouse.id"
                            >
                                {{ warehouse.name }} — {{ warehouse.code }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Movement Type</label>
                        <select v-model="store.type" class="form-select" required>
                            <option value="stock_in">Stock In</option>
                            <option value="stock_out">Stock Out</option>
                            <option value="adjustment">Adjustment</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input
                            v-model.number="store.quantity"
                            type="number"
                            min="1"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea
                            v-model="store.notes"
                            class="form-control"
                            rows="3"
                            placeholder="Reason for inventory movement"
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" @click="store.reset">
                    Reset
                </button>

                <button type="submit" class="btn btn-primary" :disabled="store.loading">
                    {{ store.loading ? 'Saving...' : 'Save Movement' }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { onMounted } from 'vue'
import { useInventoryStore } from '../../stores/inventoryStore'
import { useNotificationStore } from '../../stores/notificationStore'

const store = useInventoryStore()
const notifications = useNotificationStore()

onMounted(() => {
    store.fetchWarehouses()
})

async function submit() {
    if (!store.product) {
        notifications.error('Please select a product.')
        return
    }

    if (!store.quantity || store.quantity < 1) {
        notifications.error('Quantity must be at least 1.')
        return
    }

    try {
        const response = await store.submit()

        notifications.success('Inventory movement saved successfully.')

        if (response.redirect_url) {
            window.location.href = response.redirect_url
        }
    } catch {
        notifications.error('Inventory movement could not be saved.')
    }
}
</script>
