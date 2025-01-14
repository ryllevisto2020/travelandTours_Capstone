<!-- eslint-disable camelcase -->
<!-- eslint-disable promise/no-nesting -->
<!-- eslint-disable import/default -->
<!-- eslint-disable import/no-unresolved -->
<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import axios from 'axios'
import * as jose from 'jose'

var payload = null
var client = false
var emp = false

const  role_res  = await axios.get("/auth/role", {
  headers: {
    "Content-Type": "application/json",
  },
})

payload = role_res.data.payload

const jwt_verify = await jose.jwtVerify(payload, new TextEncoder().encode(import.meta.env.VITE_KEY))

if(jwt_verify.payload.role == "client"){
  client = true
}
</script>

<template>
  <div v-if="client">
    <VerticalNavGroup
      :item="{
        title: 'Visitor',
        to: '/client/vis-dashboard',
        icon: 'bx-user',
      }"
    >
      <VerticalNavLink
        :item="{
          title: 'Visitor',
          to: '/client/vis-dashboard',
        }"
      />
    </VerticalNavGroup>
  </div>
</template>
