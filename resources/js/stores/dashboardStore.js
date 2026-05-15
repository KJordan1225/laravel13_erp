import { defineStore } from 'pinia'

export const useDashboardStore = defineStore('dashboardStore', {
    state: () => ({
        stats: {},
        recentOrders: [],
        recentPayments: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchStats() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/dashboard/stats')
                this.stats = response.data.stats
                this.recentOrders = response.data.recentOrders
                this.recentPayments = response.data.recentPayments
            } catch (error) {
                this.error = 'Unable to load dashboard statistics.'
            } finally {
                this.loading = false
            }
        },
    },
})
