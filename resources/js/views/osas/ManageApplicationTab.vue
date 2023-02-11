

<template>

    <TabCard> 
  
      <router-link :to="{ name: 'manage-requirement' }" class="block  rounded-b-lg  text-gray-600  text-sm focus:z-10 py-6 leading-4 text-center flex-1 items-center text-center  font-rubik text-lg  border-b-4 border-grey-100  ">
        <span>Application Requirements</span>
  
      </router-link>
  
      <router-link :to="{ name: 'manage-application' }" class="block  rounded-b-lg  text-gray-600  text-sm focus:z-10 py-6 leading-4 text-center flex-1 items-center text-center  font-rubik text-lg  border-b-4 border-grey-100  ">
        <span>Appication Forms</span>
  
      </router-link>

  
     

  
      
    </TabCard> 
    <router-view> </router-view>
          <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
        
  </template>
  
  <script>
      export default {
          
      }
  </script>
  
  <style lang="scss" scoped>
  
.router-link-exact-active{
    border-bottom: 4px solid !important;
    border-color: rgb(206, 206, 13)!important;
    color: white !important;
    background:#15803d ;
  
  }
  
  </style>