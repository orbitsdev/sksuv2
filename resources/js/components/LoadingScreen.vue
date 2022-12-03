



<template>

    <div class="loader-parent">
        <div class="loader"></div>
</div>

</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

.loader-parent{
    display: flex;
    justify-content: center;
    align-items: center;
    padding:0;
    position: relative;
    min-height: 100vh;
    min-width: 100%;
    background: white;
    z-index: 2000;
}
.loader {
    border: 5px solid #dcdee2; /* Light grey */
    border-top: 5px solid #369763; /* Blue */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 800ms linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>