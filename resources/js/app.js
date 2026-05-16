import '../css/app.css'
import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

// Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

// Global Vue Components
import DashboardStats from './components/DashboardStats.vue'
import DataTable from './components/DataTable.vue'
import ConfirmDeleteModal from './components/ConfirmDeleteModal.vue'
import ProductSelector from './components/ProductSelector.vue'
import CustomerSelector from './components/CustomerSelector.vue'
import StatusBadge from './components/StatusBadge.vue'
import ToastNotifications from './components/ToastNotifications.vue'

// ERP Page Components
import DashboardWidgets from './pages/dashboard/DashboardWidgets.vue'
import CustomerForm from './pages/customers/CustomerForm.vue'
import ProductForm from './pages/products/ProductForm.vue'
import InventoryMovementForm from './pages/inventory/InventoryMovementForm.vue'
import SalesOrderForm from './pages/sales/SalesOrderForm.vue'
import InvoiceForm from './pages/invoices/InvoiceForm.vue'

const app = createApp({})

app.use(createPinia())

app.component('dashboard-stats', DashboardStats)
app.component('data-table', DataTable)
app.component('confirm-delete-modal', ConfirmDeleteModal)
app.component('product-selector', ProductSelector)
app.component('customer-selector', CustomerSelector)
app.component('status-badge', StatusBadge)
app.component('toast-notifications', ToastNotifications)

app.component('dashboard-widgets', DashboardWidgets)
app.component('customer-form', CustomerForm)
app.component('product-form', ProductForm)
app.component('inventory-movement-form', InventoryMovementForm)
app.component('sales-order-form', SalesOrderForm)
app.component('invoice-form', InvoiceForm)

app.mount('#app')