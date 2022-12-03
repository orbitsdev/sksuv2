<template>
    <div>
        <Vue3Lottie :animationData="LottieFile" :height="200" :width="200" />
            <div class="flex justify-center"><p class="text-red-600 text-4xl bold "> {{ statusCode }}</p></div>
        <p class="mt-3 text-center text-2xl">
            
            {{ message }}

        </p>
        <div class="flex justify-center mt-4">
            <SquareButton @click="$emit('close')" :mode="'alert'"> Ok </SquareButton>
        </div>
    </div>
</template>

<script>

import LottieFile from '../../../public/assets/error.json';
    export default {
        imits: ['close'],

        props: {
            statusCode: {
                type: String,
                default:'404',
            required: false
            },
            message: {
                type: String,
                default:'Error Occure',
                required: false
            },
            
        },

        data() {
            return {
                LottieFile
            }
        },
    }
</script>

<style  scoped>

</style>