<!-- eslint-disable camelcase -->
<script setup>
import logo from '@images/logo.svg?raw'
import axios from "axios"
import { useRouter } from 'vue-router'
import { ref } from 'vue'
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
            <!-- eslint-disable vue/no-v-html -->
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
            Please sign-in to your account and manage administrative task
          </p>
        </VCardText>

        <VCardText>
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                ref="empID"
                v-model="form.email"
                autofocus
                label="Email or Username"
                type="email"
                placeholder="your_email@email.com"
              />
            </VCol>

            <!-- password -->
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

              <!-- remember me checkbox -->
              <div class="d-flex align-center justify-space-between flex-wrap my-6">
                <VCheckbox
                  v-model="form.remember"
                  label="Remember me"
                />

                <a
                  class="text-primary"
                  href="javascript:void(0)"
                >
                  Forgot Password?
                </a>
              </div>

              <!-- logout button -->
              <VBtn
                block
                type="button"
                @click="logout"
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

  