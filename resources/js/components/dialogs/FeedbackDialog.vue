<template>
    <VDialog v-model="localDialogVisible" max-width="500px">
      <VCard title="User Feedback">
        <VCardText>
          <div class="text-center">
            <p>Please rate your experience:</p>
            <VRating v-model="rating" density="compact" />
          </div>
        </VCardText>
        <VCardActions class="self-align-end d-flex gap-3 justify-end">
          <VBtn text variant="outlined" @click="closeDialog">
            <VIcon icon="bx-x" start />Cancel
          </VBtn>
          <VBtn color="success" variant="outlined" @click="submitFeedback">
            Submit <VIcon icon="bx-check" end />
          </VBtn>
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
  const emit = defineEmits(['update:dialogVisible', 'submitFeedback']);

  // Local state for dialog visibility and feedback rating
  const localDialogVisible = ref(props.dialogVisible);
  const rating = ref(0); // Local state for the selected rating

  // Watch for changes to dialogVisible prop and update local state
  watch(
    () => props.dialogVisible,
    (newValue) => {
      localDialogVisible.value = newValue;
      if (!newValue) resetDialog(); // Reset when dialog is closed
    }
  );

  // Watch for changes to localDialogVisible and sync with parent
  watch(localDialogVisible, (newValue) => {
    emit('update:dialogVisible', newValue);
  });

  // Close the dialog and reset state
  const closeDialog = () => {
    localDialogVisible.value = false;
  };

  // Submit feedback and emit the rating to the parent component
  const submitFeedback = () => {
    emit('submitFeedback', rating.value);
    closeDialog(); // Close dialog after submission
  };

  // Reset the dialog's state
  const resetDialog = () => {
    rating.value = 0; // Reset the rating value
  };
  </script>
