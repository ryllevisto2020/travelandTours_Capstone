<template>
  <VDialog
    v-model="dialogVisible"
    max-width="800"
    class="rounded-xl shadow-lg"
  >
    <VCard class="pa-4">
      <!-- Title -->
      <VCardTitle class="text-center pb-6">
        <div class="d-flex flex-column align-items-center">
          <h3 class="text-h5 font-weight-bold text-primary">
            Step {{ activeStep }}: {{ activeStep === 1 ? 'Personal Information' : 'Purpose of Visit' }}
          </h3>
          <div class="progress-indicator mt-2" />
        </div>
      </VCardTitle>

      <!-- Step 1: Personal Information -->
      <VCardText v-if="activeStep === 1">
        <VRow>
          <VCol
            cols="12"
            sm="6"
            md="4"
          >
            <VTextField
              v-model="addedItem.firstName"
              label="First Name"
              prepend-inner-icon="bx-user"
              :error-messages="validationErrors.firstName"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            sm="6"
            md="4"
          >
            <VTextField
              v-model="addedItem.middleName"
              label="Middle Name"
              :error-messages="validationErrors.middleName"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            sm="6"
            md="4"
          >
            <VTextField
              v-model="addedItem.lastName"
              label="Last Name"
              persistent-hint
              :error-messages="validationErrors.lastName"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol cols="12">
            <VTextField
              v-model="addedItem.userEmail"
              prepend-inner-icon="bx-envelope"
              label="Email"
              placeholder="johndoe@email.com"
              :error-messages="validationErrors.userEmail"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol cols="12">
            <VTextField
              v-model="addedItem.phoneNumber"
              label="Phone Number"
              prepend-inner-icon="bx-phone"
              type="number"
              :error-messages="validationErrors.phoneNumber"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            sm="6"
          >
            <VTextField
              v-model="addedItem.userAge"
              label="Age"
              type="number"
              placeholder="18"
              :error-messages="validationErrors.userAge"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VSelect
              v-model="addedItem.status"
              :items="selectedOptions"
              item-title="text"
              item-value="value"
              label="Status"
              prepend-inner-icon="bx-home"
              disabled
              :error-messages="validationErrors.status"
              dense
              class="mb-4"
            />
          </VCol>
        </VRow>
      </VCardText>

      <!-- Step 2: Purpose of Visit -->
      <VCardText v-if="activeStep === 2">
        <VRow>
          <VCol
            cols="12"
            md="6"
          >
            <VueDatePicker
              v-model="addedItem.selectedDate"
              :clearable="true"
              placeholder="Select a date"
              variant="outlined"
              :error-messages="validationErrors.selectedDate"
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VSelect
              v-model="addedItem.selectedPurpose"
              :items="selectedPurposeType"
              label="Purpose of Visit"
              item-title="text"
              item-value="value"
              prepend-inner-icon="bx-analyse"
              :error-messages="validationErrors.selectedPurpose"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VSelect
              v-model="addedItem.selectedFacility"
              :items="selectedFacilityType"
              label="Facility to Use"
              item-title="text"
              item-value="value"
              prepend-inner-icon="bx-building"
              :error-messages="validationErrors.selectedFacility"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VSelect
              v-model="addedItem.status"
              :items="selectedOptions"
              item-title="text"
              item-value="value"
              label="Status"
              prepend-inner-icon="bx-home"
              disabled
              :error-messages="validationErrors.status"
              dense
              class="mb-4"
            />
          </VCol>
          <VCol cols="12">
            <VFileInput
              v-model="addedItem.userValidId"
              label="Upload File"
              prepend-inner-icon="bx-upload"
              dense
              show-size
              accept=".pdf,.png,.jpg,.jpeg"
              :error-messages="validationErrors.userValidId"
              class="mb-4"
              @change="handleFileUpload"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="addedItem.additionalInfo"
              label="Additional Information"
              placeholder="Provide any additional information (optional)"
              dense
              class="mb-4"
            />
          </VCol>
        </VRow>
      </VCardText>

      <!-- Actions -->
      <VCardActions>
        <div class="d-flex justify-end w-100 gap-4">
          <VBtn
            v-if="activeStep === 1"
            color="error"
            variant="outlined"
            class="rounded-lg"
            @click="handleCloseDialog"
          >
            <VIcon
              icon="bx-x"
              start
            />
            Close
          </VBtn>

          <VBtn
            v-if="activeStep === 2"
            color="secondary"
            variant="outlined"
            class="rounded-lg"
            @click="previousStep"
          >
            <VIcon
              icon="bx-left-arrow-alt"
              start
            />
            Previous
          </VBtn>

          <VBtn
            v-if="activeStep === 1"
            color="primary"
            variant="outlined"
            class="ml-auto rounded-lg"
            @click="nextStep"
          >
            Next
            <VIcon
              icon="bx-right-arrow-alt"
              end
            />
          </VBtn>

          <VBtn
            v-if="activeStep === 2"
            color="success"
            variant="outlined"
            class="rounded-lg"
            @click="saveItem"
          >
            Submit
            <VIcon
              icon="bx-check"
              end
            />
          </VBtn>
        </div>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<script>
import { defineComponent, toRefs, onMounted } from 'vue'

export default defineComponent({
  props: {
    dialogVisible: {
      type: Boolean,
      required: true,
    },
    addedItem: {
      type: Object,
      required: true,
    },
    validationErrors: {
      type: Object,
      required: true,
    },
    activeStep: {
      type: Number,
      required: true,
    },
    selectedOptions: {
      type: Array,
      required: false,
      default: () => [{ text: 'Pending', value: 'Pending' }],
    },
    selectedPurposeType: {
      type: Array,
      required: false,
      default: () => [
        { text: 'Business', value: 1 },
        { text: 'Personal', value: 2 },
        { text: 'Other', value: 3 },
      ],
    },
    selectedFacilityType: {
      type: Array,
      required: false,
      default: () => [
        { text: 'Meeting Room 1', value: 1 },
        { text: 'Meeting Room 2', value: 2 },
        { text: 'Meeting Room 3', value: 3 },
      ],
    },
  },
  emits: ['previous-step', 'next-step', 'save-item', 'close-dialog'],
  setup(props, { emit }) {
    const { dialogVisible, addedItem, validationErrors, activeStep, selectedOptions, selectedPurposeType, selectedFacilityType } = toRefs(props)

    onMounted(() => {
      addedItem.value.status = 'Pending' // Ensure status is always 'Pending'
    })

    const validateForm = () => {
      let valid = true

      // Clear all previous validation errors
      Object.keys(validationErrors.value).forEach(key => {
        validationErrors.value[key] = ""
      })

      // Validate required fields for Step 1
      if (!addedItem.value.firstName) {
        validationErrors.value.firstName = "First name is required."
        valid = false
      }
      if (!addedItem.value.middleName) {
        validationErrors.value.middleName = "Middle name is required."
        valid = false
      }
      if (!addedItem.value.lastName) {
        validationErrors.value.lastName = "Last name is required."
        valid = false
      }
      if (!addedItem.value.userEmail) {
        validationErrors.value.userEmail = "Email is required."
        valid = false
      }
      if (!addedItem.value.phoneNumber) {
        validationErrors.value.phoneNumber = "Phone number is required."
        valid = false
      }
      if (!addedItem.value.userAge) {
        validationErrors.value.userAge = "Age is required."
        valid = false
      }

      // Validate Step 2 if activeStep is 2
      if (activeStep.value === 2) {
        if (!addedItem.value.selectedDate) {
          validationErrors.value.selectedDate = "Date is required."
          valid = false
        }
        if (!addedItem.value.selectedPurpose) {
          validationErrors.value.selectedPurpose = "Purpose of visit is required."
          valid = false
        }
        if (!addedItem.value.selectedFacility) {
          validationErrors.value.selectedFacility = "Facility selection is required."
          valid = false
        }
        if (!addedItem.value.userValidId || addedItem.value.userValidId.length === 0) {
          validationErrors.value.userValidId = 'File upload is required.'
          valid = false
        }
      }


      return valid
    }

    const handleFileUpload = files => {
      if (files && files.length > 0) {
        addedItem.value.userValidId = files // Save the uploaded files to the state
        validationErrors.value.userValidId = '' // Clear any previous errors
      }
    }

    const previousStep = () => {
      emit('previous-step')
    }

    const nextStep = () => {
      if (validateForm()) {
        emit('next-step')
      }
    }

    const saveItem = () => {
      if (validateForm()) {
        emit('save-item')
      }
    }

    const handleCloseDialog = () => {
      emit('close-dialog')
    }

    return {
      dialogVisible, // Bind the v-model correctly
      addedItem,
      validationErrors,
      activeStep,
      selectedOptions,
      selectedPurposeType,
      selectedFacilityType,
      previousStep,
      nextStep,
      saveItem,
      handleCloseDialog,
      handleFileUpload,
    }
  },
})
</script>


<style scoped>
/* Clean UI styling for the dialog */
.pa-4 {
  padding: 16px;
}

.text-center {
  text-align: center;
}

.progress-indicator {
  width: 60px;
  height: 3px;
  background-color: var(--v-theme-primary);
  border-radius: 5px;
}

.mb-4 {
  margin-bottom: 16px;
}

.v-btn {
  transition: all 0.2s ease;
}

.v-btn:hover {
  background-color: rgba(0, 0, 0, 0.08);
}

.v-card {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.v-card-title h3 {
  font-size: 1.5rem;
  font-weight: 500;
  color: var(--v-theme-primary);
}

.v-text-field .v-input__control {
  border-radius: 10px;
}

.v-select .v-input__control,
.v-text-field .v-input__control {
  border: 1px solid #e0e0e0;
}

.v-select .v-input__control:hover,
.v-text-field .v-input__control:hover {
  border-color: #9e9e9e;
}

.v-btn {
  min-width: 120px;
}
</style>
