<template>
<div class="container mx-auto p-8">
    <label
      class="block text-gray-700 font-bold mb-2"
      for="property_type_filter"
    >
      Filter Property:
    </label>
    <div class="inline-block relative">
      <input
        id="property_type_filter"
        type="text"
        v-model="search"
        class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
      />

    </div>
    <table class="mt-4 text-sm w-full">
      <thead>
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">User</th>
          <th class="px-4 py-2">type</th>
          <th class="px-4 py-2">Rented From</th>
          <th class="px-4 py-2">Rented To</th>
          <th class="px-4 py-2">Rented Months</th>
          <th class="px-4 py-2">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="property in filteredProperties" :key="property.id">
          <td class="border px-4 py-2 text-center">{{ property.id }}</td>
          <td class="border px-4 py-2 text-center">{{ property.name }}</td>
          <td class="border px-4 py-2 text-center">{{ getUserName(property.userId) }}</td>
          <td class="border px-4 py-2 text-center">{{ getType(property.typeId) }}</td>
          <td class="border px-4 py-2 text-center">{{ property.rentedFrom ? formatDate(property.rentedFrom) : '-' }}</td>
          <td class="border px-4 py-2 text-center">{{ property.rentedTo ? formatDate(property.rentedTo)   : '-' }}</td>
          <td class="border px-4 py-2 text-center">{{ property.rentedFrom ? getRentedMonths(property)  : '-' }}</td>
          <td :class="getStatus(property) ? 'border px-4 py-2 text-center text-red-700' : 'border px-4 py-2 text-center text-green-600'">{{ getStatus(property) ? 'Occupied' : 'Available' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    properties: Array,
    propertyTypes: Array,
    users: Array,
  },
  data() {
    return {
      search: '',
    };
  },
  computed: {
    filteredProperties() {
      let filtered = this.properties;
      if (this.search !== '') {
        filtered = filtered.filter((property) => {
          const user = this.getUserName(property.userId);
          const type = this.getType(property.typeId);
          return (property.name.toString().toLowerCase().indexOf(this.search.toLowerCase()) > -1
          || user.toLowerCase().indexOf(this.search.toLowerCase()) > -1
          || type.toLowerCase().indexOf(this.search.toLowerCase()) > -1);
        });
      }
      return filtered;
    },
  },
  methods: {
    getUserName(userId) {
      const findUser = this.users.find((user) => user.id === userId);
      return findUser.name;
    },
    getType(typeId) {
      const findType = this.propertyTypes.find((type) => type.id === typeId);
      return findType.name;
    },
    formatDate(date) {
      return date ? this.$moment(date).format('DD/MM/YYYY') : null;
    },
    getStatus(property) {
      const to = this.$moment(property.rentedTo);
      const now = this.$moment(new Date());
      if (!property.rentedTo && property.rentedFrom) return true;
      if (!property.rentedTo && !property.rentedFrom) return false;
      if (now.isAfter(to)) return false;
      return true;
    },
    getRentedMonths(property) {
      if (!property.rentedFrom) return null;
      const from = this.$moment(property.rentedFrom);
      const to = property.rentedTo ? this.$moment(property.rentedTo) : this.$moment(new Date());
      const months = to.diff(from, 'months');
      return months;
    },
  },
};
</script>

<style>

</style>
