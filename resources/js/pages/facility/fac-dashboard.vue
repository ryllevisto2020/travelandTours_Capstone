<script setup>
import FacilityStorage from '@/views/fac-management/FacilityStorage.vue';
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

// Get route and router instances
const route = useRoute();
const router = useRouter();

// Define tabs
const tabs = [
  { title: 'Facility Management', icon: 'bx-home', tab: 'facility' },
];

// Active tab sync with the route param or fallback to the first tab
const activeTab = ref(route.params.tab || 'facility');

// Watch the activeTab and update the URL when the tab changes
watch(activeTab, (newTab) => {
  router.push({ name: 'fac-dashboard', params: { tab: newTab } });
});

// Watch the route and update the activeTab when the route changes
watch(route, () => {
  activeTab.value = route.params.tab || 'facility';
});

</script>

<template>
  <div>
    <!-- Tabs for navigation -->
    <VTabs v-model="activeTab" show-arrows class="v-tabs-pill">
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <!-- Tab content -->
    <VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
      <!-- Customer Storage -->
      <VWindowItem value="facility">
        <FacilityStorage />
      </VWindowItem>

    </VWindow>
  </div>
</template>
