<script setup>
import { ref, computed } from 'vue';
import { VTextField, VDataTable, VChip, VBtn, VIcon } from 'vuetify/components';


const props = defineProps({
  userList: Array,
  headers: Array,
  handleEditItem: Function,
  handleDeleteItem: Function,
  resolvePurposeType: Function,
  resolveFacilityType: Function,
  resolveStatusVariant: Function,
});

const search = ref('');

// Filtered list based on search
const filteredList = computed(() => {
  if (!search.value) return props.userList;
  const lowerCaseSearch = search.value.toLowerCase();
  return props.userList.filter((item) =>
    Object.values(item)
      .join(' ')
      .toLowerCase()
      .includes(lowerCaseSearch)
  );
});
</script>

<template>
  <VCard>
    <VTextField
      v-model="search"
      label="Search for Appointments"
      prepend-inner-icon="bx-home"
      variant="outlined"
      hide-details
      single-line
      class="mx-auto my-4"
      style="max-width: 95%;"
    />
    <VDataTable :headers="props.headers" :items="filteredList" :items-per-page="10">
      <template #item.firstName="{ item }">
        <div>{{ item.firstName }}</div>
      </template>
      <template #item.userValidId="{ item }">
  <div>
    {{ item.userValidId.join(', ') }}
  </div>
</template>

      <template #item.selectedPurpose="{ item }">
        <VChip :color="props.resolvePurposeType(item.selectedPurpose).color" size="small">
          {{ props.resolvePurposeType(item.selectedPurpose).text }}
        </VChip>
      </template>
      <template #item.selectedFacility="{ item }">
        <VChip :color="props.resolveFacilityType(item.selectedFacility).color" size="small">
          {{ props.resolveFacilityType(item.selectedFacility).text }}
        </VChip>
      </template>
      <template #item.status="{ item }">
        <VChip :color="props.resolveStatusVariant(item.status).color" size="small">
          {{ props.resolveStatusVariant(item.status).text }}
        </VChip>
      </template>
      <template  #item.actions="{ item }">
        <VBtn icon variant="text" color="primary" @click="props.handleEditItem(item)">
          <VIcon icon="bx-edit" />
        </VBtn>
        <VBtn icon variant="text" color="error" @click="props.handleDeleteItem(item)">
          <VIcon icon="bx-trash" />
        </VBtn>
      </template>
    </VDataTable>
  </VCard>
</template>
