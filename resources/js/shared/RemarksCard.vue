

<template>
    <div class="relative">
        <div class="absolute top-1 right-1">
                <p :class="[' font-bold p-1  rounded' , active ? 'text-white' : '']  ">
                    #{{index}}
                </p>
        </div>
        <li 
        :class="['cursor-pointer   shadow-lg  pt-4 pb-2 px-4 rounded-lg  leading-4' , active ? 'bg-green-700 text-white' : 'hover:bg-gray-100  transition-all ease-out mb-4']">
            <p class="py-2 text-sm">                
                    {{ message }}
            </p>
            <div class="flex justify-end items-center  ">
              <p :class="['text-xs ', active ? 'text-gray-200' : 'text-gray-400']">                     {{ date }}</p>
            </div>
          </li>
    </div>
</template>

<script>
    export default {


        props: {
            index: {
                type: String,
            },
            message: {
                type: String,
            },
            date: {
                type: String,
            },
            
            active: {
                type: Boolean,
                default: false,
            },

        },
    }
</script>

<style lang="scss" scoped>

</style>