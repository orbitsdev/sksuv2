<template>
    <div class="dialogparent">

        <w-dialog 
    @close="this.$emit('close')"
        
    v-model="show" 
    :title="title" 
    
    :width="width" 
    :transition="transition" 
    :persistent="preventClose"
    dialog-class="dialog-wrapper m-0 " 
    overlay-color="rgba(0,0,0,0.5)" 
    title-class="text-lg text-green-600" 
     >
    <slot name="c-content">
       
    </slot>

  <div class="  flex justify-center items-center " >
    <slot name="c-actions" >

    </slot>

  </div>
  
  
</w-dialog>
</div>
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
            preventClose: {    
                type: Boolean,
                default: false,
                required:false,
            }



        }
    
    }
</script>

<style scoped>





.dialogparent{
    z-index: 1000;
}

</style>