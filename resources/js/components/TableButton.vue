<template>
  <button
  v-if="!mode"
    type="button"
    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none sm:w-auto"
  >
    <slot> Click Me </slot>
  </button>
  <button
  v-else
    type="button"
    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none sm:w-auto"
  >
    <slot> Click Me </slot>
  </button>
</template>

<script>
export default {
  props: {
    mode:{
      type: Boolean,
      default: false,
    }
  }
};
</script>

<style scoped></style>
