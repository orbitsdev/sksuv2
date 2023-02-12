

<template>
    <aside class=" instruction rounded-lg w-full flex item-center">
        <!-- <div
          class=" rounded-l flex items-center justify-center w-36 "
        >
          <i class="fa-solid fa-wand-magic text-3xl text-white "></i>
        </div> -->
        <div
          class=" rounded-r w-full  px-4 pt-2 pb-4"
        >

            <p class="font-bold text-lg font-rubik text-white uppercase mb-1">  {{ title }} </p>
            <slot>  </slot>
          
        </div>
      </aside>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'Instruction'
            },
            body: {
                type: String,
                default: ''
            },
        }
        
    }
</script>

<style lang="scss" scoped>
.instruction {
    background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgb(10, 129, 64) 0%, rgb(12, 117, 54) 90% );
}
</style>