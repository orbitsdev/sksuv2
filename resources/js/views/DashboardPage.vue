<template>
  <LoadingScreen v-if="isScreenLoading" />
  <section v-else>
    <div class="flex">
      <div class="relative z-40 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">
          <div
            class="relative flex w-full max-w-xs flex-1 flex-col bg-indigo-700 pt-5 pb-4"
          >
            <div class="absolute top-0 right-0 -mr-12 pt-2">
              <button
                type="button"
                class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
              >
                <span class="sr-only">Close sidebar</span>
                <!-- Heroicon name: outline/x-mark -->
                <svg
                  class="h-6 w-6 text-white"
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
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>

            <div class="flex flex-shrink-0 items-center px-4 py-10">
              <img
                class="h-8 w-auto"
                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=300"
                alt="Your Company"
              />
            </div>
          </div>

          <div class="w-14 flex-shrink-0" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
        </div>
      </div>

      <!-- Static sidebar for desktop -->
      <div class="bg-green-900 py-5 w-80">
        <div class="">
          <div class="flex flex-shrink-0 items-center px-4">
            <img class="h-14 w-auto" :src="'/assets/sksu1.png'" alt="Your Company" />
            <p class="ml-2 text-white text-2xl font-bold font-rubik">WBRSA</p>
          </div>
          <div class="mt-5 flex flex-1 flex-col">
            <nav class="flex-1 space-y-1 px-2 pb-4">
              <!-- <a
                href="#"
                class="bg-indigo-800 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md"
              >
                <svg
                  class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300"
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
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                  />
                </svg>
                Dashboard

              </a> -->

              <div v-if="User.hasRoleOf(['osas'])">
                <router-link
                  :to="{ name: 'manage-school-year' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->

                 <div class="w-9">

                   <i class="fa-solid fa-calendar text-xl mr-4"></i>
                  </div>

                  Manage Year
                </router-link>
                <router-link
                  :to="{ name: 'manage-university-tabs' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-school-flag text-xl mr-4"></i>
                  </div>
                  Manage University
                </router-link>

                <router-link
                  :to="{ name: 'manage-account-tabs' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                <div class="w-9">

                  <i class="fa-solid fa-users text-xl mr-4"></i>
                </div> 
                  Manage Users
                </router-link>

                <router-link
                  :to="{ name: 'manage-application-tabs' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-list-check text-xl mr-4"></i>
                  </div>
                  Manage Applications Form
                </router-link>
              </div>

              <div v-if="User.hasRoleOf(['sbo-adviser'])">
                <router-link
                  :to="{ name: 'manage-organization' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-building-user  text-xl mr-4"></i>
                  </div>
                  Manage Organization
                </router-link>

                <router-link
                  :to="{ name: 'select-school-year-for-manage-officers' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-clipboard-user text-xl mr-4"></i>
                  </div>
                  Manage Officers
                </router-link>
                <router-link
                  :to="{ name: 'schools-officers-documents' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-folder-open text-xl mr-4"></i>
                  </div>

                  Officers Documents
                </router-link>
                <router-link
                  :to="{ name: 'schools-contain-endorsed-documents' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                 <div class="w-9">

                   <i class="fa-solid fa-handshake-simple text-xl   mr-4"></i>
                  </div>

                  Endorsed Documents
                </router-link>
              </div>
              <div v-if="User.hasRoleOf(['sbo-student'])">
                <router-link
                  :to="{ name: 'get-school-year-application' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                  <div class="w-9">

                    <i class="fa-solid fa-file-signature text-xl   mr-4"></i>
                   </div>
                
                  Applications
                </router-link>
                <router-link
                  :to="{ name: 'school-year-minitor-application' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                  <div class="w-9">

                    <i class="fa-solid fa-id-card-clip text-xl   mr-4"></i>
                  </div>
                  Monitor Application
                </router-link>
              </div>

              <div v-if="User.hasRoleOf(['campus-director'])">
                <router-link
                  :to="{ name: 'campus-director-endorsed-application' }"
                  href="#"
                  class="text-white hover:bg-green-600 group flex items-center px-2 py-2 text-base font-medium rounded-md font-rubik"
                >
                  <!-- Heroicon name: outline/folder -->
                  <div class="w-9">

                    <i class="fa-solid fa-file-signature text-xl   mr-4"></i>
                   </div>
                  Applications
                </router-link>
              </div>
            </nav>
          </div>
        </div>
      </div>
      <div class="flex-1">
        <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 shadow">
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
          <div class="flex bg-white flex-1 justify-between px-4">
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
                    {{ User.id }} <span>{{ User.user_roles }} </span>
                    <span class="mr-3 capitalize">
                      {{ User.first_name }} {{ User.last_name }}</span
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

        <main class="py-6 min-h-screen bg-center bg-cover bg-no-repeat">
          <div class="">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8"></div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
              <!-- {{ User }} -->

              <!-- {{ this.$route.path }}
              {{ User.hasRoleOf(["osas"]) }} -->
              <router-view> </router-view>
            </div>
          </div>
        </main>
      </div>
    </div>

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

    <teleport to="#app">
      <BaseErrorDialog :show="requestError != null">
        <template #c-content>
          <RequestError
            :statusCode="requestError.statusCode"
            @close="closeErrorDialog"
            :message="requestError.message"
          />
        </template>
      </BaseErrorDialog>
    </teleport>
  </section>
</template>

<script>
import axiosApi from "../api/axiosApi";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      showLogoutButton: false,
      isLogout: false,
      requestError: null,
      hasRuest: null,
      isScreenLoading: false,
    };
  },
  computed: {
    ...mapGetters(["User"]),
  },
  created() {
  
  },

  mounted() {
    this.getUserDetails();
  },
  methods: {
    closeErrorDialog() {
      this.requestError = null;
    },

    checkUserAccount() {
    
    

      if (this.User.hasRoleOf(["guest"])) {
        this.$router.replace({ name: "waiting-page" });
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
    async getUserDetails() {
      this.isScreenLoading = true;
      const token = localStorage.getItem("token");

      if (token != null) {
        if (this.$store.state.User == null) {

          this.$store
            .dispatch("getUser")
            .then((res) => {
              this.$store.commit("setUser", res);
              console.log("from fetch");
              this.checkUserAccount();
            })
            .catch((err) => {
              this.requestError = err;
              this.$store.dispatch("logoutUser");
            })
            .finally(() => {
              this.isScreenLoading = false;
            });
        } else {
          // this.getUserDetails();
          this.checkUserAccount();
          this.isScreenLoading = false;
        }
      }
    },
  },
};
</script>

<style scoped>
.bg-my-image {
  background: no-repeat left top, linear-gradient(#124a2a, #0c672a30),
    url("/assets/sksu.jpg");
}

.router-link-active {
  background: #189144 !important;
}
</style>
