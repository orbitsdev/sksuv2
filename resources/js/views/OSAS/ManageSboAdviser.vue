<template>
<main>
  <!-- <Path :path="this.$route.path"/> -->
  
 <div class="mb-3">
  <router-link
  :to="{ name: 'manage-sbo-adviser-user' }"
  class=" py-1 text-gray-400 text-sm mr-1  "
> Users  <span class="text-xs"> | </span>   </router-link>   
  <router-link
  :to="{ name: 'manage-sbo-adviser-request' }"
  class=" py-1 text-gray-400 text-sm mr-1 "
> Request  <span class="text-xs"> | </span> </router-link>   
  <router-link
  :to="{ name: 'manage-sbo-adviser-adviser' }"
  class=" py-1 text-gray-400 text-sm mr-1 "
> SBO Advisers </router-link>

 </div>

  <router-view></router-view>
  
</main>
</template>

<script>

export default {

  created(){
    this.$router.push({name: 'manage-sbo-adviser-user'})
  }
}

</script>

<style scoped>
.router-link-active {
  color: #15803D !important;
  font-size: 15px !important;
  font-weight: 600 !important;
}


</style>
