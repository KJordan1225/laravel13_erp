import { defineStore } from 'pinia'

export const useProductStore = defineStore('productStore', {
    state: () => ({
        products: [],
        selectedProduct: null,
        loading: false,
        error: null,
    }),

    actions: {
        async searchProducts(query = '') {
            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/products/search', {
                    params: { q: query },
                })

                this.products = response.data.data
            } catch (error) {
                this.error = 'Unable to search products.'
            } finally {
                this.loading = false
            }
        },

        selectProduct(product) {
            this.selectedProduct = product
        },

        clearProduct() {
            this.selectedProduct = null
        },
    },
})
