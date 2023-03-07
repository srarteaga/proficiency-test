<template>
  <div id="app">
    <div class="container mx-auto p-6">
      <div class="text-center mt-5">
        <h2 class="text-3xl font-extrabold">List The Properties</h2>
      </div>
      <v-table
      :properties="properties"
      :propertyTypes="propertyTypes"
      :users="users"
      ></v-table>
    </div>

  </div>
</template>

<script>
import { users, propertyTypes, properties } from '@/mocks/api';
import VTable from './components/table.vue';

export default {
  name: 'App',
  components: {
    VTable,
  },
  data: () => ({
    users,
    propertyTypes,
    properties,
  }),
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('user')) {
      const userId = urlParams.get('user');
      this.properties = this.properties.filter((property) => property.userId === Number(userId));
    }
  },
};
</script>
