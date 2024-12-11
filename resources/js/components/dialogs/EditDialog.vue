<template>
    <VDialog
      :model-value="dialogVisible"
      @update:model-value="updateDialogVisible"
      max-width="600px"
    >
      <VCard class="rounded-xl">
        <!-- Title -->
        <VCardTitle class="text-h5 font-weight-bold text-center pt-6">
          <div class="d-flex flex-column align-items-center">
            <span class="text-h4 text-primary">Edit Appointment</span>
            <div
              style="width: 60px; height: 3px; background-color: var(--v-theme-primary); margin-top: 12px; border-radius: 5px;"
            ></div>
          </div>
        </VCardTitle>

        <!-- Form Content -->
        <VCardText>
          <VRow class="py-4">
            <VCol cols="12" sm="6" >
              <VTextField
                v-model="editedItem.firstName"
                label="First Name"
                prepend-inner-icon="bx-user"
                dense
              />
            </VCol>
            <VCol cols="12" sm="6" >
              <VTextField
                v-model="editedItem.lastName"
                label="Last Name"
                prepend-inner-icon="bx-user"
                dense
              />
            </VCol>
            <VCol cols="12" sm="6" >
              <VTextField
                v-model="editedItem.userEmail"
                label="Email"
                prepend-inner-icon="bx-envelope"
                dense
              />
            </VCol>
            <VCol cols="12" sm="6" >
              <VTextField
                v-model="editedItem.phoneNumber"
                label="Phone Number"
                prepend-inner-icon="bx-phone"
                dense
              />
            </VCol>
            <VCol cols="12">
              <VSelect
                v-model="editedItem.selectedPurpose"
                :items="selectedPurposeType"
                item-title="text"
                item-value="value"
                label="Purpose of Visit"
                dense
              />
            </VCol>
          </VRow>
        </VCardText>

        <!-- Actions -->
        <VCardText class="d-flex justify-end gap-4 mt-0">
            <VBtn
              color="error"
              variant="outlined"
              @click="close"
              class="rounded-lg"
            >
              <VIcon icon="bx-x" start />
              Close
            </VBtn>
          <VBtn
            color="success"
            variant="outlined"
            @click="updateItem"
            class="rounded-lg"
          >
            Update
            <VIcon icon="bx-check" end />
          </VBtn>
        </VCardText>
      </VCard>
    </VDialog>
  </template>


  <script setup>
  import { defineProps, defineEmits } from 'vue';
  import { VDialog, VCard, VCardText, VRow, VCol, VTextField, VSelect, VBtn } from 'vuetify/components';

  const props = defineProps({
    dialogVisible: Boolean,
    editedItem: Object,
    selectedPurposeType: Array,
  });

  const emit = defineEmits(['update:item', 'close', 'update:dialogVisible']);

  const updateDialogVisible = (value) => {
    emit('update:dialogVisible', value);
  };

  const close = () => {
    emit('close');
    emit('update:dialogVisible', false);
  };

  const updateItem = () => {
    emit('update:item', props.editedItem); // Emit updated item
    emit('update:dialogVisible', false); // Close the dialog
  };
  </script>
