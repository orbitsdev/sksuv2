

<template>
  <div class="spinner"></div>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
.spinner {
  width: 56px;
  height: 56px;
  --c: radial-gradient(farthest-side,#166534 92%,#0000);
  background: var(--c) 50% 0,
         var(--c) 50% 100%,
         var(--c) 100% 50%,
         var(--c) 0    50%;
  background-size: 13.4px 13.4px;
  background-repeat: no-repeat;
  animation: spinner-kh173p 1s infinite;
}

@keyframes spinner-kh173p {
  to {
     transform: rotate(.5turn);
  }
}
      
</style>