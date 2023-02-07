

<template>
    <div class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4">
        <h1 class="text-lg font-bold font-rubik mb-2 uppercase"> {{title }}</h1>
        <h1 class="text-lg font-bold font-rubik mb-2 uppercase">University</h1>
        <slot> </slot>
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