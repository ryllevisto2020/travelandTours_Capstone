<script setup>
import { ref, reactive, computed } from 'vue';
import {  VBtn, VCard, VCardTitle, VCardText, VSnackbar } from 'vuetify/components';
import { resolveType, purposeTypes, facilityTypes, statusTypes } from '@/utils/resolvers';
import { useSnackbar } from '@/utils/useSnackbar';
import { headers } from '@/utils/headers';
import AddDialog from '@/components/dialogs/AddDialog.vue';
import EditDialog from '@/components/dialogs/EditDialog.vue';
import DeleteDialog from '@/components/dialogs/DeleteDialog.vue';
import AppointmentTable from '@/components/AppointmentTable.vue';

const { snackbar, snackbarMessage, showSnackbar } = useSnackbar();
const approveItem = (item) => updateStatus(item, 'approved', 'approved');
const rejectItem = (item) => updateStatus(item, 'rejected', 'rejected');
const resolvePurposeType = (selectedPurpose) => resolveType(selectedPurpose, purposeTypes);
const resolveFacilityType = (selectedFacility) => resolveType(selectedFacility, facilityTypes);
const resolveStatusVariant = (status) => resolveType(status, statusTypes);
const editedItem = ref({});
const validationErrors = ref({});
const userList = ref([]);
const search = ref('');
const itemToDelete = ref(null);
const activeStep = ref(1);
const addedItem = ref({
  firstName: '',
  middleName: '',
  lastName: '',
  userEmail: '',
  phoneNumber: '',
  userAge: null,
  userValidId: [],
  status: 'Pending',
  selectedDate: null,
  selectedPurpose: null,
  selectedFacility: null,
  additionalInfo: '',
});

const dialogs = reactive({
  addDialogVisible: false,
  editDialogVisible: false,
  deleteDialogVisible: false,
});

const updateStatus = (item, newStatus, actionText) => {
  const index = userList.value.findIndex((user) => user.id === item.id);
  if (index !== -1) {
    userList.value[index].status = newStatus;
    showSnackbar(`${item.firstName} ${item.lastName} has been ${actionText}!`);
  }
};

const handleDeleteItem = (item) => {
  itemToDelete.value = { ...item };
  dialogs.deleteDialogVisible = true;
};

const deleteItemConfirm = () => {
  if (itemToDelete.value) {
    const index = userList.value.findIndex(item => item.id === itemToDelete.value.id);
    if (index !== -1) {
      userList.value.splice(index, 1);
      snackbarMessage.value = 'Appointment deleted successfully!';
      snackbar.value = true;
    }
  }
  dialogs.deleteDialogVisible = false;
};

const handlePreviousStep = () => {
  if (activeStep.value > 1) activeStep.value--;
};

const handleNextStep = () => {
  if (activeStep.value < 2) activeStep.value++;
};

const handleSaveItem = () => {
  const newId = Date.now();
  userList.value.push({
    id: newId,
    ...addedItem.value,
    userValidId: addedItem.value.userValidId.map(file => file.name),
  });

  snackbarMessage.value = 'Appointment added successfully!';
  snackbar.value = true;
  dialogs.addDialogVisible = false;
  addedItem.value = {
    firstName: '',
    middleName: '',
    lastName: '',
    userEmail: '',
    phoneNumber: '',
    userAge: null,
    userValidId: [],
    status: 'Pending',
    selectedDate: null,
    selectedPurpose: null,
    selectedFacility: null,
    additionalInfo: '',
  };

  activeStep.value = 1;
  validationErrors.value = {};
};

const handleUpdateItem = (updatedItem) => {
  const index = userList.value.findIndex((item) => item.id === updatedItem.id);
  if (index !== -1) {
    userList.value.splice(index, 1, updatedItem);
    snackbarMessage.value = 'Appointment updated successfully!';
    snackbar.value = true;
  }
  dialogs.editDialogVisible = false;
};

const handleEditItem = (item) => {
  editedItem.value = { ...item };
  dialogs.editDialogVisible = true;
};

const handleCloseDialog = () => {
  dialogs.addDialogVisible = false;
  dialogs.editDialogVisible = false;
  dialogs.deleteDialogVisible = false;
};

const filteredList = computed(() => {
  if (!search.value) return userList.value;
  const lowerCaseSearch = search.value.toLowerCase();
  return userList.value.filter((item) =>
    Object.values(item)
    .join(' ')
    .toLowerCase()
    .includes(lowerCaseSearch)
  );
});
</script>

<template>
    <VCard>
      <VCardItem>
        <VCardTitle class="d-flex justify-space-between align-center">
          <h2>Appointment Schedule</h2>
          <div>
            <VBtn color="primary" @click="dialogs.addDialogVisible = true">Appoint Schedule</VBtn>
          </div>
        </VCardTitle>
      </VCardItem>

      <VCardText class="pa-0">
        <AppointmentTable
          :userList="userList"
          :headers="headers"
          :handleEditItem="handleEditItem"
          :handleDeleteItem="handleDeleteItem"
          :resolvePurposeType="resolvePurposeType"
          :resolveFacilityType="resolveFacilityType"
          :resolveStatusVariant="resolveStatusVariant"
          :approveItem="approveItem"
          :rejectItem="rejectItem"
        />
      </VCardText>
    </VCard>

    <AddDialog
      :dialogVisible="dialogs.addDialogVisible"
      :addedItem="addedItem"
      :validationErrors="validationErrors"
      :activeStep="activeStep"
      @previous-step="handlePreviousStep"
      @next-step="handleNextStep"
      @save-item="handleSaveItem"
      @close-dialog="handleCloseDialog"
    />

    <EditDialog
      :dialogVisible="dialogs.editDialogVisible"
      :editedItem="editedItem"
      :selectedPurposeType="[{ text: 'Business', value: 1 }, { text: 'Personal', value: 2 }, { text: 'Other', value: 3 }]"
      @update:item="handleUpdateItem"
      @update:dialogVisible="(value) => dialogs.editDialogVisible = value"
    />

    <DeleteDialog
      v-model:dialogVisible="dialogs.deleteDialogVisible"
      @delete="deleteItemConfirm"
    />

    <VSnackbar v-model="snackbar" :timeout="3000" centered>{{ snackbarMessage }}</VSnackbar>
  </template>
