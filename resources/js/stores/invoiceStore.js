import { defineStore } from 'pinia'

export const useInvoiceStore = defineStore('invoiceStore', {
    state: () => ({
        customer: null,
        invoiceDate: new Date().toISOString().slice(0, 10),
        dueDate: '',
        status: 'draft',
        notes: '',
        taxRate: 0,
        discountAmount: 0,
        amountPaid: 0,
        items: [],
        loading: false,
        error: null,
    }),

    getters: {
        subtotal(state) {
            return state.items.reduce((total, item) => {
                return total + Number(item.line_total || 0)
            }, 0)
        },

        taxAmount() {
            return this.subtotal * (Number(this.taxRate || 0) / 100)
        },

        total() {
            return this.subtotal + this.taxAmount - Number(this.discountAmount || 0)
        },

        balanceDue() {
            return this.total - Number(this.amountPaid || 0)
        },
    },

    actions: {
        setCustomer(customer) {
            this.customer = customer
        },

        addProduct(product) {
            const existing = this.items.find(item => item.product_id === product.id)

            if (existing) {
                existing.quantity += 1
                existing.line_total = existing.quantity * existing.unit_price
                return
            }

            this.items.push({
                product_id: product.id,
                description: product.name,
                sku: product.sku,
                quantity: 1,
                unit_price: Number(product.price || 0),
                line_total: Number(product.price || 0),
            })
        },

        addManualLine() {
            this.items.push({
                product_id: null,
                description: '',
                sku: '',
                quantity: 1,
                unit_price: 0,
                line_total: 0,
            })
        },

        updateItem(index) {
            const item = this.items[index]

            if (!item) return

            item.quantity = Number(item.quantity || 1)
            item.unit_price = Number(item.unit_price || 0)
            item.line_total = item.quantity * item.unit_price
        },

        removeItem(index) {
            this.items.splice(index, 1)
        },

        reset() {
            this.customer = null
            this.invoiceDate = new Date().toISOString().slice(0, 10)
            this.dueDate = ''
            this.status = 'draft'
            this.notes = ''
            this.taxRate = 0
            this.discountAmount = 0
            this.amountPaid = 0
            this.items = []
            this.loading = false
            this.error = null
        },

        async submit() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.post('/api/invoices', {
                    customer_id: this.customer?.id,
                    invoice_date: this.invoiceDate,
                    due_date: this.dueDate,
                    status: this.status,
                    notes: this.notes,
                    tax_rate: this.taxRate,
                    discount_amount: this.discountAmount,
                    amount_paid: this.amountPaid,
                    items: this.items,
                })

                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || 'Unable to save invoice.'
                throw error
            } finally {
                this.loading = false
            }
        },
    },
})
