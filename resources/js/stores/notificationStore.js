import { defineStore } from 'pinia'

export const useNotificationStore = defineStore('notificationStore', {
    state: () => ({
        messages: [],
    }),

    actions: {
        success(message) {
            this.add(message, 'success')
        },

        error(message) {
            this.add(message, 'danger')
        },

        info(message) {
            this.add(message, 'info')
        },

        add(message, type = 'info') {
            const id = Date.now()

            this.messages.push({
                id,
                message,
                type,
            })

            setTimeout(() => {
                this.remove(id)
            }, 4000)
        },

        remove(id) {
            this.messages = this.messages.filter(message => message.id !== id)
        },
    },
})
