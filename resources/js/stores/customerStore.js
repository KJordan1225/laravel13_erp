import { defineStore } from 'pinia'

export const useCustomerStore = defineStore('customerStore', {
    state: () => ({
        customers: [],
        selectedCustomer: null,
        loading: false,
        error: null,
    }),

    actions: {
        async searchCustomers(query = '') {
            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/customers/search', {
                    params: { q: query },
                })

                this.customers = response.data.data
            } catch (error) {
                this.error = 'Unable to search customers.'
            } finally {
                this.loading = false
            }
        },

        selectCustomer(customer) {
            this.selectedCustomer = customer
        },

        clearCustomer() {
            this.selectedCustomer = null
        },
    },
})
