<template>
  <BaseCard :subtitle="'Manage Department'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton @click="handleShowForm(null, 'add')"
            ><i class="fa-solid fa-plus mr-1"> </i> Add Deparment
          </TableButton>
        </template>
        <template #filters-area> </template>
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
    <BaseTable :thdata="['', 'Department', 'University', '']" :isFetching="isFetching">
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
          <td class="text-sm">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900" v-if="department.school != null">
                  {{ department.school.name }} - {{ department.school.id }}
                </div>

                <span
                  v-else
                  class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                  >None</span
                >
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
          <div class="pt-2">
            <label for="cover-photo" class="block text-base font-medium text-gray-700"
              >University
              {{ selectedShool }}
            </label>
            <select
            v-model="selectedShool"
              v-if="schools.length > 0"
              class="block hover:shadow-lg rounded w-full px-3 py-2 border text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
            >
              <option
                v-for="option in schools"
                :key="option.id"
                class="py-2"
                :value="option.id"
              >
                {{ option.name }}-
                {{ option.id }}
              </option>
            </select>
            <select
              v-else
              class="block hover:shadow-lg rounded w-full px-3 py-2 border text-gray-600 placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none sm:text-sm"
            >
              <option>No university found</option>
            </select>
            <p v-if="validationError.school_id" class="mx-2 text-red-500 text-sm my-2">
              {{ validationError.school_id[0] }}
            </p>
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
    this.loadSchool();
    this.loadDepartment();
  },
  data() {
    return {
      name: "",
      departments: [],
      selectedDeparment: [],
      schools: [],
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
  methods: {
    setSchool(e) {
      this.selectedShool = e.target.value;
    },

    async loadSchool() {
      this.isFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;

          if (this.schools.length > 0) {
            this.selectedShool = this.schools[0].id;
          }
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
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

        if (department.school != null) {
            this.selectedShool = department.school.id;
        }
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
          school_id: this.selectedShool,
        })
        .then((res) => {
          this.showForm = false;
          this.name = "";
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

    async updateDepartment() {
      this.isSaving = true;
      await axiosApi
        .post("api/manage-department-update", {
          name: this.name,
          id: this.departmentSelected.id,
          school_id: this.selectedShool,
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
