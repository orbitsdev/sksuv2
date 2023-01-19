<template>
  <div>
    <div v-if="isFetching">
      <div class="h-screen flex justify-center items-center">
        <Loader1 />
      </div>
    </div>

    <div v-else>

      <div class="flex justify-between items-center">

        <div class="relative my-6  inline-flex items-center justify-center shadow">
          <i class="absolute fa fa-search text-gray-400 top-5 left-4"></i>
          <input v-model="search" type="text" placeholder="Search" class="bg-white h-14 w-full px-12 rounded-lg focus:outline-none hover:cursor-pointer" name="">
        </div>
        <div>
          <div class="relative my-6 inline-flex items-center justify-center shadow">
            <i class="absolute fa fa-calendar text-gray-400 top-5 left-4"></i>
            <input type="date" v-model="selectedDate" id="datepicker" class="bg-white h-14 w-full px-12 rounded-lg focus:outline-none hover:cursor-pointer">
          </div>
          
        </div>
        
      </div>
      

      <ul
        v-if="applications.length > 0"
        role="list"
        class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
      >
        <li
          @click="this.$router.push({ name: 'monitor-app', params: { id: item.id } })"
          v-for="item in applications"
          :key="item.id"
          class="rounded-lg bg-white hover:shadow-lg shadow cursor-pointer"
        >
          <div class="pt-6 px-4 ">
            <div class="">
              <h3 class="text-xl font-semibold tracking-wide uppercase">
                {{ item.application_form.title }}
              </h3>
              <div class="mt-3 flex justify-start items-center">
                <div class="mr-2">
                  <p
                    class="px-2 py-1 bg-gradient-to-l from-emerald-900 to-emerald-600 text-white text-sm rounded "
                  >
                    <i class="fa-regular fa-file"></i> 5 Requirement
                  </p>
                </div>
                <p class="text-sm uppercase">
                  Applied -
                  <span class="text-sm text-gray-500">
                    {{ formatDate(item.created_at) }}
                  </span>
                </p>
              </div>

              <div class="my-4">
                <ul class="flex justify-center">
                  <li>
                    <div class="flex justify-center items-center">
                      <div
                        class="h-6 w-6 bg-green-50 rounded-full flex justify-center items-center"
                      >
                        <i class="fa-solid fa-cloud-arrow-up text-green-700"></i>
                      </div>
                      <p class=" mx-2">5 Uploads</p>
                    </div>
                  </li>
                  <li>
                    <div class="flex justify-center items-center">
                      <div
                        class="h-6 w-6 bg-green-50 rounded-full flex justify-center items-center"
                      >
                        <i class="fa-solid fa-thumbtack text-green-700"></i>
                      </div>
                      <p class=" mx-2"> 10 Remarks</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="mx-4 pb-4">
          

            <section class="px-4 pb-4" v-if="item.approvals.length > 0">
              <div
                v-for="approver in item.approvals"
                :key="approver.id"
                class="relative col-span-12 px-4 space-y-6 sm:col-span-9"
              >
                <div
                  v-if="approver.user != null"
                  class="col-span-12 space-y-12 relative px-4 sm:col-span-8 sm:space-y-8 sm:before:absolute sm:before:top-2 sm:before:bottom-0 sm:before:w-0.5 sm:before:-left-3 before:dark:bg-gray-300"
                >
                  <div
                    class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-green-500"
                  >
                    <h3 class="text-lg font-semibold uppercase tracking-wide">
                      {{ approver.user.roles[0].name }}
                    </h3>

                    <div
                      class="mt-1 flex items-center"
                      v-if="approver.decision == 'processing'"
                    >
                      <i class="mr-2 text-xs fas fa-clock text-blue-600"></i>
                      <p class="text-xs capitalize font-bold text-blue-500">
                        {{ approver.decision }}
                      </p>
                    </div>
                    <div v-if="approver.decision == 'approved'">
                      <div class="mt-1 flex items-center">
                        <i
                          class="mr-2 text-xs text-green-500 fa-solid fa-circle-check"
                        ></i>
                        <p class="mr-2 text-xs font-bold text-green-600">Approved</p>
                        <span class="text-xs text-gray-500">
                          {{ formatDate(item.updated_at) }}
                        </span>
                      </div>
                      <small class="text-gray-500 capitalize"
                        >by: {{ approver.user.first_name }} {{ approver.user.first_name }}
                      </small>
                      <div>
                        <w-divider class="my1"></w-divider>
                        <div>
                          <div class="mt-1 flex items-center">
                            <i
                              class="mr-2 text-xs text-green-500 fa-solid fa-circle-check"
                            ></i>
                            <p class="mr-2 text-xs font-bold text-green-600">
                              Endorsed to Osas
                            </p>
                            <span class="text-xs text-gray-500">
                              {{ formatDate(item.updated_at) }}
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="approver.decision == 'denied'">
                      <div class="mt-1 flex items-center">
                        <i class="mr-2 text-xs text-red-500 fas fa-times-circle"></i>
                        <p class="mr-2 text-xs font-bold text-red-600">Denied</p>
                        <span class="text-xs text-gray-500">
                          {{ formatDate(item.updated_at) }}
                        </span>
                      </div>
                      <p class="text-xs text-gray-500 capitalize">
                        by: {{ approver.user.first_name }} {{ approver.user.first_name }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </section> 
          </div>
        </li>
      </ul>
      <EmptyCard
        v-else
        :url="'/assets/undraw_thoughts_re_3ysu.svg'"
        :m="'No Application Is Available'"
      />
    </div>

    <!-- <router-view></router-view> -->
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
import moment from "moment";

export default {
  data() {
    return {
      search: "",
      isFetching: false,
      applications: [],
      selectedDate:  "",
      
    };
  },

  watch: {
    search(olvalue, newvalue) {
      this.searchResponse();
    },

    selectedDate(newVal) {
      this.fetchData(newVal);
    }

  },

  created() {
    this.getAllApplication();
  },

  methods: {
    async fetchData(date) {


      const month = new Date(date).getMonth() + 1; // getMonth() returns a 0-based index, so we add 1
      const year = new Date(date).getFullYear();

      console.log(month,year);

      axiosApi.post("api/monitor-form/searby/date", {
        month: month,
        year: year
      })
        .then(res => {
            this.applications = res.data.data;
        });

    },
   

    async searchResponse() {


await axiosApi
  .post("api/monitor/search", {
    search: this.search,
  })
  .then((res) => {
    this.applications = res.data.data;
  });
},
    formatDate(date) {
      return moment(date).format("MMM, D YYYY");
    },

    async getAllApplication() {
      this.isFetching = true;

      axiosApi
        .get("api/monitor/response")
        .then((res) => {
          console.log(res.data.data);

          this.applications = res.data.data;
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
.animation-pulse::before {
  /*box-shadow: 0 0 0 20px rgba(229,62,62, 0.5);
  transform: scale(0.8);*/
  animation: pulse 2s infinite;
  border-radius: 50% !important;
}

@keyframes pulse {
  0% {
    transform: scale(0.8);
    box-shadow: 0 0 0 0 rgb(23, 192, 37);
  }

  70% {
    transform: scale(0.9);
    box-shadow: 0 0 0 60px rgba(229, 62, 62, 0);
  }

  100% {
    transform: scale(0.8);
  }
}
</style>
