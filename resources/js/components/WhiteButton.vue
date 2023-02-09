

<template>
    <button
    :disabled="disable"
      type="button"
      class="flex items-center justify-center rounded-lg border bg-white px-4 py-2 text-sm font-medium text-grey-500 shadow-sm hover:bg-gray-50 hover:shadow-lg focus:outline-none "
    >
      <slot>Click Me</slot>
    </button>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>