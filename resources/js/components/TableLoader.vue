

<template>
    <div>

        <span class="loader"></span>

    </div>
</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

div{

    padding: 20px;
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: hsl(0, 0%, 90%,0.60);
    z-index: 1000;
}


.loader {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: block;
    margin:15px auto;
    position: relative;
    color: #FFF;
    left: -100px;
    box-sizing: border-box;
    animation: shadowRolling 2s linear infinite;
  }
  
  @keyframes shadowRolling {
    0% {
      box-shadow: 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0);
    }
    12% {
      box-shadow: 100px 0 #16A34A, 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0);
    }
    25% {
      box-shadow: 110px 0 #16A34A, 100px 0 #16A34A, 0px 0 rgba(255, 255, 255, 0), 0px 0 rgba(255, 255, 255, 0);
    }
    36% {
      box-shadow: 120px 0 #16A34A, 110px 0 #16A34A, 100px 0 #16A34A, 0px 0 rgba(255, 255, 255, 0);
    }
    50% {
      box-shadow: 130px 0 #16A34A, 120px 0 #16A34A, 110px 0 #16A34A, 100px 0 #16A34A;
    }
    62% {
      box-shadow: 200px 0 rgba(255, 255, 255, 0), 130px 0 #16A34A, 120px 0 #16A34A, 110px 0 #16A34A;
    }
    75% {
      box-shadow: 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0), 130px 0 #16A34A, 120px 0 #16A34A;
    }
    87% {
      box-shadow: 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0), 130px 0 #16A34A;
    }
    100% {
      box-shadow: 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0), 200px 0 rgba(255, 255, 255, 0);
    }
  }
</style>