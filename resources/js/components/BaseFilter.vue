

<template>

  <div class="flex ">
    <select
    class="block hover:shadow-lg  border px-3 py-2 border text-gray-600  placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none  sm:text-sm"> 
      
    <option v-for="(option, index) in options" :key="index"  class="py-2" value="a"> {{ option }}</option>
    
  </select>
</div>

      
</template>

<script>
    export default {
        props: {
          
          options: {
            type: Array,
            default: ['Vue', 'Flutter', 'Laravel'],
          },

          placeholder: {
            type: String,
            default: '', 
          },
        },
    }
</script>

<style  scoped>

</style>