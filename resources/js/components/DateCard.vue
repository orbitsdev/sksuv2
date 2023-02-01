<template>

    <div class="">
        <p class="text-sm font-bold "> <slot name="label">  Officer Submitted </slot> </p>
        <p
          tabindex="0"
          class=" text-xs  focus:outline-none py-1 px-2 italic bg-gray-50 rounded-full inline-block leading-none text-gray-500"
        >
        <slot>

        </slot>
        </p>
      </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>