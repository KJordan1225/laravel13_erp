<template>
    <div>
        <label class="form-label">Product</label>

        <input
            v-model="query"
            type="text"
            class="form-control"
            placeholder="Search product by name or SKU"
            @input="search"
        >

        <div v-if="store.loading" class="small text-muted mt-2">
            Searching products...
        </div>

        <div v-if="store.error" class="text-danger small mt-2">
            {{ store.error }}
        </div>

        <div
            v-if="store.products.length > 0"
            class="list-group mt-2 product-selector-list"
        >
            <button
                v-for="product in store.products"
                :key="product.id"
                type="button"
                class="list-group-item list-group-item-action"
                @click="select(product)"
            >
                <div class="fw-bold">
                    {{ product.name }}
                </div>

                <div class="small text-muted">
                    {{ product.sku }} · Stock: {{ product.stock_quantity }} · Price: {{ currency(product.price) }}
                </div>
            </button>
        </div>

        <div v-if="store.selectedProduct" class="alert alert-primary mt-3 mb-0">
            Selected:
            <strong>{{ store.selectedProduct.name }}</strong>

            <button
                type="button"
                class="btn btn-sm btn-outline-danger ms-2"
                @click="clear"
            >
                Clear
            </button>
        </div>

        <input
            type="hidden"
            name="product_id"
            :value="store.selectedProduct ? store.selectedProduct.id : ''"
        >
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useProductStore } from '../stores/productStore'

const emit = defineEmits(['selected', 'cleared'])

const store = useProductStore()
const query = ref('')

let timeout = null

function search() {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        if (query.value.length >= 1) {
            store.searchProducts(query.value)
        }
    }, 300)
}

function select(product) {
    store.selectProduct(product)
    query.value = product.name
    store.products = []
    emit('selected', product)
}

function clear() {
    store.clearProduct()
    query.value = ''
    emit('cleared')
}

function currency(value) {
    return Number(value ?? 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    })
}
</script>

<style scoped>
.product-selector-list {
    max-height: 240px;
    overflow-y: auto;
}
</style>
