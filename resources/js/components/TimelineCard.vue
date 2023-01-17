

<template>
    <div
    class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-violet-400"
  >
    <h3 class="text-lg font-semibold tracking-wide">
      SBO ADVISER
    </h3>
    <div class="mt-1   flex items-center">
      <p class="text-xs">Submitted   - <span class="text-xs text-gray-500">
          Dec 21, 2023
      </span> </p>
    </div>
    <div class="mt-1   flex items-center">
        <i class="mr-1 text-xs text-green-500 fa-solid fa-circle-check"></i>
        <p class="text-xs">Approved  <span class="text-xs text-gray-500">
            Dec 21, 2023
        </span> </p> 
    </div>
    <div class="mt-1   flex items-center">
      <p class="text-xs">Endorsed by - Kate Maria Terisa </p>
      <span class="text-xs text-gray-500">
        Dec 21, 2023
    </span> 
    </div>
   
  </div>
</template>

<script>
    export default {
        
        props: ['approver-role', 'submit_date','status_', ]
    
    }
</script>

<style  scoped>

</style>