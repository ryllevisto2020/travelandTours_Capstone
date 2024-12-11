<script setup>
const firstName = ref('')
const lastName = ref('')
const email = ref('')
const mobile = ref()
const password = ref()
const checkbox = ref(false)

</script>

<template>
  <VForm @submit.prevent>
    <VRow>
      <VCol cols="12">
        <VTextField
          v-model="firstName"
          prepend-inner-icon="bx-user"
          label="First Name"
          placeholder="Enter First Name"
        />
      </VCol>

      <VCol cols="12">
        <VTextField
          v-model="lastName"
          prepend-inner-icon="bx-user"
          label="Last Name"
          placeholder="Enter Last Name"
        />
      </VCol>

      <VCol cols="12">
        <VTextField
          v-model="email"
          prepend-inner-icon="bx-envelope"
          label="Email"
          type="email"
          placeholder="youre_email@example.com"
        />
      </VCol>

      <VCol cols="12">
        <VTextField
          v-model="mobile"
          prepend-inner-icon="bx-mobile"
          label="Mobile"
          placeholder="(+63) 123 456 7890"
          type="number"
        />
      </VCol>

      <VCol cols="12">
        <VTextField
          v-model="password"
          prepend-inner-icon="bx-lock"
          label="Password"
          autocomplete="on"
          type="password"
          placeholder="············"
        />
      </VCol>

      <VCol cols="12">
        <VCheckbox
          v-model="checkbox"
          label="Remember me"
        />
      </VCol>

      <VCol cols="12">
        <VBtn
          type="submit"
          class="me-2"
        >
          Submit
        </VBtn>

        <VBtn
          color="secondary"
          type="reset"
          variant="tonal"
        >
          Reset
        </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

