<template>
  <div>
    <div v-if="isFetching">
      <div class="h-screen flex justify-center items-center">
        <Loader1 />
      </div>
    </div>

    <div v-else>
      <!-- {{ applications }} -->
      <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <li
          v-for="item in applications"
          :key="item.id"
          class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow cursor-pointer"
        >
          <div class="flex w-full items-center justify-between space-x-6 p-6">
            <div class="flex-1 truncate">
              <div class="flex items-center space-x-3">
                <h3 class="truncate text-sm font-medium text-gray-900"></h3>
                <span
                  class="inline-block flex-shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"
                  >Admin</span
                >
              </div>
              <p class="mt-1 truncate text-sm text-gray-500">
                Regional Paradigm Technician
              </p>
            </div>
            <img
              class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
              alt=""
            />
          </div>
          <div></div>
          <div>
            {{ item.application_form }}
            <hr />
            {{ item.answers }}
            <hr />
            {{ item.response_requirements }}
          </div>
        </li>
      </ul>
    </div>

    <!-- <router-view></router-view> -->
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  data() {
    return {
      isFetching: false,
      applications: [],
    };
  },
  created() {
    this.getAllApplication();
  },

  methods: {
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

<style scoped></style>
