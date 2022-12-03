<template>
  <section>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" src="/assets/sksu1.png" alt="Your Company" />
      <h2 class="mt-3 text-center text-3xl font-bold tracking-tight text-gray-900">
        Sign in to your account
      </h2>
    </div>

    <div class="pt-3 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white sm:rounded-lg sm:px-10">
        <form class="space-y-3" @submit.prevent="loginUser">
          <BaseInput
            :label="'Email'"
            v-model="form.email"
            :hasError="validationError.email"
          />

          <BaseInputPassword
            :label="'Password'"
            :show="showPassword"
            @showPassword="showPassword = !showPassword"
            :hasError="validationError.password"
            v-model="form.password"
          />
          <!-- <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" />
            </div>
          </div> -->

          <div class="flex items-center">
            <div class="text-sm">
              <router-link :to="{name: 'forgotpassword'}" class="font-medium text-indigo-600 hover:text-indigo-500"
                >Forgot your password?</router-link>
              
            </div>
          </div>
          <div class="min-h-16">
            <div class="flex justify-center items-center" v-if="isLoginLoading">
              <BaseSpinner />
            </div>

            <button
              v-else
              type="submit"
              class="flex w-full justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
              Login
            </button>
          </div>
        </form>

        <div class="mt-2">
          <div class="relative">
            <div class="relative flex justify-center text-sm">
              <span class="bg-white px-2 text-gray-500">Or </span>
            </div>
          </div>

          <div class="mt-2">
            <div>
                <div class="flex justify-center items-center" v-if="isLoginWithGoogleLoading">
              <BaseSpinner />
            </div>
              <WideButton v-else @click="continueWithGoogle">
                <svg
                  class="h-5 w-5 mx-1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  viewBox="0 0 48 48"
                >
                  <defs>
                    <path
                      id="a"
                      d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"
                    />
                  </defs>
                  <clipPath id="b"><use xlink:href="#a" overflow="visible" /></clipPath>
                  <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                  <path
                    clip-path="url(#b)"
                    fill="#EA4335"
                    d="M0 11l17 13 7-6.1L48 14V0H0z"
                  />
                  <path
                    clip-path="url(#b)"
                    fill="#34A853"
                    d="M0 37l30-23 7.9 1L48 0v48H0z"
                  />
                  <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                </svg>
                Continue with Google
              </WideButton>
              <div class="flex items-center justify-center mt-2">
                <div class="text-sm">
                  Dont have an account ?
                  <buttton
                    @click="$emit('showRegister')"
                    class="font-medium text-indigo-600 hover:text-indigo-500"
                    >Register</buttton
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
export default {
  emits: ["hasRequestError", "close", "showRegister"],
  data() {
    return {
      form: {
        email: "admin@gmail.com",
        password: "@admin123",
        device_name: "chrome",
      },
      showPassword: false,
      isLoginLoading: false,
      isLoginWithGoogleLoading: false,
      validationError: {},
      requestError: null,
    };
  },

  methods: {
    toggleShowPassword() {
      this.showPassword = !this.showPassword;
    },

    async loginUser() {
      this.isLoginLoading = true;
      await axios
        .post("api/login", this.form)
        .then((res) => {
          const userDetails = {
            first_name: res.data.data.user.first_name,
            last_name: res.data.data.user.last_name,
            email: res.data.data.user.email,
            email: res.data.data.user.email,
            token: res.data.data.token,
          };

          if (userDetails.token != null) {
            localStorage.setItem("token", userDetails.token);
          }

          this.$store.commit("setUserDetails", userDetails);
          this.$emit("close");
          window.location.reload(true);
          this.form = {
            email: "",
            password: "",
            device_name: "",
          };
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            
            this.$emit("hasRequestError", {
              statusCode: String(err.response.status),
              message: err.response.statusText,
            });
          }
        })
        .finally(() => {
          this.isLoginLoading = false;
        });
    },

    async continueWithGoogle() {
      this.isLoginWithGoogleLoading = true;
      await axios.get("api/authorize/google/redirect").then((res) => {

        console.log(res.data); 
          window.location.href = res.data.data.url;
        })
        .catch((err) => {
          this.$emit("hasRequestError", {
            statusCode: String(err.response.status),
            message: err.response.statusText,
          });
        })
        .finally(()=>{
            this.isLoginWithGoogleLoading = false;
        });
    },
  },
};
</script>

<style scoped></style>
