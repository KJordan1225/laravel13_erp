<template>
    <form @submit.prevent="submitForm" class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-bold">
                {{ isEdit ? 'Edit Customer' : 'Create Customer' }}
            </h5>
        </div>

        <div class="card-body">
            <div v-if="formError" class="alert alert-danger">
                {{ formError }}
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.name }"
                        placeholder="Acme Corporation"
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Customer Type</label>
                    <select
                        v-model="form.type"
                        class="form-select"
                        :class="{ 'is-invalid': errors.type }"
                    >
                        <option value="">Select type</option>
                        <option value="individual">Individual</option>
                        <option value="business">Business</option>
                    </select>
                    <div v-if="errors.type" class="invalid-feedback">
                        {{ errors.type[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="form-control"
                        :class="{ 'is-invalid': errors.email }"
                        placeholder="customer@example.com"
                    />
                    <div v-if="errors.email" class="invalid-feedback">
                        {{ errors.email[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input
                        v-model="form.phone"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.phone }"
                        placeholder="540-555-1234"
                    />
                    <div v-if="errors.phone" class="invalid-feedback">
                        {{ errors.phone[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Company Name</label>
                    <input
                        v-model="form.company_name"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.company_name }"
                        placeholder="Acme Corporation"
                    />
                    <div v-if="errors.company_name" class="invalid-feedback">
                        {{ errors.company_name[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tax Number</label>
                    <input
                        v-model="form.tax_number"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.tax_number }"
                        placeholder="Tax/VAT/EIN"
                    />
                    <div v-if="errors.tax_number" class="invalid-feedback">
                        {{ errors.tax_number[0] }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Billing Address</label>
                    <textarea
                        v-model="form.billing_address"
                        class="form-control"
                        :class="{ 'is-invalid': errors.billing_address }"
                        rows="2"
                        placeholder="Street, city, state, postal code"
                    ></textarea>
                    <div v-if="errors.billing_address" class="invalid-feedback">
                        {{ errors.billing_address[0] }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Shipping Address</label>
                    <textarea
                        v-model="form.shipping_address"
                        class="form-control"
                        :class="{ 'is-invalid': errors.shipping_address }"
                        rows="2"
                        placeholder="Street, city, state, postal code"
                    ></textarea>
                    <div v-if="errors.shipping_address" class="invalid-feedback">
                        {{ errors.shipping_address[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Credit Limit</label>
                    <input
                        v-model.number="form.credit_limit"
                        type="number"
                        min="0"
                        step="0.01"
                        class="form-control"
                        :class="{ 'is-invalid': errors.credit_limit }"
                    />
                    <div v-if="errors.credit_limit" class="invalid-feedback">
                        {{ errors.credit_limit[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payment Terms</label>
                    <select
                        v-model="form.payment_terms"
                        class="form-select"
                        :class="{ 'is-invalid': errors.payment_terms }"
                    >
                        <option value="">Select terms</option>
                        <option value="due_on_receipt">Due on Receipt</option>
                        <option value="net_7">Net 7</option>
                        <option value="net_15">Net 15</option>
                        <option value="net_30">Net 30</option>
                        <option value="net_60">Net 60</option>
                    </select>
                    <div v-if="errors.payment_terms" class="invalid-feedback">
                        {{ errors.payment_terms[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select
                        v-model="form.status"
                        class="form-select"
                        :class="{ 'is-invalid': errors.status }"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="blocked">Blocked</option>
                    </select>
                    <div v-if="errors.status" class="invalid-feedback">
                        {{ errors.status[0] }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea
                        v-model="form.notes"
                        class="form-control"
                        :class="{ 'is-invalid': errors.notes }"
                        rows="3"
                        placeholder="Internal notes about this customer"
                    ></textarea>
                    <div v-if="errors.notes" class="invalid-feedback">
                        {{ errors.notes[0] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
            <RouterLink to="/customers" class="btn btn-outline-secondary">
                Cancel
            </RouterLink>

            <button
                type="submit"
                class="btn btn-primary"
                :disabled="loading"
            >
                <span
                    v-if="loading"
                    class="spinner-border spinner-border-sm me-1"
                ></span>
                {{ loading ? 'Saving...' : 'Save Customer' }}
            </button>
        </div>
    </form>
</template>

<script setup>
import { reactive, ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const loading = ref(false)
const formError = ref('')
const errors = ref({})

const isEdit = computed(() => !!route.params.id)

const form = reactive({
    name: '',
    type: '',
    email: '',
    phone: '',
    company_name: '',
    tax_number: '',
    billing_address: '',
    shipping_address: '',
    credit_limit: 0,
    payment_terms: 'net_30',
    status: 'active',
    notes: '',
})

const loadCustomer = async () => {
    if (!isEdit.value) return

    loading.value = true

    try {
        const response = await axios.get(`/api/customers/${route.params.id}`)

        Object.assign(form, response.data.data ?? response.data)
    } catch (error) {
        formError.value = 'Unable to load customer.'
    } finally {
        loading.value = false
    }
}

const submitForm = async () => {
    loading.value = true
    formError.value = ''
    errors.value = {}

    try {
        if (isEdit.value) {
            await axios.put(`/api/customers/${route.params.id}`, form)
        } else {
            await axios.post('/api/customers', form)
        }

        router.push('/customers')
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        } else {
            formError.value = 'Unable to save customer.'
        }
    } finally {
        loading.value = false
    }
}

onMounted(loadCustomer)
</script>