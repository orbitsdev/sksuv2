

<template>


    <teleport to="#app">
        <BaseDialog
          :show="show"
          :width="'360'"
          :preventClose="true"
          class="h-96 bg-red-200"
        >
          <template #c-content>
            <div class="flex items-center jusity-center flex-col ">
              <h1 class="font-rubik text-center text-3xl font-bold uppercase mb-1 text-rose-600"> Error! </h1>
              <h1 class="w-14 h-2 bg-rose-600 h-1 "> </h1>
            </div >
                <div class="my-6 text-center  text-gray-500 text-base leading-5 font-rubik ">
                  <slot> Oops! It seems like there was an error on your request . Please Contact the developer or try again.</slot>
                </div>

                <div class="px-2 mt-4 flex justify-center  w-full items-center">
                  <button

                  @click="$emit('close')"
                   
                    type="button"
                    class="font-rubik flex w-full items-center justify-center rounded-lg border border-green-600 bg-green-700 text-white text-lg  px-4 py-2 text-sm font-semibold hover:text-white hover:shadow-lg hover:bg-green-800 focus:outline-none "
                  >
                   Got It
                  </button>

                </div>
          </template>
        </BaseDialog>
      </teleport>
</template>

<script>
    export default {
        props: {
            show: {
                type: Boolean,
                default: false,
            },
        },
        imits: 'close'
        
        
    }
</script>

<style lang="scss" scoped>

</style>