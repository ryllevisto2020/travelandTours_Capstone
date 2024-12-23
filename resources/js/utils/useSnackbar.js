// composables/useSnackbar.js
import { ref } from 'vue';

export function useSnackbar() {
  const snackbar = ref(false);
  const snackbarMessage = ref('');

  const showSnackbar = (message) => {
    snackbarMessage.value = message;
    snackbar.value = true;
  };

  return { snackbar, snackbarMessage, showSnackbar };
}
