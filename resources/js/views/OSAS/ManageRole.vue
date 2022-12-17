<template>
  <BaseCard :subtitle="'Mange Users Roles'">
    <template #header>
      <BaseTableSetup >
        <template #searchs-area>
          <TableButton v-if="selectedUsers.length" class="mr-2" @click="showRolesForm = true">
            Update 
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area>
          <div v-if="isSchoolFetching">
            <BaseSpinner />
          </div>
          <div v-else>
            <select
              v-model="filterBy"
              @change="filterUser"
              class="block hover:shadow-lg border px-3 py-2 text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
            >
              <option :value="'none'">None</option>
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
        <template #actions-area></template>
      </BaseTableSetup>
      <BaseTable :thdata="['', 'Name',  'Email', 'Roles' ,'University', '']" :isFetching="isFetching">
        <template #data>

          <tr v-for="user in users" :key="user.id" >
            <td class="relative w-12 px-6 sm:w-16 sm:px-8">

              <input 
                v-model="selectedUsers"
              :value="user"
              type="checkbox" class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600  text-white rounded border-gray-200  sm:left-6">
            </td>
            <td class="  text-sm ">
              <div class="flex items-center">
                <div class="h-6 w-6 flex-shrink-0">
                  <img class="h-6 w-6 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
                <div class="ml-4">
                  <div class="font-medium text-gray-900">{{user.first_name.toUpperCase()}} {{user.last_name.toUpperCase()}}</div>
                  <!-- <div class="text-gray-500">lindsay.walton@example.com</div> -->
                </div>
              </div>
            </td>
            <td class="py-2 text-sm text-gray-500">
              <div class="text-gray-500">{{ user.email }}</div>
            </td>
            
            <td class="py-2 text-sm text-gray-500">
              <div v-if="user.roles.length > 0" class="inline-flex">
                <p v-for="role in user.roles" :key="role.id" >
                  <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5">{{ role.name }}</span>
                </p>
              </div>
              <div v-else>
                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">None</span>
              </div>
            </td>
            <td class="whitespace-nowrap py-2 text-sm text-gray-500">
              <div v-if="user.schools.length > 0">
                <span>
                  {{ user.schools[0].name }}
                </span>
              </div>
              <div v-else>
                <div class="text-gray-500">None</div>
              </div>
            </td>

            <td>
              <!-- <button
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
            <i class="fa-regular fa-pen-to-square"></i>
            </button> -->
            </td>
            
          
          </tr>
          <!-- <tr v-for="user in users" :key="user.id">
            <td class="relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                v-model="selectedUsers"
                :value="user"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
              />
            </td>
            <td class="whitespace-nowrap py-4">
              <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                  <img
                    class="h-10 w-10 rounded-full"
                    src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt=""
                  />
                </div>
                <div class="ml-4">
                  <div class="font-medium text-gray-900">
                    {{ user.first_name + " " + user.last_name }}
                  </div>
                 
                </div>
              </div>
            </td>
            <td>
               <div class="text-gray-900">{{ user.email }}</div>
            </td>
            <td>

                  <div v-if="user.roles.length > 0">
                      <div v-for="role in user.roles" :key="role.id" class="text-gray-900">
                        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ role.name }}</span>
                  </div>
                    </div>
              <div v-else>
                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">None</span>

              </div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div v-if="user.schools.length > 0">
                <span>
                  {{ user.schools[0].name }}
                </span>
              </div>
              <div v-else>
                <span>
                  <span
                    class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                    >None</span
                  >
                </span>
              </div>
            </td>
            <td
              class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            ></td>
          </tr> -->
        </template>
      </BaseTable>
    </template>


    
    <teleport to="#app">
      <BaseDialog :show="showRolesForm" :width="'500'" :preventClose="true" >
        <template #c-content>          
          <p class="text-base font-bold">Choose Roles  </p>
          <w-divider class="my6"></w-divider>
          <div v-if="isRoleFetching" class="flex justify-center my-4">
            <BaseSpinner  />
          </div>
          <div  v-else class="grid p-2 grid-cols-3 gap-1">
            <div v-for="role in roles" :key="role.id" >
              <div class="flex items-center inline-block  p-1  ">
                <input type="checkbox" :value="role.id" class="w-4 h-4 accent-green-600  text-white mr-1 border-blue-700 border-2 cursor-pointer" :id="role.id" v-model="selectedRoles">
                <label :for="role.id" class="mr-1 "> {{ role.name }} </label>
              </div>
            </div>
          </div>
          <w-divider class="my6 "></w-divider>
          <div>
            <div class="mt-1">
              <p class="text-base font-bold">Selected Users</p>
            </div>
            <p class="bggray2 rounde text-xs font-light italic mt-1 p-1" v-for="user in selectedUsers " :key="user.id" > <span class="">{{user.first_name.toUpperCase()}}  {{user.last_name.toUpperCase()}}</span>   </p>
          </div> 
          
          <w-divider class="my6 my-2"></w-divider>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showRolesForm = false"> Close </TableButton>
           <div class="my-1 mx-2" v-if="isSaving">
             <BaseSpinner />
           </div>
            <div v-else>
              <TableButton  v-if="selectedRoles.length > 0" class="" @click="changeUsersRoles">  Confirm </TableButton>
            </div>
          </div>
          
          
           
        </template>

        
      </BaseDialog>
    </teleport>

    <!-- error dialog -->
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
      <BaseDialog :show="showConfirmationDialog" :width="'500'" :preventClose="true" >
        <template #c-content>

          <h1 class="font-bold">  Are Your Sure? Do you want to change roles of the following users ?   </h1>

          <w-divider class="my6 my-2"></w-divider>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showRolesForm = false"> Close </TableButton>
           <div class="my-1 mx-2" v-if="isSaving">
             <BaseSpinner />
           </div>
            <div v-else>
              <TableButton  class="">  Yes </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  data() {
    return {
      search: "",
      filterBy: "none",
      users: [],
      schools: [],
      roles:[],
      selectedRoles: [],
      selectedUsers: [],
      isFetching: false,
      isSchoolFetching: false,
      isRoleFetching: false,
      requestError: null,
      isSaving: false,
      showRolesForm: false,
      showConfirmationDialog: false,
    };
  },

  created() {
    this.loadUsers();
    this.loadSchool();
    this.LoadRoles();
  },

  watch: {
    search(olvalue, newvalue) {
      this.searchUser();
    },
  },

  methods: {
    showToast({ title = "Succesfully Saved" }) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },
    async changeUsersRoles(){
      
      const usersid  = [];
      const rolesid = [];
      
      this.selectedUsers.forEach(user => {
        usersid.push(user.id);
      });

      this.selectedRoles.forEach(role => {
        rolesid.push(role);
      });

 
    
      this.isSaving = true;
      await axiosApi.post("api/manage-users-roles/change-role-selected-user",{
        usersid: usersid,
        rolesid: rolesid
      }).then(res=>{
      
        this.selectedUsers = [];
        this.selectedRoles =[];
        this.showRolesForm = false;
        this.loadUsers();
      }).finally(()=>{
        this.isSaving = false;
      });
    },

    async LoadRoles(){
      this.isRoleFetching = true;
      await axiosApi.get("api/roles").then(res=>{
        this.roles = res.data.data;
      }).finally(()=>{
        this.isRoleFetching = false;
      });
    },
    async filterUser() {
     
      await axiosApi
        .post("api/manage-users-roles/filter", {
          filter: this.filterBy,
        })
        .then((res) => {
          console.log(res.data.data);
          this.users = res.data.data;
        });
    },
    closeErrorDialog() {
      this.requestError = null;
    },

    async loadSchool() {
      this.isSchoolFetching = true;
      axiosApi
        .get("api/schools ")
        .then((res) => {
          this.schools = res.data.data;
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },
    async searchUser() {
      await axiosApi
        .post("api/manage-users-roles/search", {
          search: this.search,
          filter: this.filterBy,
        })
        .then((res) => {
          this.users = res.data.data;
        });
    },

    async loadUsers() {
      this.isFetching = true;
      await axiosApi
        .get("api/manage-users-roles/get-users")
        .then((res) => {
          this.users = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped></style>
