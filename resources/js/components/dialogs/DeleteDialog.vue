<template>
  <VDialog v-model="localDialogVisible" max-width="500px">
    <VCard title="Confirm Delete">
      <VCardText>Are you sure you want to delete this item?</VCardText>
      <VCardActions class="self-align-end d-flex gap-3 justify-end">
        <VBtn text variant="outlined" @click="closeDialog"> <VIcon icon="bx-x" start />Cancel</VBtn>
        <VBtn color="error" variant="outlined" @click="confirmDelete">
            Delete <VIcon icon="bx-trash" end /></VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<script setup>
import { ref, watch } from 'vue';

// Props for dialog visibility
const props = defineProps({
  dialogVisible: {
    type: Boolean,
    required: true,
  },
});

// Emit events to parent component
const emit = defineEmits(['update:dialogVisible', 'delete']);

// Local state for dialog visibility
const localDialogVisible = ref(props.dialogVisible);

// Watch for changes to dialogVisible prop and update local state
watch(() => props.dialogVisible, (newValue) => {
  localDialogVisible.value = newValue;
});

// Emit the update when the dialog visibility changes
const closeDialog = () => {
  emit('update:dialogVisible', false);
};

const confirmDelete = () => {
  emit('delete');
  closeDialog();
};
</script>
