<template>
  
  <div class="flex h-screen flex-col bg-white">
    <main
      class="mx-auto flex w-full max-w-7xl flex-grow flex-col justify-center px-4 sm:px-6 lg:px-8"
    >
      <div class="flex flex-shrink-0 justify-center">
        <a href="/" class="inline-flex">
          <span class="sr-only">Your Company</span>
          <img class="sv-image" src="/assets/secure.svg" alt="sksu" />
        </a>
      </div>
      <div class="py-4">
        <div class="text-center">
          <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
            Request Password Reset
          </h1>
          <div class="mt-2 ">
            <div class="flex p-2 justify-center ">
                <div class="w-64">
                  <div>
                    <BaseInput
                    :label="'Email'"
                    v-model="email"
                    :hasError="validationError.email"
                    />
                  </div>
                </div>
              </div>
              <div class="flex p-2 justify-center ">
                <div class="w-64">
                  <div>
                    <div class="flex justify-center items-center" v-if="isLoading">
                      <BaseSpinner />
                    </div>
                    <button
                    v-else
                      @click="sendRequest"
                    class="flex w-full justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                  >
                    Send Request
                  </button>
                  </div>
                </div>
              </div>
             
            <a
              href="/"
              class="text-base font-medium text-indigo-600 hover:text-indigo-500"
            >
              Go back home
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
      </div>
    </main>

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
  </div>
</template>

<script>

import axios from 'axios';
export default {
  data() {
    return {
      email: "",
      isLoading: false,
      validationError: {},
      requestError: null,
    };
    
  },

  methods: {

   closeErrorDialog(){
    this.requestError = null;
   },
   async sendRequest(){
      this.isLoading = true;
    await axios.post('api/request-password-reset', {
        email: this.email
      }).then(res=>{

        this.$router.push('/password-request-sent?email='+this.email );

      }).catch(err=>{


        if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
              
           this.requestError = {
              statusCode: String(err.response.status),
              message: err.response.data[0],
            }
           
          }
      })
      .finally(()=>{
        this.isLoading = false;
      });
   }
  }
};
</script>

<style scoped>


.sv-image{
  width: 260px;
  height: auto;
}

</style>
