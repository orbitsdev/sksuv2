

<template>
 
   
    <h1 tabindex="0" class="focus:outline-none text-center text-gray-800  text-xl font-bold tracking-normal leading-tight mb-4"> {{title}}</h1>
    <p tabindex="0" class="focus:outline-none mb-5 text-base text-gray-600 text-center font-normal  ">  {{ message }}</p>
    <div class="grid grid-cols-2 gap-x-6">

        <slot>


        </slot>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type:String,
                
            },
            message: {
                type:String,
                
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>