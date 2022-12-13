<template>
  <div class="bg-white">
  
    <div class="mx-auto max-w-7xl py-12 px-4 text-center sm:px-6 lg:py-16 lg:px-8">
      <div v-if="isLoading" class="h-auto flex  justify-center items-center">
        <BaseSpinner />
      </div>
      <div v-else>
        <div v-if="request.length > 0">{{request}}</div>
        <div v-else>
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            <span class="block">Request Role As Sbo Adviser</span>
          </h2>
          <div class="mt-8 flex justify-center">
            <div class="inline-flex rounded-md shadow">
              <BaseSpinner v-if="isRequesting" />
              <TableButton v-else @click="sendRequestForSbo"> makeRequest </TableButton>
            </div>
          </div>
        </div>
      </div>
     
      
    </div>
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      isLoading: false,
      isRequesting: false,
      request: [],
      requestError: null,
    };
  },
  created() {
    this.checkRequest();
  },

  computed: {
    ...mapGetters(["Auth"]),
  },
  methods: {
    async checkRequest() {

      this.isLoading = true;
      await axiosApi
        .get("api/sbo-requests/get-sbo-request")
        .then((res) => {
          if (res.data.length > 0) {
            // this.request = res.data;
            //  console.log(res.data);
            // request = res.data.data;
          }
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async sendRequestForSbo() {
      this.isRequesting = true;
      await axiosApi
        .post("api/sbo-requests/request-role-as-sbo-adviser")
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isRequesting = false;
        });
    },
  },
};
</script>

<style scoped></style>
