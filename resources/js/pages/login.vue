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

var empEmail = ref() // Renamed from empID to empEmail
var empPass = ref()
const agreedToPrivacy = ref(false)
const agreedToTerms = ref(false)

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const isPasswordVisible = ref(false)

const csrf_token = document.getElementsByName("csrf-token")

class Validation {
  constructor(email, password) {
    this.email = email
    this.password = password
  }

  validate() {
    const errors = []
    if (!this.email || this.email.trim() === '') {
      errors.push({ errCode: "0x01", msg: "Email Address is required", class: "errID" })
    } else if (!this.isValidEmail(this.email)) {
      errors.push({ errCode: "0x02", msg: "Invalid Email Address", class: "errID" })
    }
    if (!this.password || this.password.trim() === '') {
      errors.push({ errCode: "0x03", msg: "Invalid Password", class: "errPASS" })
    }
    
    return errors
  }

  isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@][^\s.@]*\.[^\s@]+$/
    
    return emailPattern.test(email)
  }
}

const login = e => {
  document.getElementsByClassName("errID")[0].style = "visibility: hidden;"
  document.getElementsByClassName("errPASS")[0].style = "visibility: hidden;"

  const empData = {
    email: empEmail.value.modelValue, // Updated to match empEmail
    password: empPass.value.modelValue,
  }

  const formValidation = new Validation(empData.email, empData.password)
  const errors = formValidation.validate()

  errors.forEach(error => {
    const errComp = document.getElementsByClassName(error.class)

    errComp[0].style = "visibility: visible;"
    errComp[0].style = "color: red;"
    errComp[0].innerText = error.msg
  })

  if (errors.length === 0) {
    if (!agreedToPrivacy.value || !agreedToTerms.value) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "You must agree to Privacy Policy, Terms and Conditions!",
      })

      return
    } else {
      e.target.disabled = true
      e.target.innerHTML = `<input type="image" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" height="25"/> `
    }

    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: toast => {
        toast.onmouseenter = Swal.stopTimer
        toast.onmouseleave = Swal.resumeTimer
      },
    })

    axios.post("/login/auth", { data: empData }, {
      headers: {
        'X-CSRF-TOKEN': csrf_token[0].content,
      },
    }).then(function(res) {
      if (res.data.code === 401) {
        Toast.fire({
          icon: "error",
          title: "Sign-in Failed",
        })
        e.target.disabled = false
        e.target.innerText = "Login"
      } else {
        Toast.fire({
          icon: "success",
          title: "Signed in successfully",
        })
        e.target.disabled = false
        e.target.innerText = "Login"
        router.push("/vis-dashboard")
      }
    })

  }
}
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <div class="position-relative my-sm-16">
      <VCard
        class="auth-card"
        max-width="460"
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
            Please sign-in to your account and manage administrative tasks
          </p>
        </VCardText>

        <VCardText>
          <VRow>
            <!-- Email -->
            <VCol cols="12">
              <VTextField
                ref="empEmail"
                v-model="form.email"
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
                ref="empPass"
                v-model="form.password"
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

              <div class="d-flex align-center justify-space-between flex-wrap my-6">
                <VCheckbox
                  v-model="agreedToPrivacy"
                  :label="null"
                >
                  <template #label>
                    <RouterLink
                      to="/privacypolicy"
                      class="text-decoration-none"
                    >
                      I agree to the <strong>Privacy Policy</strong>
                    </RouterLink>
                  </template>
                </VCheckbox>

                <VCheckbox
                  v-model="agreedToTerms"
                  :label="null"
                >
                  <template #label>
                    <RouterLink
                      to="/termsconditions"
                      class="text-decoration-none"
                    >
                      I agree to the <strong>Terms and Conditions</strong>
                    </RouterLink>
                  </template>
                </VCheckbox>
              </div>

              <!-- Login Button -->
              <VBtn
                block
                type="button"
                @click="login($event)"
              >
                Login
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
