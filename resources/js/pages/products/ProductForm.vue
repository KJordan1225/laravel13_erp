<template>
    <form @submit.prevent="submitForm" class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-bold">
                {{ isEdit ? 'Edit Product' : 'Create Product' }}
            </h5>
        </div>

        <div class="card-body">
            <div v-if="formError" class="alert alert-danger">
                {{ formError }}
            </div>

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Product Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.name }"
                        placeholder="Wireless Barcode Scanner"
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">SKU</label>
                    <input
                        v-model="form.sku"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.sku }"
                        placeholder="SKU-1001"
                    />
                    <div v-if="errors.sku" class="invalid-feedback">
                        {{ errors.sku[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select
                        v-model="form.category_id"
                        class="form-select"
                        :class="{ 'is-invalid': errors.category_id }"
                    >
                        <option value="">Select category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <div v-if="errors.category_id" class="invalid-feedback">
                        {{ errors.category_id[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Vendor</label>
                    <select
                        v-model="form.vendor_id"
                        class="form-select"
                        :class="{ 'is-invalid': errors.vendor_id }"
                    >
                        <option value="">Select vendor</option>
                        <option
                            v-for="vendor in vendors"
                            :key="vendor.id"
                            :value="vendor.id"
                        >
                            {{ vendor.name }}
                        </option>
                    </select>
                    <div v-if="errors.vendor_id" class="invalid-feedback">
                        {{ errors.vendor_id[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cost Price</label>
                    <input
                        v-model.number="form.cost_price"
                        type="number"
                        min="0"
                        step="0.01"
                        class="form-control"
                        :class="{ 'is-invalid': errors.cost_price }"
                    />
                    <div v-if="errors.cost_price" class="invalid-feedback">
                        {{ errors.cost_price[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Selling Price</label>
                    <input
                        v-model.number="form.selling_price"
                        type="number"
                        min="0"
                        step="0.01"
                        class="form-control"
                        :class="{ 'is-invalid': errors.selling_price }"
                    />
                    <div v-if="errors.selling_price" class="invalid-feedback">
                        {{ errors.selling_price[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tax Rate (%)</label>
                    <input
                        v-model.number="form.tax_rate"
                        type="number"
                        min="0"
                        step="0.01"
                        class="form-control"
                        :class="{ 'is-invalid': errors.tax_rate }"
                    />
                    <div v-if="errors.tax_rate" class="invalid-feedback">
                        {{ errors.tax_rate[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Opening Stock</label>
                    <input
                        v-model.number="form.stock_quantity"
                        type="number"
                        min="0"
                        class="form-control"
                        :class="{ 'is-invalid': errors.stock_quantity }"
                    />
                    <div v-if="errors.stock_quantity" class="invalid-feedback">
                        {{ errors.stock_quantity[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Reorder Level</label>
                    <input
                        v-model.number="form.reorder_level"
                        type="number"
                        min="0"
                        class="form-control"
                        :class="{ 'is-invalid': errors.reorder_level }"
                    />
                    <div v-if="errors.reorder_level" class="invalid-feedback">
                        {{ errors.reorder_level[0] }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Unit</label>
                    <select
                        v-model="form.unit"
                        class="form-select"
                        :class="{ 'is-invalid': errors.unit }"
                    >
                        <option value="">Select unit</option>
                        <option value="pcs">Pieces</option>
                        <option value="box">Box</option>
                        <option value="case">Case</option>
                        <option value="kg">Kilogram</option>
                        <option value="lb">Pound</option>
                        <option value="liter">Liter</option>
                    </select>
                    <div v-if="errors.unit" class="invalid-feedback">
                        {{ errors.unit[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Barcode</label>
                    <input
                        v-model="form.barcode"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': errors.barcode }"
                        placeholder="0123456789012"
                    />
                    <div v-if="errors.barcode" class="invalid-feedback">
                        {{ errors.barcode[0] }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select
                        v-model="form.status"
                        class="form-select"
                        :class="{ 'is-invalid': errors.status }"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="discontinued">Discontinued</option>
                    </select>
                    <div v-if="errors.status" class="invalid-feedback">
                        {{ errors.status[0] }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea
                        v-model="form.description"
                        class="form-control"
                        :class="{ 'is-invalid': errors.description }"
                        rows="3"
                        placeholder="Product description"
                    ></textarea>
                    <div v-if="errors.description" class="invalid-feedback">
                        {{ errors.description[0] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
            <RouterLink to="/products" class="btn btn-outline-secondary">
                Cancel
            </RouterLink>

            <button type="submit" class="btn btn-primary" :disabled="loading">
                <span
                    v-if="loading"
                    class="spinner-border spinner-border-sm me-1"
                ></span>
                {{ loading ? 'Saving...' : 'Save Product' }}
            </button>
        </div>
    </form>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const loading = ref(false)
const formError = ref('')
const errors = ref({})

const categories = ref([])
const vendors = ref([])

const isEdit = computed(() => !!route.params.id)

const form = reactive({
    name: '',
    sku: '',
    category_id: '',
    vendor_id: '',
    cost_price: 0,
    selling_price: 0,
    tax_rate: 0,
    stock_quantity: 0,
    reorder_level: 5,
    unit: 'pcs',
    barcode: '',
    status: 'active',
    description: '',
})

const loadDropdownData = async () => {
    try {
        const [categoryResponse, vendorResponse] = await Promise.all([
            axios.get('/api/categories'),
            axios.get('/api/vendors'),
        ])

        categories.value = categoryResponse.data.data ?? categoryResponse.data
        vendors.value = vendorResponse.data.data ?? vendorResponse.data
    } catch (error) {
        formError.value = 'Unable to load category or vendor data.'
    }
}

const loadProduct = async () => {
    if (!isEdit.value) return

    loading.value = true

    try {
        const response = await axios.get(`/api/products/${route.params.id}`)
        Object.assign(form, response.data.data ?? response.data)
    } catch (error) {
        formError.value = 'Unable to load product.'
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
            await axios.put(`/api/products/${route.params.id}`, form)
        } else {
            await axios.post('/api/products', form)
        }

        router.push('/products')
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        } else {
            formError.value = 'Unable to save product.'
        }
    } finally {
        loading.value = false
    }
}

onMounted(async () => {
    await loadDropdownData()
    await loadProduct()
})
</script>