<!-- eslint-disable camelcase -->
<!-- eslint-disable vue/custom-event-name-casing -->
<!-- eslint-disable vue/no-restricted-class -->
<!-- eslint-disable vue/prefer-true-attribute-shorthand -->
<!-- eslint-disable vue/no-mutating-props -->
<template>
  <VDialog
    v-model="dialogVisible"
    max-width="800"
    class="rounded-xl shadow-lg"
    persistent
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
      <VCardText
        v-if="activeStep === 2"
        class="d"
      >
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
              item-title="purpose"
              item-value="id"
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
              item-title="facility"
              item-value="id"
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
              class="mb-4 test"
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
import axios from 'axios'

// eslint-disable-next-line camelcase
var csrf_token = document.getElementsByName("csrf-token")[0]["content"]

const facilities = await axios.get('/facilities', {
  headers: {
    // eslint-disable-next-line camelcase
    "X-CSRF-TOKEN": csrf_token,
  },
})

var [ facility, purpose ] = facilities.data

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
      default: () => purpose.purpose,
    },
    selectedFacilityType: {
      type: Array,
      required: false,
      default: () => facility.facilities,
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

      /*if (!addedItem.value.middleName) {
        validationErrors.value.middleName = "Middle name is required."
        valid = false
      }*/

      if (!addedItem.value.lastName) {
        validationErrors.value.lastName = "Last name is required."
        valid = false
      }

      // eslint-disable-next-line camelcase, regexp/no-unused-capturing-group, regexp/no-useless-escape
      var  validate_email = RegExp(/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/)
      // eslint-disable-next-line camelcase
      if (!addedItem.value.userEmail || !validate_email.test(addedItem.value.userEmail)) {
        validationErrors.value.userEmail = "Email is Invalid."
        valid = false
      }

      // eslint-disable-next-line camelcase, regexp/prefer-d
      var validate_phone = RegExp(/[0-9]{11}/)
      // eslint-disable-next-line camelcase
      if (!addedItem.value.phoneNumber || !validate_phone.test(addedItem.value.phoneNumber.toString())) {
        validationErrors.value.phoneNumber = "Phone number is Invalid"
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

    const handleFileUpload = async files => {
      Swal.fire({
        imageUrl: "https://www.wpfaster.org/wp-content/uploads/2013/06/loading-gif.gif",
        imageHeight: 100,
        html: "Checking File for Malicious Content...<br>Please Wait!",
        target: ".d",
        showConfirmButton: false,
        allowOutsideClick: false,
      })

      // eslint-disable-next-line camelcase
      var file_report = await axios.post("/api/v3/files", { file: files.target.files[0] }, {
        headers: {
          "Accept": "application/json",
          "Content-Type": "multipart/form-data",
        },
      })

      // eslint-disable-next-line camelcase
      var malicious = file_report.data.data.data.attributes.last_analysis_stats.malicious
      // eslint-disable-next-line camelcase
      var suspicious = file_report.data.data.data.attributes.last_analysis_stats.suspicious
      // eslint-disable-next-line camelcase
      var fileName = file_report.data.fileName

      addedItem.value.userFileName = fileName

      if(malicious > 0 || suspicious > 0){
        Swal.close()
        Swal.fire({
          icon: 'error',
          text: "Malicious File Detected!",
          target: ".d",
          allowOutsideClick: false,
        })
        document.querySelector(".test .v-input__control .v-field .v-field__field .v-field__input").textContent=null
        files.target.values=null
        addedItem.value.userValidId = []
      }else{
        Swal.close()
        if (files && files.length > 0) {
          addedItem.value.userFileName = fileName // Save the uploaded files to the state
          validationErrors.value.userValidId = '' // Clear any previous errors
        }
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

.disable-outside-click{
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10000;
}

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
