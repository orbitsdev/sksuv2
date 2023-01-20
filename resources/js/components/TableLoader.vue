

<template>
    <div class="ldp">

      <div class="loader"></div>

    </div>
</template>

<script>
    export default {
        
    }
</script>

<style  scoped>

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

.loader,
.loader:before,
.loader:after {
  background: #12542f;
  -webkit-animation: load1 700ms infinite ease-in-out;
  animation: load1 700ms infinite ease-in-out;
  width: 6px;
  height: 3px ;
}
.loader {
  color: #12542f;
  text-indent: -9999em;
  margin: 88px auto;
  position: relative;
  font-size: 7px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
.loader:before,
.loader:after {
  position: absolute;
  top: 0;
  content: '';
}
.loader:before {
  left: -1.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 1.5em;
}
@-webkit-keyframes load1 {
  0%,
  80%,
  100% {
    box-shadow: 0 0;
    height: 4em;
  }
  40% {
    box-shadow: 0 -2em;
    height: 5em;
  }
}
@keyframes load1 {
  0%,
  80%,
  100% {
    box-shadow: 0 0;
    height: 4em;
  }
  40% {
    box-shadow: 0 -2em;
    height: 5em;
  }
}

</style>