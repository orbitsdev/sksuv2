<template>
  <main>
    <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
      <button
        type="button"
        class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
      >
        <span class="sr-only">Open sidebar</span>
        <!-- Heroicon name: outline/bars-3-bottom-left -->
        <svg
          class="h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"
          />
        </svg>
      </button>
      <div class="flex flex-1 justify-between px-4">
        <div class="flex flex-1"></div>
        <div class="ml-4 flex items-center md:ml-6">
          <button
            type="button"
            class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            <span class="sr-only">View notifications</span>
            <!-- Heroicon name: outline/bell -->
            <svg
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
              />
            </svg>
          </button>

          <!-- Profile dropdown -->
          <div class="relative ml-3">
            <div>
              <button
                @click="showLogoutButton = !showLogoutButton"
                type="button"
                class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                id="user-menu-button"
                aria-expanded="false"
                aria-haspopup="true"
              >
                <span class="sr-only">Open user menu</span>
                <img
                  class="h-8 w-8 rounded-full"
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                />
              </button>
            </div>

            <div
              v-show="showLogoutButton"
              class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              role="menu"
              aria-orientation="vertical"
              aria-labelledby="user-menu-button"
              tabindex="-1"
            >
              <button
                @click="logoutUser"
                class="block px-4 py-2 text-sm text-gray-700"
                role="menuitem"
                tabindex="-1"
                id="user-menu-item-2"
              >
                Sign out
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    <div v-if="isFetching" class="flex justify-center items-center h-screen">
      <BaseSpinner/>
    </div>
    <div v-else class="m-7">
    
      <div v-if="schools.length > 0" class="my-3">
        <h1 class="text-4xl font-bold">What University Are You In?</h1>
      </div>
       
      
      <ul
        
        role="list"
        class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <li
          @click="selectSchool(school)"
          v-for="school in schools"
          :key="school.id"
          class="border border-grey-400 cursor-pointer hover:bg-green-50 hover:border col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center"
        >
          <div class="flex flex-1 flex-col p-8">
            <div v-if="school.files.length > 0">
              <img
                class="mx-auto h-30 w-30 flex-shrink-0 rounded-xs"
                :src="'/uploads/files/' +
                  school.files[0].owned_by +
                  '/' +
                  school.files[0].folder +
                  '/' +
                  school.files[0].file_name
                "
                alt=""
              />
            </div>
            <div v-else>
            <img
              class="mx-auto h-30 w-30 flex-shrink-0 rounded-xs"
              :src="'/assets/undraw_welcome_re_h3d9.svg'"
              alt=""
            />
            </div>

            <!-- <h3 class="mt-6 text-sm font-medium text-gray-900">{{ school.name }}</h3> -->
            <dl class="mt-1 flex flex-grow flex-col justify-between">
              <dt class="sr-only">Title</dt>
              <dt class="sr-only">Role</dt>
              <dd class="mt-3">
                <span
                  class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800"
                >
                  {{ school.name }}</span
                >
              </dd>
            </dl>
          </div>
        </li>

        <!-- More people... -->
      </ul>
    </div>

    <teleport to="#app">
      <BaseDialog :show="selectedSchool != null" :width="'500'" :preventClose="true" >
        <template #c-content>
          <p class="text-lg font-extrabold mb-1">{{ selectedSchool.name }}</p>

          <w-divider class="mb-1"></w-divider>
          <span class="text-sm text-gray-600">
            Make sure to select school that you belong. If you think you made mistake you can request to the admin
          </span>
          <div class="flex">
            <TableButton @click="selectedSchool = null" mode class="mt-4 mr-2"
              >Close
            </TableButton>
            <BaseSpinner v-if="isSaving" class="mx-4 mt-4" />
            <TableButton @click="attachSchoolToUser" v-else class="mt-4">
              Confirm University
            </TableButton>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="isLogout" :width="'200'">
        <template #c-content>
          <div class="flex justify-center items-center">
            <BaseSpinner class="mx-2" />
            <p class="text-lg">Signing out...</p>
          </div>
        </template>
      </BaseDialog>
    </teleport>
  </main>
</template>

<script>
import axiosApi from "../api/axiosApi";
import { mapGetters } from "vuex";

export default {
  created() {
    this.getUserDetails();
    this.loadSchool();
  },


  computed: {
    ...mapGetters(['User']),
  },
  data() {
    return {
      schools: [],
      showLogoutButton: false,
      isFetching: false,
      isLogout: false,
      isSaving: false,
      selectedSchool: null,
    };
  },

  methods: {
    async attachSchoolToUser() {
      this.isSaving = true;
      await axiosApi
        .post("api/schools/attach-to-user", {
          school: this.selectedSchool,
        })
        .then((res) => {
          window.location.reload(true);
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    selectSchool(school) {
      const newSchool = school;
      this.selectedSchool = newSchool;
    },

    checkUserAccount(){

if(this.User.hasRoleOf(['sbo-student', 'sbo-adviser', 'guest'])){

  if(this.User.schools.length > 0){
      this.$router.push({ name: 'dashboard'});
  }
}

},  
    async getUserDetails() {

const token = localStorage.getItem('token');

if(token !=  null){

  if(this.$store.state.User == null){
    this.isScreenLoading = true;

    this.$store.dispatch('getUser').then(res=>{         
     this.$store.commit('setUser', res);
     console.log("from fetch");
     this.checkUserAccount();


   }).catch(err=>{

    this.requestError = err;
    this.$store.dispatch('logoutUser');
   }).finally(()=>{

    this.isScreenLoading = false;


   });

  }else{
    this.checkUserAccount();
    
  }
}

},

    async logoutUser() {
      this.isLogout = true;
      await axiosApi
        .post("api/logout")
        .then((res) => {
          localStorage.removeItem("token");
          window.location.reload(true);
        })
        .catch((err) => {
          if (err.response.status == 401) {
            localStorage.removeItem("token");
            window.location.reload(true);
          }

          this.requestError = {
            statusCode: String(err.response.status),
            message: err.response.statusText,
          };

          localStorage.removeItem("token");
          window.location.reload(true);
        })
        .finally(() => {
          this.isLogout = false;
        });
    },
    async loadSchool() {
      this.isFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          console.log(res.data);
          this.schools = res.data.data;
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


.sv-image{
  width: 360px;
  height: auto;
}</style>
