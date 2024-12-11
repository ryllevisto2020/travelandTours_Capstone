<!-- eslint-disable import/no-unresolved -->
<script setup>
import logo from '@images/logo.svg?raw'
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?url'
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?url'
import { ref } from 'vue'

const showModal = ref(true)
const agreedToPrivacy = ref(false)

const submitAgreement = () => {
  if (agreedToPrivacy.value) {
    showModal.value = false

  }
}
</script>

<template>
  <VDialog
    v-model="showModal"
    max-width="1000px"
    persistent
  >
    <div class="auth-wrapper d-flex align-center justify-center pa-4">
      <div class="position-relative my-sm-16">
        <!-- 👉 Top shape -->
        <VImg
          :src="authV1TopShape"
          class="text-primary auth-v1-top-shape d-none d-sm-block"
        />

        <!-- 👉 Bottom shape -->
        <VImg
          :src="authV1BottomShape"
          class="text-primary auth-v1-bottom-shape d-none d-sm-block"
        />

        <!-- 👉 Auth card -->
        <VCard
          class="auth-card"
          max-width="auto"
          :class="$vuetify.display.smAndUp ? 'pa-6' : 'pa-4'"
          style="max-height: 80vh; overflow-y: auto;"
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
            <h4 class="text-h4 mb-4">
              PRIVACY POLICY
            </h4>
            <div class="privacy-policy-content">
              <p><strong>1. Introduction</strong></p>
              <p>Welcome to JVD Event and Travel Management. We value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data.</p>

              <p><strong>2. Information We Collect</strong></p>
              <ul>
                <li>Personal Information: Name, email address, and other identifiable information.</li>
                <li>Usage Data: Information about how you use our services.</li>
              </ul>

              <p><strong>3. How We Use Your Information</strong></p>
              <p>To provide, maintain, and improve our services.</p>

              <p><strong>4. Your Rights</strong></p>
              <p>You have the right to access and request the deletion of your personal data.</p>

              <p><strong>5. Changes to This Privacy Policy</strong></p>
              <p>We may update this Privacy Policy and will notify you of any changes.</p>
            </div>

            <!-- Checkbox for agreement -->
            <VCheckbox
              v-model="agreedToPrivacy"
              label="I agree to the Privacy Policy"
              class="mt-4"
            />
          </VCardText>

          <VCardItem>
            <VBtn
              :disabled="!agreedToPrivacy"
              to="/login"
              color="primary"
              @click="submitAgreement"
            >
              Continue
            </VBtn>
          </VCardItem>
        </VCard>
      </div>
    </div>
  </VDialog>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";

.privacy-policy-content {
  line-height: 1.6;
  margin-top: 1rem;
}

.privacy-policy-content ul {
  list-style-type: disc;
  padding-left: 20px;
}
</style>
