

<template>
    <div class="flex justify-center items-center">
        <div class="flex flex-col items-center justify-center">
            
            
            <img :src="url" class="mt-4">
            <h1 class="text-lg font-bold mt-8 font-rubik text-green-700"> {{m}} </h1>
        
        </div>
    </div>
</template>

<script>
    export default {
        
        props: {
            url:{
                required:false,
                type:String,
                default: '/assets/undraw_no_data_re_kwbl.svg'
            },
        
            m:{
                type:String,
                default: 'No Results Found',
                required: false,
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