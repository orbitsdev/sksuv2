<template>








  <div class="py-4">
    {{ this.$route.params.id }}
  
    <TableButton @click="this.$router.push({name:'select-school-year-for-manage-officers'})">
      
      Go Back </TableButton>  
  </div>
  <BaseCard :subtitle="'Manage Officer'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="handleShowForm(null, 'add')"
            ><i class="fa-solid fa-plus mr-1"> </i> Add Officer
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #actions-area>
          <TableButton
            @click="showDeleteConfirmation = true"
            v-if="selectedOfficers.length > 0"
            :mode="true"
            class="mr-2"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Delete (
            {{ this.selectedOfficers.length }} )
          </TableButton>
        </template>
      </BaseTableSetup>

      <BaseTable
        :thdata="['', 'Name', 'Position', 'Department', '']"
        :isFetching="isSaving"
      >
        <template v-if="officers.length > 0" #data>
          <tr v-for="officer in officers" :key="officer.id">
            <td class="whitespace-normal relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                v-model="selectedOfficers"
                :value="officer.id"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="whitespace-normal text-sm">
              <div class="flex items-center">
                <div class="">
                  <div class="font-medium text-gray-900">
                    {{ officer.student.first_name }} {{ officer.student.last_name }}
                  </div>
                </div>
              </div>
            </td>

            <td>
              <div class="font-medium text-gray-900">{{ officer.position }}</div>
            </td>
            <td>
              <div class="font-medium text-gray-900">{{ officer.department.name }}</div>
            </td>

            <td class="whitespace-normal py-2 text-sm text-gray-500">
              <button
                :disabled="selectedOfficers.length > 0"
                @click="handleShowForm(officer, 'update')"
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
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <div v-if="(isUpdatingMode == false && studentoptions.length == 0 && isStudentFetching == false)"  >
           
            <div class="my-10 flex justify-center">
              <img src="/assets/undraw_choosing_house_re_1rv7.svg" width="200" height="200" />
              <div class="flex-col items-center justify-center p-4 ">
                <p class="font-bold  text-center text-lg">
                  No such students was available at your current school  
                </p>
                <p class=" text-center  ">
                  Student must register to this school first
                </p>

              </div>
            </div>

            <div class=" flex justify-center  ">
              <TableButton  @click="showForm = false"  class="w-full"> I Understand </TableButton>
            </div>


          </div>

        <div v-else>

          

          <div v-if="isUpdatingMode == true">


            <div class="0">
              <img
                class="h-20 w-20 rounded-full lg:h-24 lg:w-24"
                src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80"
                alt=""
              />
              <div class="space-y-2">
                <div class="mt-4 text-xs font-medium lg:text-sm">
                  <h3 class="capitalize">
                    {{ this.selectedOfficer.student.first_name }}
                    {{ this.selectedOfficer.student.last_name }}
                  </h3>
                  <p class="text-indigo-600">{{ this.selectedOfficer.position }}</p>
                  <p class="text-indigo-600">
                    {{ this.selectedOfficer.department.name }}
                  </p>
                </div>
              </div>
            </div>
            <w-divider class="my6 my-2"></w-divider>
          </div>

          <div class="mb-4" v-if="isUpdatingMode == false">
            <div>
              <label class="block font-bold mb-2 text-gray-700 capitalize"
                >Choose Student from:
                <span
                  class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5"
                  >{{ User.schools[0].name }}
                </span>
              </label>

              <select
                v-model="selectedStudent"
                v-if="studentoptions.length > 0"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
              >
                <option v-for="item in studentoptions" :key="item.id" :value="item.id">
                  {{ item.email}}
                </option>
              </select>
            </div>

            <p
              class="text-xs mx-1 text-red-500 mt-1"
              v-if="validationError != null && validationError.student_id"
            >
              {{ validationError.student_id[0] }}
            </p>
          </div>

          <div class="mb-4">
            <div>
              <label class="block font-bold mb-2 text-gray-700 capitalize"
                >Choose Sbo position
              </label>

              <select
                v-model="selectedPosition"
                v-if="position.length > 0"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
              >
                <option v-for="item in position" :key="item.id" :value="item">
                  {{ item.name }}
                </option>
              </select>
            </div>
            <p
              class="text-xs mx-1 text-red-500 mt-1"
              v-if="validationError != null && validationError.position_name"
            >
              {{ validationError.position[0] }}
            </p>
          </div>
          <div class="mb-4">
            <div>
              <label class="block font-bold mb-2 text-gray-700 capitalize"
                >Choose Department
              </label>

              <select
                v-model="selectedDepartment"
                v-if="departments.length > 0"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
              >
                <option
                  v-for="item in departments"
                  :key="item.id"
                  :value="item.id"
                  class="capitalize"
                >
                  <span class="capitalize">{{ item.name }}</span>
                </option>
              </select>
            </div>
            <p
              class="text-xs mx-1 text-red-500 mt-1"
              v-if="validationError != null && validationError.department_id"
            >
              {{ validationError.department_id[0] }}
            </p>
          </div>

          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showForm = false"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton v-if="isUpdatingMode" @click="updateOfficer" class="">
                Update
              </TableButton>
              <TableButton v-else @click="createOfficer" class=""> Save </TableButton>
            </div>
          </div>
        </div>

        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="showDeleteConfirmation" :width="'400'">
        <template #c-content>
          <div class="mb-4">
            <p class="font-bold text-lg">
              Are you sure do you want to delete selected officers?
            </p>
            <div class="my-10 flex justify-center">
              <img src="/assets/undraw_throw_away_re_x60k.svg" width="200" height="200" />
            </div>
          </div>

          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showDeleteConfirmation = false">
              Close
            </TableButton>
            <div class="my-1 mx-2" v-if="isConfirming">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton class="" @click="deleteSelectedOfficer"> Yes </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import { mapGetters } from "vuex";

import axiosApi from "../../api/axiosApi";
export default {

  computed: {
    schoolYearId() {
      return this.$route.params.id;
    },
  },
  data() {
    return {
      search: "",
      isSaving: false,
      isFetching: false,
      isStudentFetching: false,
      showForm: false,
      requestError: null,
      validationError: {},
      officers: [],
      studentoptions: [],
      departments: [],
      position: [],
      selectedStudent: null,
      selectedDepartment: null,
      selectedPosition: null,
      selectedOfficer: null,
      selectedOfficers: [],
      isUpdatingMode: false,
      showDeleteConfirmation: false,
      isConfirming: false,
    };
  },

  created() {
    this.getOfficers();
    this.getStudent();
    this.loadDepartment();

    this.position = [
      { id: 1, name: "Governor", value: "Governor" },
      { id: 2, name: "Vice Governor", value: "Vice Governor" },
      { id: 3, name: "Board Member", value: "Board Member" },
    ];

    this.selectedPosition = this.position[0];
  },

  computed: {
    ...mapGetters(["User"]),
  },

  methods: {
    async deleteSelectedOfficer() {
      this.isConfirming = true;
      axiosApi
        .post("api/manage-officer/delete-selected-officer", {
          officers: this.selectedOfficers,
        })
        .then((res) => {
          this.getOfficers();
          this.getStudent();
          this.selectedOfficers = [];
          this.showDeleteConfirmation = false;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isConfirming = false;
        });
    },

    async updateOfficer() {
      this.isSaving = true;

      const newOfficer = {
        officer_id: this.selectedOfficer.id,
        position: this.selectedPosition.name,
        department_id: this.selectedDepartment,
      };

      await axiosApi
        .post("api/manage-officer/update-officer", newOfficer)
        .then((res) => {
          this.getOfficers();
          this.getStudent();
          this.selectedOfficers = [];
          this.showDeleteConfirmation = false;
          this.isUpdatingMode = false;
          this.showForm = false;
          this.selectedOfficer = null;
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
    handleShowForm(item, action) {
      this.showForm = true;
      this.validationError = {};

      if (item == null && action == "add") {
        this.isUpdatingMode = false;
        this.selectedOfficer = null;

        if (this.studentoptions.length == 0) {
          this.getStudent();
        }
        if (this.departments.length == 0) {
          this.loadDepartment();
        }
      }

      if (item != null && action == "update") {
        this.isUpdatingMode = true;
        this.selectedOfficer = item;
      }
    },

    async createOfficer() {
      this.isSaving = true;

      const newOfficer = {
        student_id: this.selectedStudent,
        position: this.selectedPosition.name,
        department_id: this.selectedDepartment,
      };

      await axiosApi
        .post("api/manage-officer/create-officer", newOfficer)
        .then((res) => {
          this.showForm = false;
          this.getStudent();
          this.getOfficers();
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

    async loadDepartment() {
      const alldeparment_api = "api/manage-department";
      const school_department_api = "api/manage-officer/get-school-department";

      this.isFetching = true;
      await axiosApi
        .get(alldeparment_api)
        .then((res) => {
          this.departments = res.data.data;

          if (this.departments.length > 0) {
            this.selectedDepartment = this.departments[0].id;
          }
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async getStudent() {

      this.isStudentFetching = true;
      await axiosApi
        .get("api/manage-officer/get-students")
        .then((res) => {
          this.studentoptions = res.data.data;

          if (this.studentoptions.length > 0) {
            this.selectedStudent = this.studentoptions[0].id;
          }
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isStudentFetching = false;
        });
    },
    async getOfficers() {
      await axiosApi
        .get("api/manage-officer/get-officers")
        .then((res) => {
          this.officers = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {});
    },
  },
};
</script>

<style scoped>

.custom-close{
  position: absolute;
  top: -20px;
  right: -20px;

}
</style>
