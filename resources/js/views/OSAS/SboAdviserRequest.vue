<template>
  <BaseCard :subtitle="'Request From Users'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton v-if="selectedRequest.length > 0" class="mr-2" @click="showTheForm">
            Confirm selected  ({{ selectedRequest.length}})
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area> 
            <div v-if="isSchoolFetching">
                <BaseSpinner/>
            </div>
            <div v-else>

            
           <select
            v-model="filterBy"
            @change="filterUser"
            class="block hover:shadow-lg border px-3 py-2  text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
          >
          <option :value="'none'"> None</option>
            <option
              v-for="option in schools"
              :key="option.id"
              class="py-2"
              :value="option.name"
            >
              {{ option.name }}
            </option>
          </select>
        </div>
        </template>
        <template #actions-area>
          <!-- <TableButton @click="confirmSelectedRequest" v-if="selectedRequest.length > 0" :mode="true" class="mr-2">
            <i class="fa-regular fa-trash-can mr-2"></i> Selected ({{ selectedRequest.length }}})
          </TableButton> -->
        </template>
      </BaseTableSetup>

      <BaseTable :thdata="['', 'Name', 'University', 'status', '']" :isFetching="isFetching" >
      <template #data>
        <tr v-for="user in users" :key="user.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">

            <input
              v-model="selectedRequest"
              :value="user"
              type="checkbox"
              
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap py-4  text-sm ">
            <div class="flex items-center">
        
              <div class="pl-1">
                <div class="font-medium text-sm text-gray-900"> {{ user.first_name }}  {{ user.last_name }} </div>
              </div>
            </div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div v-if="user.schools.length > 0  ">
              <span >
                {{ user.schools[0].name }}
              </span>
            </div>
            <div v-else >
              <span >
                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">None</span>
              </span>
            </div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
             

         <div v-if="user.sbo_request != null">
                {{ user.sbo_request.status }}
              </div> 
          </td>
          <td
          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
        >
          <button
            :disabled="selectedRequest.length > 0"
            @click="showConfirmation(user)"
            type="button"
            class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
          >
            Confirm
          </button>

        </td>
        </tr>
      </template>
      </BaseTable>

    </template>

  

    <teleport to="#app">
      <BaseErrorDialog
        :show="requestError != null"
        :width="'400'"
        :transition="'slide-fade-down'"
      >
        <template #c-content>
          <RequestError
            :statusCode="requestError.statusCode"
            @close="closeErrorDialog"
            :message="requestError.message"
          />
        </template>
        <template #c-actions> </template>
      </BaseErrorDialog>
    </teleport>

    
    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true" >
        <template #c-content>

          <BaseConfirmation :selectedData="selectedRequest" @close="closeTheForm" :isSaving="isSaving" :title="'Are your sure do you want to make this users as '" :subject="'Sbo-Adviser'">
            <TableButton class="mr-2" @click="confirmSelectedRequest"> Yes </TableButton>
          </BaseConfirmation>
           
        </template>
      </BaseDialog>
    </teleport>


    <teleport to="#app">
      <BaseDialog :show="showConfirm" :width="'500'" :preventClose="true" >
        <template #c-content>

          <BaseConfirmation  @close="showConfirm = false" :isSaving="isConfirming" :title="'Are your sure do you want to make this users as '" :subject="'Sbo-Adviser'">
            <template #data>
              <div  class="bg-gray-100 text-xs italic p-1 my-1 rounded-sm" >
                {{ selectedUser.first_name }} {{ selectedUser.last_name  }} -  <span v-if="selectedUser.schools != null && selectedUser.schools.length > 0    "> {{selectedUser.schools[0].name }}</span> <span v-else> Unknown  </span>
              </div>
            </template>
            <TableButton class="mr-2" @click="confirmRequest"> Yes </TableButton>
            
        
          </BaseConfirmation>
           
        </template>

        
      </BaseDialog>
    </teleport>

    <!-- <teleport to="#app">
      <BaseDialog :show="isConfirming" :width="'300'">
        <template #c-content>
          <div class="flex justify-center items-center">
            <BaseSpinner class="mx-2" />
            <p class="text-lg">Confirming request...</p>
          </div>
        </template>
      </BaseDialog>
    </teleport> -->
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  created() {
    this.loadUser();
    this.loadSchool();
  },
  data() {
    return {
      showConfirm: false,
      showForm: false,
      search: "",
      users: [],
      isFetching: false,
      isSchoolFetching: false,
      isConfirming: false,
      filterBy: 'none',
      selectedRequest: [],
      selectedUser: null,
      schools: [],
      requestError:null,
    };
  },
  watch: {
    search(oldeValue, newValue) {
      this.searchUser();
    },
  },
  methods: {



    showTheForm(){
      this.showForm = true;
    },

    closeTheForm(){
      this.showForm = false;
    },

    closeErrorDialog() {
      this.requestError = null;
    },

    
    async confirmSelectedRequest(){

      const selectedId = [];
     this.selectedRequest.forEach(user => {
        selectedId.push(user.id);
     });
     
      this.isConfirming = true;
        axiosApi.post('api/sbo-requests/confirm-selected-request',{
        userid: selectedId,
        }).then(res=>{
            console.log(res.data);
            this.loadUser();
            this.showForm = false;
            this.selectedRequest = [];
        }).catch(err=>{
          this.requestError = err;
        }).finally(()=>{
          this.isConfirming = false;
        });
    },

    showConfirmation(user){
      this.selectedUser = user;
      this.showConfirm = true;

    },
    

    async confirmRequest(user){
      
      
      this.isConfirming = true;
        axiosApi.post('api/sbo-requests/confirm',{
          id: this.selectedUser.id
        }).then(res=>{
            console.log(res.data);
            this.showConfirm = false;
            this.selectedUser = null;
            this.loadUser();
        }).catch(err=>{
          this.requestError = err;
        }).finally(()=>{
          this.isConfirming = false;
        });
    },

    async filterUser() {

      await axiosApi
        .post("api/current-sbo-advisers/filter", {
          filter: this.filterBy,
        })
        .then((res) => {
          this.users = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        });
    },
    async searchUser(){
      await axiosApi.post('api/sbo-requests/search', {
        search: this.search,
        filter:this.filterBy,
      }).then(res=>{
        this.users= res.data.data;
      });
    },

    async loadSchool() {
      this.isSchoolFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;
          if (this.schools.length > 0) {

          }
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },
    async loadUser() {
      this.isFetching = true;
      await axiosApi
        .get("api/sbo-requests")
        .then((res) => {
          console.log(res);
          this.users = res.data.data;
        })
        .catch((err) => {
          console.log(err);
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
