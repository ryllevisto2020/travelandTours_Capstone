<script setup>
import { ref, watch } from 'vue';
import Footer from '@/layouts/components/Footer.vue';
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue';
import NavItems from '@/layouts/components/NavItems.vue';
import UserProfile from '@/layouts/components/UserProfile.vue';
import logo from '@images/logo.svg?raw';
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue';

// Reactive variables for search functionality
const searchTerm = ref('');
const searchResults = ref([]);

// Updated mock data to include links to document dashboard tabs
const allItems = [
  { type: 'Document', name: 'Customer Storage', link: '/doc-dashboard/customer' },
  { type: 'Report', name: 'Expense Report', link: '/doc-dashboard/customer/passport' },
  { type: 'User', name: 'John Doe', link: '/users/john-doe' },
  { type: 'User', name: 'Jane Smith', link: '/users/jane-smith' },
  { type: 'Document', name: 'Legal Storage', link: '/doc-dashboard/legal' },
  { type: 'Document', name: 'Contract Storage', link: '/doc-dashboard/contract' },
  { type: 'Document', name: 'Employee Storage', link: '/doc-dashboard/employees' },
  { type: 'User Setting', name: 'Account', link: '/account-settings' },
  { type: 'Report', name: 'Expense Report', link: '/reports/1' },
  { type: 'User', name: 'John Doe', link: '/users/john-doe' },
  { type: 'User', name: 'Jane Smith', link: '/users/jane-smith' },
];

// Function to filter results based on the search term
const performSearch = () => {
  if (searchTerm.value.length === 0) {
    searchResults.value = [];
    return;
  }
  searchResults.value = allItems.filter(item =>
    item.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  );
};

// Debouncing the search input
let debounceTimer;
watch(searchTerm, (newValue) => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    performSearch();
  }, 300); // 300ms debounce time
});
</script>

<template>
  <div class="layout-wrapper">
    <div class="layout-content">
      <VerticalNavLayout>
        <template #navbar="{ toggleVerticalOverlayNavActive }">
          <div class="d-flex h-100 align-center">
            <IconBtn class="ms-n3 d-lg-none" @click="toggleVerticalOverlayNavActive(true)">
              <VIcon icon="bx-menu" />
            </IconBtn>

            <div class="d-flex align-center cursor-pointer ms-lg-n3" style="user-select: none; position: relative;">
              <input 
                v-model="searchTerm" 
                placeholder="Search anything..." 
                class="search-input"
              />
              <IconBtn @click="performSearch">
                <VIcon icon="bx-search" />
              </IconBtn>

              <!-- Display search results -->
              <div class="search-results" v-if="searchResults.length > 0">
                <ul>
                  <li v-for="result in searchResults" :key="result.name">
                    <RouterLink :to="result.link">{{ result.name }} ({{ result.type }})</RouterLink>
                  </li>
                </ul>
              </div>
            </div>

            <VSpacer />
            <IconBtn>
              <VIcon icon="bx-bell" />
              <VMenu
        activator="parent"
        width="400"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            

            <VListItemTitle class="font-weight-black text-h4">
            Notifications
            </VListItemTitle>

           
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Notifications -->
          <VListItem link @click="clearNotifications">
            <template #prepend>
              This is notification
            </template>
           
          </VListItem>

       

          <!-- Other Menu Items -->
          <VListItem link>
            <template #prepend>
              This is notification
            </template>
           
          </VListItem>

          <VListItem link to="">
            <template #prepend>
              This is notification
            </template>
        
          </VListItem>

          <VListItem link>
            <template #prepend>
              This is notification
            </template>
            
          </VListItem>

          <VListItem link>
            <template #prepend>
              This is notification
            </template>
         
          </VListItem>

          <VDivider class="my-2" />

          <VListItem to="">
            <template #prepend>
              This is notification
            </template>
           
          </VListItem>
        </VList>
      </VMenu>
            </IconBtn>
            <NavbarThemeSwitcher class="me-1" />
            <UserProfile />
          </div>
        </template>

        <template #vertical-nav-header="{ toggleIsOverlayNavActive }">
          <RouterLink to="/" class="app-logo app-title-wrapper">
            <div class="d-flex ml-5" v-html="logo" />
          </RouterLink>
          <IconBtn class="d-block d-lg-none" @click="toggleIsOverlayNavActive(false)">
            <VIcon icon="bx-x" />
          </IconBtn>
        </template>

        <template #vertical-nav-content>
          <NavItems />
        </template>

        <!-- 👉 Pages -->
        <slot />
      </VerticalNavLayout>
    </div>

    <!-- 👉 Footer stays fixed -->
    <footer class="footer">
      <Footer />
    </footer>
  </div>
</template>

<style lang="scss" scoped>
.layout-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.layout-content {
  flex: 1;
  zoom: 0.85; /* Adjust the zoom of the layout to 90% */
  -moz-transform: scale(0.9); /* Firefox compatibility */
  -moz-transform-origin: top center;
}

.footer {
  position: relative;
  bottom: 0;
  width: 100%;
  height: 60px; /* Adjust based on your footer height */
}

/* Search input styles */
.search-input {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  width: 300px; /* Wider input for better usability */
  margin-right: 8px; /* Space between input and button */
}

/* Styles for search results */
.search-results {
  position: absolute; /* Ensure it overlays other elements */
  background: white;
  border: 1px solid #ccc;
  z-index: 1000; /* Set a high z-index to appear above other elements */
  width: 300px; /* Match the width of the search input */
  max-height: 200px; /* Limit the height of the results */
  overflow-y: auto; /* Add scroll if results exceed max height */
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Optional: Add some shadow for depth */
  right: 0; /* Align to the right side of the input */
  top: 100%; /* Position it directly below the search input */
}

.search-results ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.search-results li {
  padding: 8px;
  cursor: pointer;
}

.search-results li:hover {
  background-color: #f0f0f0; /* Highlight on hover */
}
</style>
