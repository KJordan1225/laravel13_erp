import { defineStore } from 'pinia'

export const useInventoryStore = defineStore('inventoryStore', {
    state: () => ({
        product: null,
        warehouses: [],
        warehouseId: '',
        type: 'stock_in',
        quantity: 1,
        notes: '',
        loading: false,
        error: null,
    }),

    actions: {
        setProduct(product) {
            this.product = product
        },

        async fetchWarehouses() {
            try {
                const response = await axios.get('/api/warehouses/search')
                this.warehouses = response.data.data
            } catch {
                this.error = 'Unable to load warehouses.'
            }
        },

        reset() {
            this.product = null
            this.warehouseId = ''
            this.type = 'stock_in'
            this.quantity = 1
            this.notes = ''
            this.loading = false
            this.error = null
        },

        async submit() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.post('/api/inventory-movements', {
                    product_id: this.product?.id,
                    warehouse_id: this.warehouseId || null,
                    type: this.type,
                    quantity: this.quantity,
                    notes: this.notes,
                })

                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || 'Unable to save inventory movement.'
                throw error
            } finally {
                this.loading = false
            }
        },
    },
})
