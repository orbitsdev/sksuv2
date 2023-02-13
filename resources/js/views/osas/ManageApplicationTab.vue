

<template>

    <InstructionCard class="mb-4 shadow pulse" :title="'Note '">
      
        <p index="40px" class="text-white font-rubok text-base font-semibold">
         -  Requirement can be attach to application form.  
        </p>
        <p index="40px" class="text-white font-rubok text-base font-semibold">
          -  Deleting application form will affect all data that attached to it.   
        </p>

      </InstructionCard> 
    <TabCard> 
  
      <router-link :to="{ name: 'manage-requirement' }" class="block  rounded-t-lg  text-gray-600  text-sm focus:z-10 py-4 leading-4 text-center px-6 items-center text-center  font-rubik text-lg  border-b-4 border-grey-100  ">
        <span>Checklist</span>
  
      </router-link>
  
      <router-link :to="{ name: 'manage-application' }" class="block  rounded-t-lg  text-gray-600  text-sm focus:z-10 py-4 leading-4 text-center px-6 items-center text-center  font-rubik text-lg  border-b-4 border-grey-100  ">
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