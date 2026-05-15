<template>
    <span :class="badgeClass">
        {{ normalizedStatus }}
    </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: {
        type: String,
        default: 'unknown',
    },
})

const normalizedStatus = computed(() => {
    return props.status.charAt(0).toUpperCase() + props.status.slice(1)
})

const badgeClass = computed(() => {
    const classes = {
        active: 'badge bg-success',
        paid: 'badge bg-success',
        completed: 'badge bg-success',
        approved: 'badge bg-success',
        pending: 'badge bg-warning text-dark',
        draft: 'badge bg-secondary',
        sent: 'badge bg-primary',
        inactive: 'badge bg-danger',
        cancelled: 'badge bg-danger',
        overdue: 'badge bg-danger',
        terminated: 'badge bg-danger',
    }

    return classes[props.status] ?? 'badge bg-secondary'
})
</script>
