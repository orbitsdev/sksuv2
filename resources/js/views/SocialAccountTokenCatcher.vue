


<template>

    <LoadingScreen/>
</template>

<script>
    export default {
        created () {
            this.loginUser();
        },
        methods: {
            loginUser(){
                localStorage.setItem('token', this.$route.query.code);
                if(localStorage.getItem('token')){
                    
                     window.location.reload(true);
                }
            }
        }        
    }
</script>

<style  scoped>

</style>