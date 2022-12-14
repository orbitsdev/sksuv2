<template>
  <BaseCard :subtitle="'SBO Advisers'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton
            @click="showConfirm = true"
            class="mr-2"
            v-if="selectedUsers.length > 0"
          >
            Remove sbo adviser ({{ selectedUsers.length }})
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area>
          <div v-if="isSchoolFetching">
            <BaseSpinner />
          </div>
          <div v-else>
            <select
              v-model="filterBy"
              @change="filterUser"
              class="block hover:shadow-lg border px-3 py-2 text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
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
        <template #actions-area> </template>
      </BaseTableSetup>
    </template>
    <BaseTable :thdata="['', 'Name', 'University', '']" :isFetching="isFetching">
      <template #data>
        <tr v-for="user in users" :key="user.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectedUsers"
              :value="user"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap py-4 text-sm">
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
                  {{ user.first_name + " " + user.last_name }}
                </div>
                <div class="text-gray-900">{{ user.email }}</div>
              </div>
            </div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div v-if="user.schools.length > 0">
              <span>
                {{ user.schools[0].name }}
              </span>
            </div>
            <div v-else>
              <span>
                <span
                  class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                  >None</span
                >
              </span>
            </div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>

          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            <button
              @click="showSingleConfirmationRemoveRole(user)"
              :disabled="selectedUsers.length > 0"
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
          </td>
        </tr>
      </template>
    </BaseTable>

    <teleport to="#app">
      <BaseDialog :show="showConfirm" :width="'500'" :preventClose="true">
        <template #c-content>
          <BaseConfirmation
            :selectedData="selectedUsers"
            @close="showConfirm = false"
            :isSaving="isRemoving"
            :title="'Are you sure do you want to remove the following users as '"
            :subject="'SBO Adviser?'"
          >
            <TableButton class="mr-2" @click="removeRoleOfSelectedUsers">
              Yes
            </TableButton>
          </BaseConfirmation>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="show" :width="'500'" :preventClose="true">
        <template #c-content>
          <BaseConfirmation
            @close="show = false"
            :isSaving="isConfirming"
            :title="'Are your sure do you want to make this users as '"
            :subject="'Sbo-Adviser'"
          >
            <template #data>
              <div class="bg-gray-100 text-xs italic p-1 my-1 rounded-sm">
                {{ selectedUser.first_name }} {{ selectedUser.last_name }} -
                <span
                  v-if="selectedUser.schools != null && selectedUser.schools.length > 0"
                >
                  {{ selectedUser.schools[0].name }}</span
                >
                <span v-else> Unknown </span>
              </div>
            </template>
            <TableButton class="mr-2" @click="removeUserRole"> Yes </TableButton>
          </BaseConfirmation>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseErrorDialog
        :show="requestError != null"
        :width="'400'"
        :transition="'slide-fade-down'"
      >
        <template #c-content>
          <RequestError
            :statusCode="requestError.statusCode"
            @close="requestError = null"
            :message="requestError.message"
          />
        </template>
        <template #c-actions> </template>
      </BaseErrorDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  data() {
    return {
      search: "",
      users: [],
      schools: [],
      selectedUsers: [],
      selectedUser: null,

      filterBy: "none",
      requestError: null,
      isSchoolFetching: false,
      isFetching: false,
      showConfirm: false,
      isConfirming: false,
      isRemoving: false,
      show: false,
    };
  },

  created() {
    this.loadUser();
    this.loadSchool();
  },
  watch: {
    search(oldeValue, newValue) {
      this.searchUser();
    },
  },

  methods: {
    showSingleConfirmationRemoveRole(user) {
      this.selectedUser = user;
      this.show = true;
    },
    async removeUserRole() {
      this.isConfirming = true;
      await axiosApi
        .post("api/current-sbo-advisers/remove-sbo-adviser-role-to-user", {
          id: this.selectedUser.id,
        })
        .then((res) => {
          this.show = false;
          this.selectedUser = null;
          this.loadUser();
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isConfirming = false;
        });
    },

    async removeRoleOfSelectedUsers() {
      const userid = [];

      this.selectedUsers.forEach((user) => {
        userid.push(user.id);
      });

      console.log(userid);

      this.isRemoving = true;
      await axiosApi
        .post("api/current-sbo-advisers/remove-sbo-adviser-role-to-the-selected-user", {
          userid: userid,
        })
        .then((res) => {
          this.selectedUsers = [];
          this.showConfirm = false;
          this.loadUser();
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isRemoving = false;
        });
    },

    async filterUser() {
      console.log(this.filterBy);
      await axiosApi
        .post("api/current-sbo-advisers/filter", {
          filter: this.filterBy,
        })
        .then((res) => {
          console.log(res);
          this.users = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        });
    },

    async searchUser() {
      await axiosApi
        .post("api/current-sbo-advisers/search", {
          search: this.search,
          filter: this.filterBy,
        })
        .then((res) => {
          console.log(res.data);
          this.users = res.data.data;
        });
    },
    async loadSchool() {
      this.isSchoolFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },
    async loadUser() {
      this.isFetching = true;
      await axiosApi
        .get("api/current-sbo-advisers")
        .then((res) => {
          console.log(res);
          this.users = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
  closeErrorDialog() {
    console.log("dasdsa");
    this.requestError = null;
  },

  async searchUser() {
    console.log(this.search);
    await axiosApi
      .post("api/current-sbo-advisers/search", {
        search: this.search,
        filter: this.filterBy,
      })
      .then((res) => {
        this.users = res.data.data;
      });
  },
};
</script>

<style scoped></style>
