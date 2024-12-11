<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { VTextField } from 'vuetify/components';
import { VSelect } from 'vuetify/components/VSelect';
import axios from 'axios';

const editDialog = ref(false)
const deleteDialog = ref(false)
const addDialog = ref(false);
const snackbar = ref(false);
const snackbarMessage = ref('');

const defaultItem = reactive({
  responsiveId: '',
  id: -1,
  facilityName: '',
  facilityType: '',
  facilityCapacity: '',
  status: -1,
})

const editedItem = reactive({ ...defaultItem }) // Use reactive instead of ref
const editedIndex = ref(-1)
const userList = ref([])

// Status options
const selectedOptions = [
  { text: 'Available', value: 1 },
  { text: 'Booked', value: 2 },
  { text: 'Under Maintenance', value: 3 },
]

// Facility Type Options
const selectedFacilityType = [
  { text: 'Conference Room', value: 1 },
  { text: 'Meeting Room', value: 2 },
  { text: 'Hub', value: 3 },
]

// Headers
const headers = [
  { title: 'FACILITY NAME', key: 'facilityName' },
  { title: 'FACILITY TYPE', key: 'facilityType' },
  { title: 'CAPACITY', key: 'facilityCapacity' },
  { title: 'STATUS', key: 'status' },
  { title: 'ACTIONS', key: 'actions' },
]

const resolveStatusVariant = status => {
  switch (status) {
    case 1: return { color: 'success', text: 'Available' }
    case 2: return { color: 'error', text: 'Booked' }
    case 3: return { color: 'warning', text: 'Under Maintenance' }

  }
}

const resolveFacilityType = facilityType => {
  switch (facilityType) {
    case 1: return { color: 'primary', text: 'Conference Room' }
    case 2: return { color: 'primary', text: 'Meeting Room' }
    case 3: return { color: 'primary', text: 'Hub' }

  }
}

// Edit item function
const editItem = item => {
  editedIndex.value = userList.value.indexOf(item)
  Object.assign(editedItem, { ...item })  // Manually assign properties
  editDialog.value = true
}

// Add item function
const openAddDialog  = () => {
  Object.assign(editedItem, { ...defaultItem })  // Reset editedItem to default
  editedIndex.value = -1  // Indicate that this is a new item
  addDialog.value = true
}

// Delete item function
const deleteItem = item => {
  editedIndex.value = userList.value.indexOf(item)
  Object.assign(editedItem, { ...item })  // Manually assign properties
  deleteDialog.value = true
}

// Close dialog and reset form
const close = () => {
  addDialog.value = false
  editDialog.value = false
  editedIndex.value = -1
  Object.assign(editedItem, { ...defaultItem })  // Reset editedItem
}

// Close delete dialog and reset form
const closeDelete = () => {
  deleteDialog.value = false
  editedIndex.value = -1
  Object.assign(editedItem, { ...defaultItem })  // Reset editedItem
}

// Save or update item
// Save or update item
const save = () => {
  if (editedIndex.value > -1) {
    // Edit existing item
    Object.assign(userList.value[editedIndex.value], editedItem)
    snackbarMessage.value = `Item updated successfully!`;
  } else {
    // Add new item
    userList.value.push({ ...editedItem })
    snackbarMessage.value = `New facility added successfully!`;
  }
  snackbar.value = true;
  close()
}

// Delete item confirmation
const deleteItemConfirm = () => {
  userList.value.splice(editedIndex.value, 1)
  closeDelete()
}

// Initialize data on mount
onMounted(() => {
  userList.value = JSON.parse(JSON.stringify(data))
})

// Search bar functionality
const search = ref('')

// Computed property to filter the list based on the search
const filteredList = computed(() => {
  if (!search.value) {
    return userList.value
  }
  const lowerCaseSearch = search.value.toLowerCase();
  return userList.value.filter(item => 
    item.facilityName.toLowerCase().includes(lowerCaseSearch) ||
    resolveFacilityType(item.facilityType).text.toLowerCase().includes(lowerCaseSearch) ||
    resolveStatusVariant(item.status).text.toLowerCase().includes(lowerCaseSearch)
  )
})

const navigationTab = ref('Facility');
const tabItems = ['Facility']; // Only the Facility tab

const selectedFilesMap = ref({
  Facility: [],
});

</script>

<template>
  <VRow>
    <VCol md="12" cols="12">
      <VCard>
        <!-- Tabs Navigation -->
        <VTabs v-model="navigationTab">
          <VTab v-for="item in tabItems" :key="item" :value="item">{{ item }}</VTab>
        </VTabs>

        <VDivider />

        <!-- Tabs Content -->
        <VWindow v-model="navigationTab">
          <VWindowItem v-for="item in tabItems" :key="item" :value="item">
            <VCardItem>
              <VCardTitle class="d-flex justify-space-between align-center">
                <span>{{ item }} Details</span>
                <div class="button-group">
                  <VBtn color="primary" @click="openAddDialog(item)">Add Facility</VBtn>

                </div>
              </VCardTitle>
            </VCardItem>

            <VCardText>
              <VTextField
                v-model="search"
                :label="`Search for ${item} Files`"
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                hide-details
                single-line
                class="mx-auto"
                style="max-width: 100%"
              />

              <!-- Datatable -->
              <VDataTable :headers="headers" :items="filteredList" :items-per-page="10" >
    <template #item.facilityName="{ item }">
      <div class="d-flex align-center">
        <div class="d-flex flex-column ms-3">
          <span>{{ item.facilityName }}</span>
        </div>
      </div>
    </template>

        <!-- Facility Type -->
        <template #item.facilityType="{ item }">
      <VChip :color="resolveFacilityType(item.facilityType).color" size="small">
        {{ resolveFacilityType(item.facilityType).text }}
      </VChip>
    </template>

    <!-- Status -->
    <template #item.status="{ item }">
      <VChip :color="resolveStatusVariant(item.status).color" size="small">
        {{ resolveStatusVariant(item.status).text }}
      </VChip>
    </template>

    <!-- Actions -->
     
    <template #item.actions="{ item }">
    <VBtn
      icon
      variant="text"
      color="primary"
      @click="editItem(item)"
    >
      <VIcon icon="bx-edit" />
    </VBtn>
    <VBtn
      icon
      variant="text"
      color="error"
      @click="deleteItem(item)"
    >
      <VIcon icon="bx-trash" />
    </VBtn>
</template>

  </VDataTable>

  <!-- Edit Dialog -->
  <VDialog v-model="editDialog" max-width="600px">
    <VCard title="Update Facility">
      <VCardText>
        <VRow>
          <VCol cols="12">
            <VTextField v-model="editedItem.facilityName" label="Facility Name"/>
          </VCol>
          <VCol cols="12">
          <VSelect v-model="editedItem.facilityType" :items="selectedFacilityType" item-title="text" item-value="value" label="Facility Type"/>
        </VCol>
          <VCol cols="12">
            <VTextField v-model="editedItem.facilityCapacity" label="Facility Capacity" type="number" />
          </VCol>
          <VCol cols="12">
            <VSelect v-model="editedItem.status" :items="selectedOptions" item-title="text" item-value="value" label="Status" />
          </VCol>
        </VRow>
      </VCardText>
      <VCardText class="self-align-end d-flex gap-4 justify-end">
        <VBtn text variant="outlined" @click="close">Cancel</VBtn>
        <VBtn color="success" variant="outlined"  @click="save">Update</VBtn>
      </VCardText>
    </VCard>
  </VDialog>


  <!-- Add Dialog -->
  <VDialog v-model="addDialog" max-width="600px">
    <VCard title="Add New Facility">
      <VCardText>
        <VRow>
          <VCol cols="12">
            <VTextField class="facilityNamea" v-model="editedItem.facilityName" label="Facility Name" />
          </VCol>
          <VCol cols="12">
          <VSelect class="facilityType" v-model="editedItem.facilityType" :items="selectedFacilityType" item-title="text" item-value="value" label="Facility Type"/>
        </VCol>
          <VCol cols="12">
            <VTextField class="facilityCapacity" v-model="editedItem.facilityCapacity" label="Facility Capacity" type="number" />
          </VCol>
          <VCol cols="12">
            <VSelect class="status" v-model="editedItem.status" :items="selectedOptions" item-title="text" item-value="value" label="Status" />
          </VCol>
        </VRow>
      </VCardText>
      <VCardText class="self-align-end d-flex gap-4 justify-end">
        <VBtn text variant="outlined" @click="close">Cancel</VBtn>
        <VBtn color="success" variant="outlined" @click="save">Add</VBtn>
      </VCardText>
    </VCard>
  </VDialog>


  <!-- Delete Dialog -->
  <VDialog v-model="deleteDialog" max-width="500px">
    <VCard title="Confirm Delete">
      <VCardText>Are you sure you want to delete this item?</VCardText>
      <VCardActions class="self-align-end d-flex gap-3 justify-end">
        <VBtn text variant="outlined" @click="closeDelete">Cancel</VBtn>
        <VBtn color="error" variant="outlined"  @click="deleteItemConfirm">Delete</VBtn>
      </VCardActions>
    </VCard>
  </VDialog>      
            </VCardText>
          </VWindowItem>
        </VWindow>
      </VCard>
    </VCol>
  </VRow>

  <!-- Snackbar for send confirmation -->
  <VSnackbar v-model="snackbar" :timeout="3000" centered>{{ snackbarMessage }}</VSnackbar>
</template>
