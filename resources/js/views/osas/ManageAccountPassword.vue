<template>
  <BaseCard :subtitle="'Manage Users Account'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton
            v-if="selectedUsers.length"
            class="mr-2"
            @click="handleShowRolesForm"
          >
            Update Account
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area> </template>
        <template #actions-area></template>
      </BaseTableSetup>
      <BaseTable :thdata="['Name', 'Email', 'Password', '']" :isFetching="isFetching">
        <template #data>
          <tr v-for="user in users" :key="user.id">
            <!-- <td class=" whitespace-nowrap  py-4 text-s relative w-12  sm:w-16 sm:px-8">
              <input
                v-model="selectedUsers"
                :value="user"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td> -->
            <td class="whitespace-nowrap pl-6 py-4 text-s text-sm">
              <p class="font-rubik capitalize">
                {{ user.first_name }} {{ user.last_name }}
              </p>
            </td>

            <td class="whitespace-nowrap py-4 text-s text-sm">
              <p class="font-rubik capitalize">
                {{ user.email }}
              </p>
            </td>

            <td class="whitespace-nowrap py-4 text-s text-sm">
              <p class="font-rubik capitalize">
                {{ user.password }}
              </p>
            </td>

            <td class="whitespace-nowrap py-4 text-s text-sm">
              <button
                @click="handleAccountSelection(user)"
                type="button"
                class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </td>
          </tr>
        </template>
      </BaseTable>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showRolesForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <p class="text-base font-bold">Choose Roles</p>
          <w-divider class="my6"></w-divider>
          <div v-if="isRoleFetching" class="flex justify-center my-4">
            <BaseSpinner />
          </div>
          <div v-else class="grid p-2 grid-cols-3 gap-1">
            <div v-for="(role, parentindex) in roles" :key="role.id">
              <div class="flex items-center p-1">
                <input
                  type="checkbox"
                  @change="handleRoleSelection(parentindex, role)"
                  class="w-4 h-4 accent-green-600 text-white mr-1 border-blue-700 border-2 cursor-pointer"
                  :id="role.id"
                  v-model="role.isSelected"
                />
                <label :for="role.id" class="mr-1"> {{ role.name }} </label>
              </div>
            </div>
          </div>
          <w-divider class="my6"></w-divider>
          <div>
            <div class="mt-1">
              <p class="text-base font-bold">Selected Users</p>
            </div>
            <p
              class="bggray2 rounde text-xs font-light italic mt-1 p-1"
              v-for="user in selectedUsers"
              :key="user.id"
            >
              <span class=""
                >{{ user.first_name.toUpperCase() }}
                {{ user.last_name.toUpperCase() }}</span
              >
            </p>
          </div>

          <w-divider class="my6 my-2"></w-divider>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showRolesForm = false">
              Close
            </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton
                v-if="selectedRoles.length > 0"
                class=""
                @click="changeUsersRoles"
              >
                Confirm
              </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <!-- error dialog -->
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

    <teleport to="#app">
      <BaseDialog :show="showUpdateAccountForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <aside class="rounded-lg flex item-center">
            <div
              class="rounded-l flex items-center justify-center w-36 bg-gradient-to-r from-blue-500 to-blue-600"
            >
              <i class="fa-solid fa-triangle-exclamation text-4xl text-white"></i>
            </div>
            <div
              class="rounded-r bg-gradient-to-r from-blue-500 to-blue-600 to-green-700 px-4 py-4"
            >
              <p class="font-rubik text leading-5 text-white">
                We recommend to change password only if user are unable to access account
                or have forgotten password.
              </p>
            </div>
          </aside>
          <div class="mt-4">
            <p class="text-base font-bold">Enter New Pasword</p>
            <BaseInput v-model="form.password" :hasError="validationError.password" />
          </div>

          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="handleCloseSelection">
              Close
            </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton class="" @click="showConfirmationDialog = true">
                Update Account
              </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>
    <teleport to="#app">
      <BaseDialog :show="showConfirmationDialog" :width="'500'" :preventClose="true">
        <template #c-content>
          <ConfirmCard
            :title="'Are you sure do you want to update user account password?'"
          >
          </ConfirmCard>

          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showConfirmationDialog = false">
              No
            </TableButton>
            <div class="my-1 mx-2" v-if="isConfirming">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton class="" @click="changePassword"> Yes </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      validationError: {},
      search: "",
      filterBy: "none",
      users: [],
      schools: [],
      roles: [],
      selectedRoles: [],
      selectedRole: null,
      selectedUsers: [],
      isFetching: false,
      isSchoolFetching: false,
      isRoleFetching: false,
      requestError: null,
      isSaving: false,
      showRolesForm: false,
      showConfirmationDialog: false,
      showUpdateAccountForm: false,
      selectedAccount: null,
      requestHasError: null,
      isConfirming: false,
    };
  },

  created() {
    this.loadUsers();
    // this.loadSchool();
    // this.LoadRoles();
  },

  watch: {
    search(olvalue, newvalue) {
      this.searchUser();
    },
  },

  methods: {
    async changePassword() {
      this.isConfirming = true;
      let password = this.form.password;

      let account_data = {
        id: this.selectedAccount.id,
        password: password,
      };

      await axiosApi
        .post("api/change-user-password", account_data)
        .then((res) => {
          this.showConfirmationDialog = false;
          this.showUpdateAccountForm = false;
          this.selectedAccount = null;
          this.form.password = "";
          this.showToast({ title: "Succesfully Update" });
          this.loadUsers();
        })
        .catch((err) => {
          this.showConfirmationDialog = false;
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestHasError =
              "Opp seems like there was an error when chnaging password, Try again or contact the developer if error keep occurig";
          }
        })
        .finally(() => {
          this.isConfirming = false;
        });
    },

    showToast({ title = "Succesfully Saved" }) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },
    handleAccountSelection(item) {
      this.selectedAccount = item;
      this.showUpdateAccountForm = true;
    },

    handleCloseSelection() {
      this.selectedAccount = null;
      this.showUpdateAccountForm = false;
    },

    handleRoleSelection(parentindex, role) {
      console.log(parentindex);
      console.log(role);
      this.roles.forEach((item) => {
        item.isSelected = false;
      });

      this.selectedRole = role.id;
      role.isSelected = true;
    },
    handleShowRolesForm() {
      this.showRolesForm = true;
      if (this.selectedUsers.length > 0) {
        const initial_roles = [];
        this.selectedUsers.forEach((element) => {
          element.roles.forEach((role) => {
            if (!initial_roles.includes(role.id)) {
              initial_roles.push(role.id);
            }
          });
        });

        this.selectedRoles = initial_roles;
        // // console.log(initial_roles);
      }
    },
    showToast({ title = "Succesfully Saved" }) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },
    async changeUsersRoles() {
      const usersid = [];

      this.selectedUsers.forEach((user) => {
        usersid.push(user.id);
      });

      this.isSaving = true;
      await axiosApi
        .post("api/manage-users-roles/change-role-selected-user", {
          usersid: usersid,
          role: this.selectedRole,
        })
        .then((res) => {
          this.selectedUsers = [];
          this.selectedRole = null;
          this.showRolesForm = false;
          this.loadUsers();
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    async LoadRoles() {
      this.isRoleFetching = true;
      await axiosApi
        .get("api/manage-users-roles/get-roles")
        .then((res) => {
          let modified_roles = [];

          res.data.data.forEach((item) => {
            let modified_role = {
              ...item,
              isSelected: false,
            };

            modified_roles.push(modified_role);
          });

          this.roles = modified_roles;
        })
        .finally(() => {
          this.isRoleFetching = false;
        });
    },
    async filterUser() {
      await axiosApi
        .post("api/manage-users-roles/filter", {
          filter: this.filterBy,
        })
        .then((res) => {
          console.log(res.data.data);
          this.users = res.data.data;
        });
    },
    closeErrorDialog() {
      this.requestError = null;
    },

    async loadSchool() {
      this.isSchoolFetching = true;
      axiosApi
        .get("api/schools ")
        .then((res) => {
          this.schools = res.data.data;
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },
    searchUser: _.debounce(async function () {
      await axiosApi
        .post("api/search-user-account", {
          search: this.search,
        })
        .then((res) => {
          this.users = res.data.data;
        });
    }, 300),

    async loadUsers() {
      this.isFetching = true;
      await axiosApi
        .get("api/get-user-without-google")
        .then((res) => {
          this.users = res.data.data;
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
