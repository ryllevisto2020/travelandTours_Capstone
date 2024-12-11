<script setup>
import VisitorStorage from '@/views/vis-management/VisitorStorage.vue';
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';


const route = useRoute();
const router = useRouter();


const tabs = [
  { title: 'Appointment Application', icon: 'bx-user', tab: 'visitor' },
];


const activeTab = ref(route.params.tab || 'visitor');


watch(activeTab, (newTab) => {
  router.push({ name: 'vis-dashboard', params: { tab: newTab } });
});


watch(route, () => {
  activeTab.value = route.params.tab || 'visitor';
});

</script>

<template>
  <div>
    <VTabs v-model="activeTab" show-arrows class="v-tabs-pill">
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
      <VWindowItem value="visitor">
        <VisitorStorage/>
      </VWindowItem>
    </VWindow>
  </div>
</template>
