<template>
    <w-dialog 
    v-model="show" 
    :title="title" 
    :width="width" 
    persistent
    :transition="transition" 
    dialog-class="dialog-error" 
    overlay-color="rgba(0,0,0,0.5)" 
    title-class="text-lg text-green-600" 
     >
    <slot name="c-content">
    </slot>
  <div class=" my-3 flex justify-center items-center " >
    <slot name="c-actions" >

    </slot>

  </div>
  
  
</w-dialog>
</template>

<script>
    export default {

        imits: ['close'],
        props: {
            show: {
                type: Boolean,
                required: false,
                default: false,
            },

            
            title: {
                type: String,
                required: false,
                default: '',
            },
            width: {
                type: String,
                required: false,
                default: '360',
            },
            transition: {
                type: String,
                default: 'slide-fade-down',
            },



        }
    
    }
</script>

<style scoped>



.c-container{
    background: red;
}

</style>