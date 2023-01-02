<template>
  <div class="relative">
    <TableLoader v-if="isFetching" />
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th v-for="(th, index) in thdata" :key="index"
            scope="col" class="py-2.5 text-left text-sm font-semibold text-gray-900">
            {{ th }}
          </th>

        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <slot name="data">
         
        </slot>

        <!-- More people... -->
      </tbody>
    </table>
    <slot name="ac"></slot>
  </div>
</template>

<script>
export default {
  props: {
    isFetching: {
      type: Boolean,
      default: false,
    },
    thdata: {
      type: Array,
      required: false,
      default: ["Name", "Title", "Status", "Roles", ""],
    },
  },
};
</script>

<style scoped></style>
