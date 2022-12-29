

<template>
    <div classs=" ">
        <p class="text-center "> {{ label }}</p>
        <div class="text-center">
          <slot></slot>
        </div>
      </div>
</template>

<script>
    export default {
       props: ['label'] 
    }
</script>

<style  scoped>

</style>