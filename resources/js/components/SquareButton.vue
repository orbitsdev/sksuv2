<template>


     <button :class="['inline-flex  items-center justify-center whitespace-nowrap rounded-md border border-transparen px-4 py-2 text-base font-medium text-white shadow-sm ', mode=== 'alert' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700'
     ]">
        <slot> My Custom Buttin</slot>
    </button>
</template>

<script>
    export default {
        props: {
            mode: {
                type: [String , Number],
                default: null,
                required: false,
            },
        },
    }
</script>

<style  scoped>


</style>