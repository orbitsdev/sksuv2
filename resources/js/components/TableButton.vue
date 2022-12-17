<template>
  <button
  :disabled="disable"
    v-if="!mode"
    type="button"
    class="flex items-center justify-center rounded-lg border border-green-600 bg-green-700 text-white  px-4 py-2 text-sm font-extrabold hover:text-white hover:shadow-lg hover:bg-green-800 focus:outline-none sm:w-auto"
  >
    <slot>Click Me</slot>
  </button>
  <button
  :disabled="disable"
    v-else
    type="button"
    class="flex items-center justify-center rounded-lg border bg-white px-4 py-2 text-sm font-medium text-grey-500 shadow-sm hover:bg-gray-50 hover:shadow-lg focus:outline-none sm:w-auto"
  >
    <slot>Click Me</slot>
  </button>
</template>

<script>
export default {
  props: {
    mode: {
      type: Boolean,
      default: false,
    },
    disable: {
      type: Boolean,
      default: false,
    },
    
  },
};
</script>

<style scoped></style>
