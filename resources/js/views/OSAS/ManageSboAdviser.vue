<template>
  <BaseCard class="relative" :subtitle="'Manage Schools'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            <i class="fa-solid fa-plus mr-1"></i> Add Sbo Adviser
          </TableButton>
          <BaseSearchInput :placeholder="'Search sbo Adviser ...'" v-model="search" />
        </template>
        <template #filters-area>
          <BaseFilter class="mx-1" />
          <!-- <BaseFilter class="mx-1"/> -->
        </template>
        <template #actions-area>
          <TableButton :mode="true" class="mr-2">
            <i class="fa-regular fa-trash-can mr-2"></i> Selected (1 )
          </TableButton>
          <TableButton :mode="true">
            <i class="fa-regular fa-trash-can mr-1"></i>
            <span class="block">Delete All</span>
          </TableButton>
        </template>
      </BaseTableSetup>
    </template>

    <BaseTable :thdata="['', 'Sbo Adviser Name', 'Schools', '']">
      <template #data>
        {{ sboadvisers }}
        <tr v-for="sboadviser in sboadvisers" :key="sboadviser.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectSboAdviser"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap py-4">
            <div class="flex items-center">
              <div class="h-10 w-10 flex-shrink-0">
                <img
                  class="h-10 w-10 rounded-full"
                  src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                />
              </div>
              <div class="ml-4">
                <div class="font-medium text-gray-900">
                  {{ sboadviser.first_name + " " + sboadviser.last_name }}
                </div>
                <div class="text-gray-900">{{ sboadviser.email }}</div>
              </div>
            </div>
          </td>

          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900"></td>
          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            <button
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
            <button
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </td>
        </tr>
      </template>

      -->

      <!-- <teleport to="#app">
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
              </teleport>-->
    </BaseTable>
  </BaseCard>
</template>

<script>
export default {
  created() {
    this.loadSboAdvisers();
  },

  data() {
    return {
      search: "",
      sboadvisers: [],
      schools: [],
      selecteSboAdviser: [],
      requestError: null,
      isFetching: false,
      requestError: null,
    };
  },

  methods: {
    async loadSboAdvisers() {
      this.isFetching = true;
      await axiosApi
        .get("api/sbo-advisers")
        .then((res) => {
          console.log(res.data);
          this.sboadvisers = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped></style>
