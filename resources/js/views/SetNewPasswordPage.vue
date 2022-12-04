<template>
  <div class="flex justify-center items-center  h-screen p-20 bg-white">
    <div class=" flex flex-col justify-center items-center">

        <img class="sv-image" src="/assets/my_universe_803e.svg" alt="sksu" />
        <h1 class="mt-2 text-lg tex-green-400 font-bold tracking-tight text-gray-900 sm:text-5xl">
            {{ form.email }} 
            {{ validationError }}
          </h1>
       <form class="space-y-3 mt-4" @submit.prevent="setNewPassword">
        <BaseInputPassword
        :label="'Enter New Password'"
          :show="showPassword"
          @showPassword="(showPassword = !showPassword)"
          :hasError="validationError.password"
          v-model="form.password"
        />
        <BaseInputPassword
        :label="'Retype New Password'"
          :show="showPasswordConfirmation"
          @showPassword="(showPasswordConfirmation = !showPasswordConfirmation)"
          v-model="form.password_confirmation"
        />
  

        
        <div class="min-h-16">
          <div class="flex justify-center items-center " v-if="isLoading">
            <BaseSpinner />
          </div>

          <button
            v-else
            type="submit"
            class="flex w-full justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
          >
            Save
          </button>
        </div>
      </form>
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
</div>
</template>

<script>
import axios from "axios";
export default {
  mounted() {
    this.setCredentials();
  },
  data() {
    return {
      form: {
        email: "",
        token: "",
        password: "",
        password_confirmation: "",
        actual_email: "",
      },
      showPassword: false,
      showPasswordConfirmation: false,
      screenLoading: false,
      isLoading: false,
      validationError: {},
      requestError: null,
    };
  },

  methods: {
    async setCredentials() {
      if (this.$route.query.email && this.$route.query.token) {
    
        this.form.email = this.$route.query.email;
        this.form.actual_email = this.$route.query.email;
        this.form.token = this.$route.query.token;
      }
    },

    closeErrorDialog() {
      this.validationError = {};
      this.requestError = null;
    },
    async setNewPassword() {
      this.isLoading = true;
      await axios
        .post("api/set-password", this.form)
        .then((res) => {

          this.$router.replace("/");
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = {
              statusCode: String(err.response.status),
              message: err.response.data[0],
            };
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>

<style scoped>
.sv-image {
  width: 200px;
  height: auto;
}
</style>
