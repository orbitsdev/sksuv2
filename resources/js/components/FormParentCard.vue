

<template>

    <div class="bg-gray-200 p-4 shadow rounded-lg">
        <div class="flex items-center justify-between mb-2 border-b-4 pb-2 border-gray-900 uppercase">
            <h1 class="text-2xl font-rubik font-semibold leading-7">
              {{ title }} 
            </h1>
            <slot name="action"></slot>
          </div>
          <slot></slot>
    </div>
</template>

<script>
    export default {
        
        props: {
            title: {
                type: String,
                default: 'Title Here',
                
                 
            },
        },
        
    }
</script>

<style lang="scss" scoped>

</style>