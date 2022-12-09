

<template>
   <div class="flex justify-between py-2  my-2">
       <div class="flex "><slot name="searchs-area"></slot></div>    
       <div class="flex justify-center "><slot name="filters-area"></slot></div>    
       <div class="flex justify-end "><slot name="actions-area"></slot></div>    
   </div>
</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

</style>