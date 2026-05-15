<template>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div
            v-for="message in store.messages"
            :key="message.id"
            class="toast show"
            role="alert"
        >
            <div :class="['toast-header', `text-bg-${message.type}`]">
                <strong class="me-auto">ERP Notification</strong>
                <button
                    type="button"
                    class="btn-close"
                    @click="store.remove(message.id)"
                ></button>
            </div>

            <div class="toast-body">
                {{ message.message }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { useNotificationStore } from '../stores/notificationStore'

const store = useNotificationStore()
</script>
