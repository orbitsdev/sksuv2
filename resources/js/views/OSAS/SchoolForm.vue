<template>
  <div>
    <FormHeader>Add School</FormHeader>
    <div class="pt-5">
      <BaseInput :label="'School Name'" />
    </div>
    <div class="pt-2">
      <label for="cover-photo" class="block text-base font-medium text-gray-700"
        >Features Image</label>
      <FilePondBase class="mt-2" />
      
    </div>
    <div class="pt-2">
      <div class="flex justify-end">
        <BaseSpinner />
        <button
          type="button"
          class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Close
        </button>
        <button
          type="submit"
          class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        files: [],
      },
    };
  },
};
</script>

<style scoped></style>
