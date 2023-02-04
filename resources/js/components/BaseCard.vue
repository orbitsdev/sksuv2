

<template>
    <div class="w-full min-h-full bg-white shadow rounded-sm  p-4 ">
        
        <h2 v-if="!!title" class="text-2xl text-gray-300   ">
            {{ title }}
        </h2>
        <h3 v-if="!!subtitle" class="font-rubik text-2xl font-semibold text-green-700 uppercase ">
            {{ subtitle }}
        </h3>
        <slot name="header">
            <!-- <div class=""> 
                <p class="py-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo nulla dicta saepe illum debitis sed ducimus corrupti voluptates iste quasi deserunt, tempore suscipit accusamus blanditiis, perspiciatis autem iusto ullam harum? </p>

            </div> -->
        </slot>
        <slot >
            <!-- Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea laudantium qui recusandae ullam porro beatae ex dicta autem, error consequuntur! Soluta eius aut laborum repudiandae obcaecati quibusdam eaque! Consectetur, excepturi! -->
        </slot>
    </div>
</template>

<script>
    export default {

        props: {

            title:{
                type:String,
                required: false,
                default: ''
            },
            
            subtitle: {
                type: String,
                default: '',
                required: false,
            },
            
        },
        
    }
</script>

<style scoped>

</style>