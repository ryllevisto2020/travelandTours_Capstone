<!-- eslint-disable import/no-unresolved -->
<script setup>
import logo from '@images/logo.svg?raw'
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?url'
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?url'
import { ref } from 'vue'


const showModal = ref(true)
const agreedToTerms = ref(false)

const submitAgreement = () => {

  if (agreedToTerms.value) {
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
  TERMS AND CONDITIONS
</h4>
<div class="terms-conditions-content">
  <p>Welcome to the Travel and Tours Management System (the "System") of JVD Event and Travel Management Co. ("Company"). By accessing or using this System, you (the "User") acknowledge that you are an employee of JVD Event and Travel Management Co. and agree to comply with the following terms and conditions. These terms align with ISO standards and the provisions of the Data Privacy Act of the Philippines (RA 10173).</p>

  <p><strong>1. User Responsibilities</strong></p>
  <p><strong>1.1 Authorized Access</strong></p>
  <ul>
    <li>The System is exclusively for the use of authorized employees of the Company. Sharing login credentials or allowing unauthorized access to the System is strictly prohibited.</li>
  </ul>
  <p><strong>1.2 Proper Use</strong></p>
  <ul>
    <li>Users must use the System solely for its intended purpose: managing travel and tour operations. Any misuse, including unauthorized modifications, data manipulation, or engaging in activities outside the scope of your role, is prohibited.</li>
  </ul>
  <p><strong>1.3 Confidentiality</strong></p>
  <ul>
    <li>Users must treat all data accessed through the System as confidential, including customer information, company policies, and operational records. Disclosure of such information without proper authorization is a violation of Company policy and applicable laws.</li>
  </ul>

  <p><strong>2. Compliance with Data Privacy Act of the Philippines</strong></p>
  <p><strong>2.1 Data Handling</strong></p>
  <ul>
    <li>Users are required to handle all personal data of customers, partners, and colleagues in compliance with the Data Privacy Act of 2012 (RA 10173). This includes:</li>
    <ul>
      <li>Collecting data only for legitimate purposes.</li>
      <li>Ensuring data is accurate and up-to-date.</li>
      <li>Protecting data from unauthorized access, loss, or misuse.</li>
    </ul>
  </ul>
  <p><strong>2.2 Breach Notification</strong></p>
  <ul>
    <li>Any suspected or actual data breach must be immediately reported to the Company's Data Protection Officer (DPO). Failure to report incidents may result in disciplinary action.</li>
  </ul>
  <p><strong>2.3 Training and Awareness</strong></p>
  <ul>
    <li>Users must participate in any data privacy and security training provided by the Company to ensure compliance with ISO and local regulations.</li>
  </ul>

  <p><strong>3. Security and System Integrity</strong></p>
  <p><strong>3.1 Login Credentials</strong></p>
  <ul>
    <li>Users are responsible for safeguarding their login credentials. Immediate reporting of lost or compromised credentials is mandatory.</li>
  </ul>
  <p><strong>3.2 System Monitoring</strong></p>
  <ul>
    <li>The Company reserves the right to monitor System usage to ensure compliance with these terms. Any activity that compromises the integrity, security, or functionality of the System will be investigated and may result in legal or disciplinary action.</li>
  </ul>
  <p><strong>3.3 Prohibited Activities</strong></p>
  <ul>
    <li>Users must not:</li>
    <ul>
      <li>Attempt to hack or disable the System.</li>
      <li>Install unauthorized software or plugins.</li>
      <li>Access or modify data outside their authorized role.</li>
    </ul>
  </ul>

  <p><strong>4. Intellectual Property</strong></p>
  <ul>
    <li>The System and its contents, including but not limited to software, documentation, and designs, are the intellectual property of JVD Event and Travel Management Co. Unauthorized reproduction, distribution, or modification is strictly prohibited.</li>
  </ul>

  <p><strong>5. Limitation of Liability</strong></p>
  <ul>
    <li>The Company will not be liable for damages caused by improper use of the System, including unauthorized activities or failure to comply with these terms.</li>
  </ul>

  <p><strong>6. Amendments to Terms</strong></p>
  <ul>
    <li>The Company reserves the right to amend these Terms and Conditions as needed to comply with new regulations or improve operations. Users will be notified of any significant changes. Continued use of the System constitutes acceptance of the updated terms.</li>
  </ul>

  <p><strong>7. Termination of Access</strong></p>
  <ul>
    <li>Violation of these terms may result in the suspension or termination of System access. Severe breaches, particularly those involving data privacy violations, may lead to legal action or termination of employment.</li>
  </ul>

  <p>By using the Travel and Tours Management System, you acknowledge that you have read, understood, and agree to comply with these Terms and Conditions. If you have any questions or require clarification, please contact the Data Protection Officer or your supervisor.</p>
</div>


            <!-- Checkbox for agreement -->
            <VCheckbox
              v-model="agreedToTerms"
              label="I agree to the Terms and Conditions"
              class="mt-4"
            />
          </VCardText>

          <VCardItem>
            <VBtn
              :disabled="!agreedToTerms"
              color="primary"
              to="/login"
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

.terms-conditions-content {
  line-height: 1.6;
  margin-top: 1rem;
}

.terms-conditions-content ul {
  list-style-type: disc;
  padding-left: 20px;
}
</style>
