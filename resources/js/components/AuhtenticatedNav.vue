<template>
    <div>
 
  <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
   
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


  <GlobalErrorCard  @close="requestError = null" :show="requestError != null">
</GlobalErrorCard>
     
  </div>
</template>

<script>
import axiosApi from "../api/axiosApi";
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["User"]),
  },

  data() {
    return {
      isLogout: false,
    };
  },

  methods: {
    async getUserDetails() {
      const token = localStorage.getItem("token");

      if (token != null) {
        if (this.$store.state.User == null) {
          this.isScreenLoading = true;

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
  },
};
</script>

<style lang="scss" scoped></style>
