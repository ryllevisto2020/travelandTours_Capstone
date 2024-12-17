<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import FeedbackDialog from "@/components/dialogs/FeedbackDialog.vue";

const snackbar = ref(false);
const snackbarMessage = ref('');
const isDialogVisible = ref(false);
const csrf_token = document.getElementsByName("csrf-token");
const router = useRouter();

const openDialog = () => {
  isDialogVisible.value = true;
};

const openFeedbackDialog = (event) => {
  event.stopPropagation();
  openDialog();
};

const handleFeedbackSubmit = (rating) => {
  snackbarMessage.value = 'Thanks for the Feedback.';
  snackbar.value = true;
  console.log('User feedback submitted with rating:', rating);
};

const test = async () => {
  try {
    await axios.post("/admin/logout", {
      headers: {
        'X-CSRF-TOKEN': csrf_token[0].content,
      },
    });
    router.push("/login");
  } catch (error) {
    snackbarMessage.value = 'Failed to logout. Please try again.';
    snackbar.value = true;
    console.error('Logout error:', error);
  }
};
</script>

<template>
  <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="avatar1" />

      <!-- Menu -->
      <VMenu activator="parent" width="230" location="bottom end" offset="14px" close-on-content-click="false">
        <VList>
          <!-- User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success">
                  <VAvatar color="primary" variant="tonal">
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>
            <VListItemTitle class="font-weight-semibold">John Doe</VListItemTitle>
            <VListItemSubtitle>Customer Account</VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- Settings -->
          <VListItem link to="/account-settings">
            <template #prepend>
              <VIcon class="me-2" icon="bx-cog" size="22" />
            </template>
            <VListItemTitle>Settings</VListItemTitle>
          </VListItem>

          <!-- User Feedback -->
          <VListItem link @click="openFeedbackDialog">
            <template #prepend>
              <VIcon class="me-2" icon="bx-user" size="22" />
            </template>
            <VListItemTitle>User Feedback</VListItemTitle>
          </VListItem>

          <!-- Feedback Dialog -->
          <FeedbackDialog
          :dialogVisible="isDialogVisible"
          @update:dialogVisible="isDialogVisible = $event"
          @submitFeedback="handleFeedbackSubmit" />

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- Logout -->
          <VListItem link @click="test">
            <template #prepend>
              <VIcon class="me-2" icon="bx-log-out" size="22" />
            </template>
            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
    </VAvatar>
  </VBadge>

  <VSnackbar v-model="snackbar" :timeout="3000" centered>
    {{ snackbarMessage }}
    <template #action>
      <VBtn text @click="snackbar = false">Close</VBtn>
    </template>
  </VSnackbar>
</template>
