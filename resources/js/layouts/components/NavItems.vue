<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
</script>

<template>
 <VerticalNavGroup
        :item="{
        title: 'Visitor',
        to: '/vis-dashboard',
        icon: 'bx-user',
      }"
    >
    <VerticalNavLink
      :item="{
        title: 'Visitor',
        to: '/vis-dashboard',
      }"
    />
  </VerticalNavGroup>
</template>
