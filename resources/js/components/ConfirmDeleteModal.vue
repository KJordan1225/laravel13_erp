<template>
    <div
        class="modal fade"
        :id="modalId"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        Confirm Delete
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>

                <div class="modal-body">
                    <p class="mb-0">
                        Are you sure you want to delete this record?
                    </p>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="$emit('confirm')"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    modalId: {
        type: String,
        default: 'confirmDeleteModal',
    },
})

defineEmits(['confirm'])
</script>
