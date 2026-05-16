import '../css/app.css';
import './bootstrap';

import DashboardStats from './components/DashboardStats.vue'
import DataTable from './components/DataTable.vue'
import ConfirmDeleteModal from './components/ConfirmDeleteModal.vue'
import ProductSelector from './components/ProductSelector.vue'
import CustomerSelector from './components/CustomerSelector.vue'
import StatusBadge from './components/StatusBadge.vue'
import ToastNotifications from './components/ToastNotifications.vue'

// import DashboardWidgets from './pages/dashboard/DashboardWidgets.vue'
// import CustomerForm from './pages/customers/CustomerForm.vue'
// import ProductForm from './pages/products/ProductForm.vue'
import InventoryMovementForm from './pages/inventory/InventoryMovementForm.vue'
import SalesOrderForm from './pages/sales/SalesOrderForm.vue'
import InvoiceForm from './pages/invoices/InvoiceForm.vue'

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

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


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
