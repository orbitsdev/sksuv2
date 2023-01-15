

<template>
    <div class="flex justify-center items-center">
        <div class="flex flex-col items-center justify-center">
            
            
            <img :src="url" class="mt-4">
            <h1 class="text-lg font-bold mt-8"> {{m}} </h1>
        
        </div>
    </div>
</template>

<script>
    export default {
        
        props: {
            url:{
                type:String
            },
        
            m:{
                type:String,
                default: 'Not Found',
                required: true,
            },
        

        }

    }
</script>

<style  scoped>
img{
    width:200px;
    height:200px
}
</style>