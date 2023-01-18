

<template>
    <div>
        <h3 class="text-lg font-extrabold leading-6" v-if="application != null">
            {{ application }}
            
            Application Title
          </h3>
          <p class="mt-1 max-w-2xl text-sm font-bold">General Information</p>

          
    </div>
</template>

<script>
    export default {
        props: ['data'],
 
        data() {
            return {
                application: null,
                isSaving: false,
            }
        },

        methods: {
            
        }
    }
</script>

<style  scoped>

</style>