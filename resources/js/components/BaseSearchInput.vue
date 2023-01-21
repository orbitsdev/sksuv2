<template>
  <div class="hover:shadow-lg flex border ">

    <div class="flex  justify-center border-r items-center">
      <svg
      class="h-5 w-8 text-gray-700 mx-1 "
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 20 20"
      fill="currentColor"
      aria-hidden="true"
      >
      <path
      fill-rule="evenodd"
      d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
      clip-rule="evenodd"
      />
    </svg>

    </div>

    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="block py-2 px-2 text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
      :placeholder="placeholder"
    />
   
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },

    placeholder: {
      type: String,
      default: "Search ...",
    },
  },
};
</script>

<style scoped></style>
