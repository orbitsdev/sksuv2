



<template>

    <div class="loader-parent">
      <div class="box  mt-5"> 
        <div class="loader "></div>
      </div>
      <div class="box ">
       <h1 class="mt-3 text-xs">  


       </h1>
        </div>
      
</div>

</template>

<script>
    export default {
        props: {
        text: {
            type: String,
            default: 'Loading...',
             required: true,
          },
        },
    }
</script>

<style  scoped>

img{
  width: 140px;
  height: auto;
}

.loader-parent{
    display: flex;
    justify-content: center;
    align-content: center;
    flex-flow: column;
    padding:0px 10%;
    position: relative;
    min-height: 100vh;
    min-width: 100%;
    background: white;
    z-index: 2000;
}

.loader-parent .box{

  display: flex;
  justify-content: center;


}
.loader {
    border: 5px solid #dcdee2; /* Light grey */
    border-top: 5px solid #369763; /* Blue */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 600ms linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>