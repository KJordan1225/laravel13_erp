<template>
    <div class="card erp-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ title }}</span>

            <input
                v-model="search"
                type="text"
                class="form-control form-control-sm w-auto"
                placeholder="Search..."
            >
        </div>

        <div class="card-body p-0">
            <div v-if="loading" class="p-4 text-center text-muted">
                Loading records...
            </div>

            <div v-else-if="filteredRows.length === 0" class="p-4 text-center text-muted">
                No records found.
            </div>

            <div v-else class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th
                                v-for="column in columns"
                                :key="column.key"
                                role="button"
                                @click="sortBy(column.key)"
                            >
                                {{ column.label }}

                                <span v-if="sortColumn === column.key">
                                    {{ sortDirection === 'asc' ? '▲' : '▼' }}
                                </span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="row in filteredRows" :key="row.id">
                            <td v-for="column in columns" :key="column.key">
                                {{ row[column.key] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer small text-muted">
            Showing {{ filteredRows.length }} record(s)
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Data Table',
    },
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
})

const search = ref('')
const sortColumn = ref(null)
const sortDirection = ref('asc')

const filteredRows = computed(() => {
    let data = [...props.rows]

    if (search.value) {
        const term = search.value.toLowerCase()

        data = data.filter(row => {
            return Object.values(row).some(value => {
                return String(value ?? '').toLowerCase().includes(term)
            })
        })
    }

    if (sortColumn.value) {
        data.sort((a, b) => {
            const left = a[sortColumn.value]
            const right = b[sortColumn.value]

            if (left === right) {
                return 0
            }

            if (sortDirection.value === 'asc') {
                return left > right ? 1 : -1
            }

            return left < right ? 1 : -1
        })
    }

    return data
})

function sortBy(column) {
    if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortColumn.value = column
        sortDirection.value = 'asc'
    }
}
</script>
