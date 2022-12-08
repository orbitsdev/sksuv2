

<template>
   <div class="p-4 bg-white flex justify-between items-center">
    <div><slot name="search-area"></slot></div>    
    <div><slot name="filters-area"></slot></div>    
    <div><slot name="actions-area"></slot></div>    
   </div>
</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

</style>