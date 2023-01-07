<template>
  <BaseCard class="relative" :subtitle="'Available Users'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton
            v-if="selectedSboAdvisers.length > 0"
            class="mr-2"
            @click="showTheForm"
          >
            Make selected users as Sbo Adviser ({{ selectedSboAdvisers.length }})
          </TableButton>
          <BaseSearchInput :placeholder="'Search name ..'" v-model="search" />
        </template>
        <template #filters-area>
          <div v-if="isSchooLoading">
            <BaseSpinner />
          </div>
          <div class="flex items-center" v-else>
            <select
              v-model="filterBy"
              @change="filterSbo"
              class="block hover:shadow-lg px-3 py-2 border text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
            >
              <option :value="'none'">None</option>
              <option
                v-for="option in schools"
                :key="option.id"
                class="py-2"
                :value="option.name"
              >
                {{ option.name }}
              </option>
            </select>
          </div>
        </template>
        <template #actions-area>
      
        </template>
      </BaseTableSetup>
    </template>

    <BaseTable
      :thdata="['', 'Sbo Adviser Name', 'Roles', 'University', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="sboadviser in sboadvisers" :key="sboadviser.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectedSboAdvisers"
              :value="sboadviser"
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

          <td class="py-2 text-sm text-gray-500">
            <div v-if="sboadviser.roles.length > 0" class="inline-flex">
              <p v-for="role in sboadviser.roles" :key="role.id" >
                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5">{{ role.name }}</span>
              </p>
            </div>
            <div v-else>
              <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">None</span>
            </div>
          </td>

          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
            <div v-if="sboadviser.schools.length > 0">
              <span v-for="sboschool in sboadviser.schools" :key="sboschool.id">
                {{ sboschool.name }}
              </span>
            </div>

            <span v-else class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5">None</span>

          </td>
          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            <!-- <button
                  type="button"
                  class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
                >
                  <i class="fa-regular fa-pen-to-square"></i>
                </button> -->
          </td>
        </tr>
      </template>
    </BaseTable>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <BaseConfirmation
            :selectedData="selectedSboAdvisers"
            @close="closeTheForm"
            :isSaving="isSaving"
            :title="'Are your sure do you want to make this users as'"
            :subject="'Sbo-Adviser'"
          >
            <TableButton class="mr-2" @click="makeUsersAsSboAdviser"> Yes </TableButton>
          </BaseConfirmation>
        </template>
      </BaseDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  created() {
    this.loadSboAdvisers();
    this.loadSchool();
  },

  data() {
    return {
      filterBy: "none",
      showForm: false,
      search: "",
      sboadvisers: [],
      schools: [],
      selectedSboAdvisers: [],
      requestError: null,
      isFetching: false,
      isSchooLoading: false,
      isSaving: false,
      requestError: null,
    };
  },

  watch: {
    search(oldeValue, newValue) {
      this.searchSbo();
    },
  },

  methods: {
    closeTheForm() {
      this.showForm = false;
    },
    showTheForm() {
      this.showForm = true;
    },

    async makeUsersAsSboAdviser() {
      const selectedId = [];
      this.selectedSboAdvisers.forEach((user) => {
        selectedId.push(user.id);
      });

      this.isSaving = true;
      await axiosApi
        .post("api/sbo-advisers/make-user-as-adviser", {
          usersid: selectedId,
        })
        .then((res) => {
          console.log(res.data.data);
          this.loadSboAdvisers();
          this.showForm = false;
          this.selectedSboAdvisers = [];
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    customConfirmationDialog({
      title = "Are you sure?",
      text = "You won't be able to revert this!",
      icon = "warning",
      confirmButtonText = "Yes, delete it!",
      passFunction,
      passCancelFunction,
    }) {
      this.$swal({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmButtonText,
      }).then(async (result) => {
        if (result.isConfirmed) {
          passFunction();
        }
      });
    },
    async searchSbo() {
      axiosApi
        .post("api/sbo-advisers/search", {
          search: this.search,
          filter: this.filterBy,
        })
        .then((res) => {

          this.sboadvisers = res.data.data;

        });
    },

    async filterSbo() {
      await axiosApi
        .post("api/sbo-advisers/filter", {
          filter: this.filterBy,
        })
        .then((res) => {
          this.sboadvisers = res.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async loadSboAdvisers() {
      this.isFetching = true;
      await axiosApi
        .get("api/sbo-advisers")
        .then((res) => {
          // console.log(res.data);
          this.sboadvisers = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
    async loadSchool() {
      this.isSchooLoading = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isSchooLoading = false;
        });
    },
  },
};
</script>


<style scoped></style>

