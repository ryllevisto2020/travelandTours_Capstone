<script setup>
import { ref, reactive, computed } from 'vue';
import { VTextField, VSelect, VDataTable, VChip, VBtn, VIcon, VCard, VCardTitle, VCardText, VDialog, VSnackbar } from 'vuetify/components';
import AddDialog from '@/components/dialogs/AddDialog.vue';
import EditDialog from '@/components/dialogs/EditDialog.vue';
import DeleteDialog from '@/components/dialogs/DeleteDialog.vue';

const handleDeleteItem = (item) => {
itemToDelete.value = { ...item }; // Ensure id is preserved
 deleteDialog.value = true;
};

const deleteItemConfirm = () => {
if (itemToDelete.value) {
const index = userList.value.findIndex(item => item.id === itemToDelete.value.id);
if (index !== -1) {
  userList.value.splice(index, 1); // Remove the specific item
  snackbarMessage.value = 'Appointment deleted successfully!';
  snackbar.value = true;
}
}
deleteDialog.value = false;
};

const handlePreviousStep = () => {
if (activeStep.value > 1) activeStep.value--;
};

const handleNextStep = () => {
if (activeStep.value < 2) activeStep.value++;
};

const editedItem = ref({});
const validationErrors = ref({});
const userList = ref([]);
const search = ref('');
const snackbar = ref(false);
const snackbarMessage = ref('');
const deleteDialog = ref(false);
const itemToDelete = ref(null);
const isAddDialogVisible = ref(false);
const isEditDialogVisible = ref(false);
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

const headers = [
{ title: 'FIRST NAME', key: 'firstName' },
{ title: 'LAST NAME', key: 'lastName' },
{ title: 'EMAIL', key: 'userEmail' },
{ title: 'PHONE NUMBER', key: 'phoneNumber' },
{ title: 'PURPOSE', key: 'selectedPurpose' },
{ title: 'FACILITY', key: 'selectedFacility' },
{ title: 'APPOINTMENT DATE', key: 'selectedDate' },
{ title: 'VERIFICATION ID', key: 'userValidId' },
{ title: 'STATUS', key: 'status' },
{ title: 'ACTIONS', key: 'actions' },
];

const resolveStatusVariant = (status) => ({
color: 'warning',
text: status === 1 ? 'Pending' : 'Pending',
});

const resolvePurposeType = (selectedPurpose) => {
switch (selectedPurpose) {
    case 1:
    return { color: 'warning', text: 'Business' };
    case 2:
    return { color: 'success', text: 'Personal' };
    case 3:
    return { color: 'info', text: 'Other' };
    default:
    return { color: 'grey', text: 'Unknown' };
}
};

const resolveFacilityType = (selectedFacility) => {
switch (selectedFacility) {
    case 1:
    return { color: 'primary', text: 'Meeting Room 1' };
    case 2:
    return { color: 'primary', text: 'Meeting Room 2' };
    case 3:
    return { color: 'primary', text: 'Meeting Room 3' };
    default:
    return { color: 'grey', text: 'Unknown' };
}
};

const handleSaveItem = () => {
const newId = Date.now(); // Generate a unique ID
userList.value.push({
id: newId,
...addedItem.value,
userValidId: addedItem.value.userValidId.map(file => file.name),
});

snackbarMessage.value = 'Appointment added successfully!';
snackbar.value = true;
isAddDialogVisible.value = false;

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
userList.value.splice(index, 1, updatedItem); // Replace the specific item
snackbarMessage.value = 'Appointment updated successfully!';
snackbar.value = true;
}
isEditDialogVisible.value = false;
};

const handleEditItem = (item) => {
editedItem.value = { ...item }; // Ensure id is preserved
isEditDialogVisible.value = true;
};

const handleCloseDialog = () => {
isAddDialogVisible.value = false;
isEditDialogVisible.value = false;
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
        <VBtn color="primary" @click="isAddDialogVisible = true">Appoint Schedule</VBtn>
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
    />
    </VCardText>
</VCard>

<!-- Add Dialog -->
<AddDialog
    :dialogVisible="isAddDialogVisible"
    :addedItem="addedItem"
    :validationErrors="validationErrors"
    :activeStep="activeStep"
    @previous-step="handlePreviousStep"
    @next-step="handleNextStep"
    @save-item="handleSaveItem"
    @close-dialog="handleCloseDialog"
/>

<!-- Edit Dialog -->
<EditDialog
    :dialogVisible="isEditDialogVisible"
    :editedItem="editedItem"
    :selectedPurposeType="[{ text: 'Business', value: 1 }, { text: 'Personal', value: 2 }, { text: 'Other', value: 3 }]"
    @update:item="handleUpdateItem"
    @update:dialogVisible="(value) => isEditDialogVisible = value"
/>

<DeleteDialog
    v-model:dialogVisible="deleteDialog"
    @delete="deleteItemConfirm"
/>

<!-- Snackbar for confirmation -->
<VSnackbar v-model="snackbar" :timeout="3000" centered>{{ snackbarMessage }}</VSnackbar>
</template>
