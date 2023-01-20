<template>

    <div class="ldp">

        <div class="shapes"></div>
    </div>

  
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
.ldp{

    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 200;
    background: rgba(197, 196, 203, 0.1);
}

.shapes {
   width: 24.8px;
   height: 24.8px;
   color: #12542f;
   background: linear-gradient(currentColor 0 0),
          linear-gradient(currentColor 0 0),
          linear-gradient(currentColor 0 0),
          linear-gradient(currentColor 0 0);
   background-size: 18.4px 18.4px;
   background-repeat: no-repeat;
   animation: shapes-53h9rpmd 1.5s infinite cubic-bezier(0.3,1,0,1);
}

@keyframes shapes-53h9rpmd {
   0% {
      background-position: 0    0,100% 0   ,100% 100%,0 100%;
   }

   33% {
      background-position: 0    0,100% 0   ,100% 100%,0 100%;
      width: 47.2px;
      height: 47.2px;
   }

   66% {
      background-position: 100% 0,100% 100%,0    100%,0 0;
      width: 47.2px;
      height: 47.2px;
   }

   100% {
      background-position: 100% 0,100% 100%,0    100%,0 0;
   }
}
</style>

