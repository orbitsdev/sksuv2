<template>
  <BaseCard :subtitle="'Manage Department'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton  class="mr-2" @click="handleShowForm(null, 'add')"
            ><i class="fa-solid fa-plus mr-1"> </i> Add Deparment
          </TableButton>

          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />

         
        </template>
        <template #filters-area>
          <div v-if="isSchooLoading">
            <BaseSpinner />
          </div>
          
        </template>
        <template #actions-area>
          <TableButton
            @click="deleteSelectedDepartment"
            v-if="selectedDeparment.length > 0"
            :mode="true"
            class="mr-2"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Selected (
            {{ selectedDeparment.length }} )
          </TableButton>
          <TableButton
            @click="deleteAllDepartment"
            v-if="departments.length > 0 && selectedDeparment.length <= 0"
            :mode="true"
          >
            <i class="fa-regular fa-trash-can mr-1"></i>
            <span class="block">Delete All</span>
          </TableButton>
        </template>
      </BaseTableSetup>
    </template>
    <BaseTable :thdata="['', 'Department',  '']" :isFetching="isFetching">
      <template #data>
        <tr v-for="department in departments" :key="department.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectedDeparment"
              :value="department"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
            />
          </td>
          <td class="text-sm">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900">{{ department.name }}</div>
              </div>
            </div>
          </td>
         
          <td class="py-2 text-sm text-gray-500">
            <button
              @click="handleShowForm(department, 'update')"
              :disabled="selectedDeparment.length > 0"
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
      <BaseDialog :show="showForm" :width="'600'" :preventClose="true">
        <template #c-content>
          <div class="">
            <BaseInput
              :label="'Department Name'"
              v-model="name"
              :hasError="validationError.name"
            />
          </div>
         
          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showForm = false"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton
                v-if="this.departmentSelected == null"
                class=""
                @click="createDepartment"
              >
                Save
              </TableButton>
              <TableButton v-else class="" @click="updateDepartment">
                Update
              </TableButton>
            </div>
          </div>
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

    <teleport to="#app">
      <BaseDialog :show="isDeleting" :width="'250'">
        <template #c-content>
          <div class="flex items-center">
            <BaseSpinner class="mx-2" />
            <p class="text-base mr-2">Deleting Department</p>
          </div>
        </template>
      </BaseDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  created() {
    this.loadDepartment();
  },

  
  data() {
    return {
      search: "",
      name: "",
      filterBy: "none",
      departments: [],
      selectedDeparment: [],
      selectedShool: null,
      isFetching: false,
      isUpdating: false,
      isSaving: false,
      isDeleting: false,
      requestError: null,
      validationError: {},
      showForm: false,
      departmentSelected: null,
    };
  },

  watch: {
    search(olvalue, newvalue) {
      this.searDepartment();
    },
  },
  methods: {

    async searDepartment() {


      await axiosApi
        .post("api/manage-department-search", {
          search: this.search,
        })
        .then((res) => {
          this.departments = res.data.data;
        });
    },

    

    

    handleShowForm(department, action) {
      this.validationError = {};

      if (action == "add") {
        this.name = "";
        this.departmentSelected = null;
      }

      if (action == "update") {

        
        this.departmentSelected = department;

        this.name = department.name;
      }

      this.showForm = true;
    },

    async deleteAllDepartment() {
      this.customConfirmationDialog({
        title: "Are you sure do you want to delete all departments?",
        passFunction: async () => {
          this.isDeleting = true;
          await axiosApi
            .post("api/manage-department-delete-all")
            .then((res) => {
              this.loadDepartment();
            })
            .catch((err) => {
              this.requestError = err;
            })
            .finally(() => {
              this.isDeleting = false;
            });
        },
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
    async deleteSelectedDepartment() {
      this.customConfirmationDialog({
        title: "Are you sure do you want to delete selecred departments?",
        passFunction: async () => {
          const deparmentid = [];

          this.selectedDeparment.forEach((element) => {
            deparmentid.push(element.id);
          });

          this.isDeleting = true;
          await axiosApi
            .post("api/manage-department-delete-selected", {
              deparmentid: deparmentid,
            })
            .then((res) => {
              this.selectedDeparment = [];
              this.loadDepartment();
            })
            .catch((err) => {
              this.requestError = err;
            })
            .finally(() => {
              this.isDeleting = false;
            });
        },
      });
    },
    async loadDepartment() {
      this.isFetching = true;
      await axiosApi
        .get("api/manage-department")
        .then((res) => {
          this.departments = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async createDepartment() {
      this.isSaving = true;
      await axiosApi
        .post("api/manage-department-create", {
          name: this.name,
        })
        .then((res) => {
          this.showForm = false;
          this.name = "";
          this.loadDepartment();
        })
        .catch((err) => {
          console.log(err);
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = err;
          }
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    async updateDepartment() {
      this.isSaving = true;
      await axiosApi
        .post("api/manage-department-update", {
          name: this.name,
          id: this.departmentSelected.id,
        })
        .then((res) => {
          this.showForm = false;
          (this.name = ""), (this.departmentSelected = null);
          this.loadDepartment();
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = err;
          }
        })
        .finally(() => {
          this.isSaving = false;
        });
    },
  },
};
</script>

<style scoped></style>
