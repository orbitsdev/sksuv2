<template>
  <div>




    <ul
      role="list"
      class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
    >
      <div
        class="group col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow" v-for="item in applications" :key="item.id"
      >
        <div class="flex flex-1 flex-col p-8 relative cursor-pointer group hvp">
          
            <img
            class="mx-auto h-42 w-42 flex-shrink-0"
            src="/assets/undraw_my_documents_re_13dc.svg"
            alt=""
          />

          <h3 class="mt-6 text-sm font-bold text-gray-900 capitalize">
            {{ item.title}}
          </h3>

          <div class="requirement absolute top-4 right-2" v-if="item.requirements.length">
            <p class="px-2 py-1 bg-gradient-to-l from-emerald-900 to-emerald-600 text-white text-xs  rounded-full">
                Requirement {{ item.requirements.length }}
             </p>
        </div>

          <button
            @click="fillUpForm(item)"
            class="flex justify-center items-center hover:backdrop-blur-sm cursor-pointer rounded-md hv"
          >
            <div class="flex justify-center items-center">
              <i class="fa-regular fa-rectangle-list mr-2 text-2xl text-white"></i>
              <p class="text-2xl text-white">Fill-Up Now</p>
            </div>

          
          </button>
        </div>
      </div>
      <!-- More people... -->
    </ul>

    <teleport to="#app">
      <BaseErrorDialog
        :show="requestError != null"
        :width="'400'"
        :transition="'slide-fade-down'"
      >
        <template #c-content>
          <RequestError
            :statusCode="requestError.statusCode"
            @close="requestError = null"
            :message="requestError.message"
          />
        </template>
        <template #c-actions> </template>
      </BaseErrorDialog>
    </teleport>
  </div>
</template>

<script>
import { parse } from 'filepond';
import axiosApi from "../../api/axiosApi";
export default {

   
    data() {
        return {
            isFetching:false,
            applications : [],
            requestError: null,
        }
    },

    created () {

        this.getApplications();
        
    },

    methods: {

       
        async fillUpForm(item){ 

            console.log(item);



 


            this.$router.push({name: 'take-application', params: {applicationId: item.id, title: item.title}});

             // this.$router.push({name:'take-application', paramns: {applicationId: item.id, title: item.title}}  );

        },

        async getApplications(){
            this.isFetching = true;

           await axiosApi.get('api/manage-applications').then(res=>{

            console.log(res.data.data);
            this.applications = res.data.data;

           }).catch(err=>{
                this.requestError = err;
           }).finally(()=>{
            this.isFetching = false;
           })
        }

    
    }
 
};
</script>

<style scoped>
.hvp .hv {
  display: none !important;
}

.hvp:hover .hv {
  display: flex !important;
  position: absolute;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background: rgba(16, 116, 84, 0.70);
  transition: all 0.3s ease-out;
}
</style>
