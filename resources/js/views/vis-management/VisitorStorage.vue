<!-- eslint-disable camelcase -->
<!-- eslint-disable no-restricted-imports -->
<!-- eslint-disable import/extensions -->
<!-- eslint-disable import/no-unresolved -->
<script setup>
import { ref, reactive, computed } from 'vue'
import {  VBtn, VCard, VCardTitle, VCardText, VSnackbar } from 'vuetify/components'
import { resolveType, purposeTypes, facilityTypes, statusTypes } from '@/utils/resolvers'
import { useSnackbar } from '@/utils/useSnackbar'
import { headers } from '@/utils/headers'
import AddDialog from '@/components/dialogs/AddDialog.vue'
import EditDialog from '@/components/dialogs/EditDialog.vue'
import DeleteDialog from '@/components/dialogs/DeleteDialog.vue'
import AppointmentTable from '@/components/AppointmentTable.vue'
import axios from 'axios'

const { snackbar, snackbarMessage, showSnackbar } = useSnackbar()
const approveItem = item => updateStatus(item, 'approved', 'approved')
const rejectItem = item => updateStatus(item, 'rejected', 'rejected')
const resolvePurposeType = selectedPurpose => resolveType(selectedPurpose, purposeTypes)
const resolveFacilityType = selectedFacility => resolveType(selectedFacility, facilityTypes)
const resolveStatusVariant = status => resolveType(status, statusTypes)
const editedItem = ref({})
const validationErrors = ref({})
const userList = ref([])
const userRetrieveList = ref([])
const search = ref('')
const itemToDelete = ref(null)
const activeStep = ref(1)


const addedItem = ref({
  firstName: '',
  middleName: '',
  lastName: '',
  userEmail: '',
  phoneNumber: '',
  userAge: null,
  userValidId: [],
  userFileName: '',
  status: 'Pending',
  selectedDate: null,
  selectedPurpose: null,
  selectedFacility: null,
  additionalInfo: '',
})

const showDialog = () => {
  dialogs.addDialogVisible = true
}

const dialogs = reactive({
  addDialogVisible: false,
  editDialogVisible: false,
  deleteDialogVisible: false,
})

const updateStatus = (item, newStatus, actionText) => {
  const index = userList.value.findIndex(user => user.id === item.id)
  if (index !== -1) {
    userList.value[index].status = newStatus
    showSnackbar(`${item.firstName} ${item.lastName} has been ${actionText}!`)
  }
}

const handleDeleteItem = item => {
  itemToDelete.value = { ...item }
  dialogs.deleteDialogVisible = true
}

const deleteItemConfirm = () => {
  if (itemToDelete.value) {
    const index = userList.value.findIndex(item => item.id === itemToDelete.value.id)
    if (index !== -1) {
      userList.value.splice(index, 1)
      snackbarMessage.value = 'Appointment deleted successfully!'
      snackbar.value = true
    }
  }
  dialogs.deleteDialogVisible = false
}

const handlePreviousStep = () => {
  if (activeStep.value > 1) activeStep.value--
}

const handleNextStep = () => {
  if (activeStep.value < 2) activeStep.value++
}

const handleSaveItem = () => {
  var csrf_token = document.getElementsByName("csrf-token")[0]["content"]

  const newId = Date.now()

  userList.value.push({
    ...addedItem.value,
  })

  axios.post("/client/appointment/create", { data: userList.value, file: addedItem.value.userValidId[0] },
    {
      headers: {
        "X-CSRF-TOKEN": csrf_token,
        "Content-Type": "multipart/form-data",
      },
    }).then(function(res){
    snackbarMessage.value = 'Appointment added successfully!'
    snackbar.value = true
    dialogs.addDialogVisible = false
    addedItem.value = {
      firstName: '',
      middleName: '',
      lastName: '',
      userEmail: '',
      phoneNumber: '',
      userAge: null,
      userValidId: [],
      userFileName: '',
      status: 'Pending',
      selectedDate: null,
      selectedPurpose: null,
      selectedFacility: null,
      additionalInfo: '',
    }

    activeStep.value = 1
    validationErrors.value = {}
    userList.value=[]
  })
}

const handleUpdateItem = updatedItem => {
  const index = userList.value.findIndex(item => item.id === updatedItem.id)
  if (index !== -1) {
    userList.value.splice(index, 1, updatedItem)
    snackbarMessage.value = 'Appointment updated successfully!'
    snackbar.value = true
  }
  dialogs.editDialogVisible = false
}

const handleEditItem = item => {
  editedItem.value = { ...item }
  dialogs.editDialogVisible = true
}

const handleCloseDialog = () => {
  dialogs.addDialogVisible = false
  dialogs.editDialogVisible = false
  dialogs.deleteDialogVisible = false
}

const filteredList = computed(() => {
  if (!search.value) return userList.value
  const lowerCaseSearch = search.value.toLowerCase()

  return userList.value.filter(item =>
    Object.values(item)
      .join(' ')
      .toLowerCase()
      .includes(lowerCaseSearch),
  )
})
</script>

<template>
  <VCard>
    <VCardItem>
      <VCardTitle class="d-flex justify-space-between align-center">
        <h2>Appointment Schedule</h2>
        <div>
          <VBtn
            color="primary"
            @click="showDialog"
          >
            Appoint Schedule
          </VBtn>
        </div>
      </VCardTitle>
    </VCardItem>

    <VCardText class="pa-0">
      <AppointmentTable
        :user-list="userRetrieveList"
        :headers="headers"
        :handle-edit-item="handleEditItem"
        :handle-delete-item="handleDeleteItem"
        :resolve-purpose-type="resolvePurposeType"
        :resolve-facility-type="resolveFacilityType"
        :resolve-status-variant="resolveStatusVariant"
        :approve-item="approveItem"
        :reject-item="rejectItem"
      />
    </VCardText>
  </VCard>

  <AddDialog
    :dialog-visible="dialogs.addDialogVisible"
    :added-item="addedItem"
    :validation-errors="validationErrors"
    :active-step="activeStep"
    @previous-step="handlePreviousStep"
    @next-step="handleNextStep"
    @save-item="handleSaveItem"
    @close-dialog="handleCloseDialog"
  />

  <EditDialog
    :dialog-visible="dialogs.editDialogVisible"
    :edited-item="editedItem"
    :selected-purpose-type="[{ text: 'Business', value: 1 }, { text: 'Personal', value: 2 }, { text: 'Other', value: 3 }]"
    @update:item="handleUpdateItem"
    @update:dialog-visible="(value) => dialogs.editDialogVisible = value"
  />

  <DeleteDialog
    v-model:dialogVisible="dialogs.deleteDialogVisible"
    @delete="deleteItemConfirm"
  />

  <VSnackbar
    v-model="snackbar"
    :timeout="3000"
    centered
  >
    {{ snackbarMessage }}
  </VSnackbar>
</template>
