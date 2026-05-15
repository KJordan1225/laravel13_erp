<template>
    <div>
        <label class="form-label">Customer</label>

        <input
            v-model="query"
            type="text"
            class="form-control"
            placeholder="Search customer by name, email, or customer number"
            @input="search"
        >

        <div v-if="store.loading" class="small text-muted mt-2">
            Searching customers...
        </div>

        <div v-if="store.error" class="text-danger small mt-2">
            {{ store.error }}
        </div>

        <div
            v-if="store.customers.length > 0"
            class="list-group mt-2 customer-selector-list"
        >
            <button
                v-for="customer in store.customers"
                :key="customer.id"
                type="button"
                class="list-group-item list-group-item-action"
                @click="select(customer)"
            >
                <div class="fw-bold">
                    {{ customer.name }}
                </div>

                <div class="small text-muted">
                    {{ customer.customer_number }} · {{ customer.email ?? 'No email' }}
                </div>
            </button>
        </div>

        <div v-if="store.selectedCustomer" class="alert alert-primary mt-3 mb-0">
            Selected:
            <strong>{{ store.selectedCustomer.name }}</strong>

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
            name="customer_id"
            :value="store.selectedCustomer ? store.selectedCustomer.id : ''"
        >
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useCustomerStore } from '../stores/customerStore'

const emit = defineEmits(['selected', 'cleared'])

const store = useCustomerStore()
const query = ref('')

let timeout = null

function search() {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        if (query.value.length >= 1) {
            store.searchCustomers(query.value)
        }
    }, 300)
}

function select(customer) {
    store.selectCustomer(customer)
    query.value = customer.name
    store.customers = []
    emit('selected', customer)
}

function clear() {
    store.clearCustomer()
    query.value = ''
    emit('cleared')
}
</script>

<style scoped>
.customer-selector-list {
    max-height: 240px;
    overflow-y: auto;
}
</style>
