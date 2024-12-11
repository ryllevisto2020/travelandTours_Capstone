<!-- eslint-disable sonarjs/no-unused-collection -->
<!-- eslint-disable sonarjs/no-duplicated-branches -->
<!-- eslint-disable sonarjs/no-all-duplicated-branches -->
<!-- eslint-disable camelcase -->
<script setup>
import logo from '@images/logo.svg?raw'
import axios from "axios"
import { useRouter } from 'vue-router'
import { ref } from 'vue'

const router = useRouter()


const form = ref({
  firstName: '',
  lastName: '',
  phoneNumber: '',
  email: '',
  password: '',
  confirmPassword: '',
  remember: false,
})

const isPasswordVisible = ref(false)

</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <div class="position-relative my-sm-16">
      <VCard
        class="auth-card"
        max-width="800"
        :class="$vuetify.display.smAndUp ? 'pa-6' : 'pa-0'"
      >
        <VCardItem class="justify-center">
          <RouterLink
            to="/"
            class="app-logo"
          >
            <div
              class="d-flex"
              v-html="logo"
            />
          </RouterLink>
        </VCardItem>

        <VCardText>
          <h4 class="text-h4 mb-1">
            Welcome to JVD!
          </h4>
          <p class="mb-0">
            Please fill out the form below to register
          </p>
        </VCardText>

        <VCardText class="pa-4">
          <VRow dense>

            <!-- First Name -->
            <VCol cols="12" md="6">
              <VTextField
                ref="userFname"
                v-model="form.Fname"
                label="First Name"
                type="text"
                autocomplete="off"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errPASS"
              >Invalid Password</span>
            </VCol>

            <!-- Last Name -->
            <VCol cols="12" md="6">
              <VTextField
                ref="userLname"
                v-model="form.Lname"
                label="Last Name"
                type="text"
                autocomplete="off"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errPASS"
              >Invalid Password</span>
            </VCol>

            <!-- Phone Number -->
            <VCol cols="12" md="6">
              <VTextField
                ref="userPnumber"
                v-model="form.Pnumber"
                label="Phone Number"
                type="Number"
                autocomplete="off"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errID"
              >Invalid Email Address</span>
            </VCol>


            <!-- Email -->
            <VCol cols="12" md="6">
              <VTextField
                ref="userEadd"
                v-model="form.Eadd"
                label="Email Address"
                type="text"
                placeholder="Enter your email address"
                autocomplete="off"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errID"
              >Invalid Email Address</span>
            </VCol>


            <!-- Password -->
            <VCol cols="12">
              <VTextField
                ref="userPass"
                v-model="form.Upass"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errPASS"
              >Invalid Password</span>
            </VCol>

            <!-- Password -->
            <VCol cols="12">
              <VTextField
                ref="userCpass"
                v-model="form.Cpass"
                label="Confirm Password"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
              <span
                style="color:red;visibility: hidden;"
                class="errPASS"
              >Invalid Password</span>



              <!-- Login Button -->
              <VBtn
                block
                type="button"
                @click="register($event)"
                class="mt-4"
              >
                Register
              </VBtn>
            </VCol>
          </VRow>
        </VCardText>

      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
