<template>
  <!-- This example requires Tailwind CSS v3.0+ -->
  <div
    class="sksuparent relative min-h-screen max-h-screen bg-gray-900 flex items-center justify-center relative"
  >
    <div class="absolute top-8 right-10">
      <button
      @click="logoutUser"
        class="flex items-center jusitfy-center hover:bg-white py-4 px-4 transition rounded ease-in-out hover:text-green-700"
      >
        <i class="fa-solid fa-right-from-bracket text-2xl mr-2"></i>
        <span class="text-2xl font-rubik"> Logout </span>
      </button>
    </div>

    <div class="mx-auto max-w-2xl">
      <div class="flex items-center justify-center">
        <img src="/assets/undraw_secure_login_pdn4.svg" alt="" class="w-60 h-60" />
      </div>
      <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl font-rubik">
          @SKSU PROJECT
        </h1>
        <p class="text-2xl font-rubik mt-8 uppercase">
          " Your currently account type is guest "
        </p>
        <p class="mt-10 text-lg leading-8 text-white font-rubik">
          To access your preferred position, you will need to be authorized by an
          administrator. Please reach out to either the developer or the administrator to
          request authorization. We appreciate your patience while we work to provide you
          with the best possible experience on our platform.
        </p>
      </div>
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

  <GlobalErrorCard @close="requestError = null" :show="requestError != null">
    {{ requestError }}
  </GlobalErrorCard>
</template>

<script>

import axiosApi from "../api/axiosApi";
import { mapGetters } from "vuex";
export default {
  created() {
    this.getUserDetails();
  },
  computed: {
    ...mapGetters(["User"]),
  },
  data() {
    return {
      isLogout: false,
      showLogoutButton: false,
      isFetching: false,
      isLogout: false,
      requestError: null,
    };
  },

  methods: {
   
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

checkUserAccount(){

if(!this.User.hasRoleOf(['guest'])){

    this.$router.push({ name: 'dashboard'});
  
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

          this.requestError = err;
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

<style scoped>
.sksuparent {
  background-image: linear-gradient(90.9deg, rgb(20, 83, 45) 0.5%, rgb(22, 163, 74) 99.7%);

  color: white;
  padding: 20px;
}
</style>
