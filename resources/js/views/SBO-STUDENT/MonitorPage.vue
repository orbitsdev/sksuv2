<template>
  <div>
    <div v-if="isFetching">
      <div class="h-screen flex justify-center items-center">
        <Loader1 />
      </div>
    </div>

    <div v-else>
      

      <div   v-if="applications.length > 0"> 

        <div class="flex justify-between items-center mb-4">
        <div class="relative inline-flex items-center justify-center shadow">
          <i class="absolute fa fa-search text-gray-400 top-5 left-4"></i>
          <input
            v-model="search"
            type="text"
            placeholder="Search"
            class="bg-white h-14 w-full px-12 rounded-lg focus:outline-none hover:cursor-pointer"
            name=""
          />
        </div>
        <div>
          <div class="relative inline-flex items-center justify-center shadow">
            <i class="absolute fa fa-calendar text-gray-400 top-5 left-4"></i>
            <input
              type="date"
              v-model="selectedDate"
              id="datepicker"
              class="bg-white h-14 w-full px-12 rounded-lg focus:outline-none hover:cursor-pointer"
            />
          </div>
        </div>
      </div>
        <ul
      
        role="list"
        class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
      >
        <li
          @click="this.$router.push({ name: 'monitor-app', params: { id: item.id } })"
          v-for="item in applications"
          :key="item.id"
          class="relative p-4 rounded-lg bg-white hover:shadow-lg shadow cursor-pointer"
        >
        <div class="absolute top-0 right-0 rounded-r-lg">
          <button @click.stop="showDeleteConfirmation(item)" class="p-2 cursor-pointer hover:bg-gray-200">
            <i class="text-lg fa-regular fa-trash-can text-gray-800"></i>
            
          </button>
       </div>
          <div class="">
            <div class="">
              <h3 class="leading-4 text-md font-bold tracking-wide uppercase">
                {{ item.application_form.title }}
              </h3>
              <div class="mt-2">
                <p class="text-xs text-gray-400 font-light">
                  Applied -
                  <span class="">
                    {{ formatDate(item.created_at) }}
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="m-2  ">
            <div v-for="approver in item.approvals" :key="approver.id">
              <p>SBO ADVISER</p>
              <p>Kate Rono Mairia Terisa</p>
              <div>
                <div>
                  <p>Pending</p>
                </div>
                <div>
                  <p>Approve</p>
                  <p>
                    {{ formatDate(item.updated_at) }}
                  </p>
                  <p>{{ approver.user.first_name }} {{ approver.user.first_name }}</p>
                </div>
                <div>
                  <p>Denied</p>
                  <p>{{ approver.user.first_name }} {{ approver.user.first_name }}</p>
                </div>
              </div>
            </div>
            
          
        
          </div>
        </li>
      </ul>
      </div>

      
      <EmptyCard
        v-else
        :url="'/assets/undraw_thoughts_re_3ysu.svg'"
        :m="'No Application Is Available'"
      />
    </div>

    <teleport to="#app">
      <BaseDialog :show="selectedResponse != null" :width="'360'" :preventClose="true">
        <template #c-content>
            <div>
              <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <!-- Heroicon name: outline/check -->

                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                
              </div>
              <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">"Delete this response permanently?"
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500"> Please be aware that all files attached to this response will be removed as well.</p>
                </div>
              </div>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-4 ">
              <button type="button" class="ml-1  w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50   sm:col-start-1 sm:mt-0 sm:text-sm" @click="selectedResponse = null">Close</button>
              <div  v-if="isDeleting" class="flex justify-around items-center">
                <BaseSpinner/>

              </div>
              <button v-else type="button" class="mr-1 w-full rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700   sm:col-start-2 sm:text-sm" @click="deleteResponse">Delete</button>
            </div>
        
        </template>
        </BaseDialog>
      </teleport>

  </div>
  
</template>

<script>
import axiosApi from "../../api/axiosApi";
import moment from "moment";

export default {
  data() {
    return {
      search: "",
      isFetching: false,
      applications: [],
      selectedDate: "",
      selectedResponse: null,
      isDeleting: false,
    };
  },

  watch: {
    search(olvalue, newvalue) {
      this.searchResponse();
    },

    selectedDate(newVal) {
      this.fetchData(newVal);
    },
  },

  created() {
    this.getAllApplication();
  },

  methods: {


    async deleteResponse(){

      this.isDeleting = true;

      axiosApi.post('api/monitor-form/searby/delete', {
        id: this.selectedResponse.id
      }).then(res=>{


        this.selectedResponse = null;
          this.getAllApplication();
      }).catch(err=>{
        console.log(err);

      }).finally(()=>{
        this.isDeleting = false;
      });
      
    },

    showDeleteConfirmation(item){


      this.selectedResponse= item;
    },
    async fetchData(date) {
      const month = new Date(date).getMonth() + 1; // getMonth() returns a 0-based index, so we add 1
      const year = new Date(date).getFullYear();


      axiosApi
        .post("api/monitor-form/searby/date", {
          month: month,
          year: year,
        })
        .then((res) => {
          this.applications = res.data.data;
        });
    },

    async searchResponse() {
      await axiosApi
        .post("api/monitor/search", {
          search: this.search,
        })
        .then((res) => {
          this.applications = res.data.data;
        });
    },
    formatDate(date) {
      return moment(date).format("MMM, D YYYY");
    },

    async getAllApplication() {
      this.isFetching = true;

      axiosApi
        .get("api/monitor/response")
        .then((res) => {
          // console.log(res.data.data);

          this.applications = res.data.data;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped>
.animation-pulse::before {
  /*box-shadow: 0 0 0 20px rgba(229,62,62, 0.5);
  transform: scale(0.8);*/
  animation: pulse 2s infinite;
  border-radius: 50% !important;
}

@keyframes pulse {
  0% {
    transform: scale(0.8);
    box-shadow: 0 0 0 0 rgb(23, 192, 37);
  }

  70% {
    transform: scale(0.9);
    box-shadow: 0 0 0 60px rgba(229, 62, 62, 0);
  }

  100% {
    transform: scale(0.8);
  }
}
</style>
