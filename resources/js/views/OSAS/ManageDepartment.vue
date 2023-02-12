<template>
  <BaseCard :subtitle="'Manage Organizations'">
   
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton  class="mr-2" @click="handleShowForm(null, 'add')"
            ><i class="fa-solid fa-plus mr-1"> </i> Add Organization
          </TableButton>

          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />

         
        </template>
        <template #filters-area>
         
          
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
    <BaseTable :thdata="['', 'Organizations', 'University', 'School Year', '']" :isFetching="isFetching">
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
            <StatusCard v-if="department.school != null" class="bg-green-700 text-white">
              {{ department.school.name }}
            </StatusCard>

          </td>



          <td class="text-sm">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900" v-if="department.school != null  && department.school.school_year !=null ">SY.{{ department.school.school_year.from }} - {{ department.school.school_year.to }}</div>
                <StatusCard class="font-medium bg-gray-700 text-white" v-else >None</StatusCard>
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
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <!-- {{ selected_school_year   }}
          {{ selected_school   }}

          <hr>
          {{ departmentSelected }} -->

          <section class="mt-4"  v-if="this.departmentSelected == null" >
            <div>
              <p class="text-base  font-rubik text-gray-800 ">School Year</p>
              <NoDataCard v-if="school_years.length <= 0"> Empty </NoDataCard>
              <select
              @change="changeHandler"
                v-else
                v-model="selected_school_year"
                class="block  w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option class=""  v-for="sy in school_years" :key="sy.id" :value="sy.id">
                  SY. {{ sy.from }} - {{ sy.to }}
                </option>
              </select>
            </div>
          </section>
          <section class="mt-4"  v-if="this.departmentSelected == null" >
            <div>
              <p class="text-base  font-rubik text-gray-800 ">University</p>
              
              <NoDataCard v-if="schools.length <= 0">Empty </NoDataCard>
              <select
                v-else
                v-model="selected_school"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option v-for="school in schools" :key="school.id" :value="school.id">
                  {{ school.name }}
                </option>
              </select> 
            </div>
          </section>

          <section class="mt-4">
            <div class="">
              <p class="text-base  font-rubik text-gray-800 ">Organization Name</p>
              <BaseInput
                
                v-model="name"
                :hasError="validationError.name"
              />
            </div>
          </section>
         
          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="showForm = false"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>

              <div v-if="selected_school != null">
                <TableButton
                v-if="this.departmentSelected == null "
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
            <p class="text-base mr-2">Deleting Organization</p>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <GlobalErrorCard  @close="requestHasError = null" :show="requestHasError != null">
    </GlobalErrorCard>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  created() {
    this.loadDepartment();
    this.getAllSchoolYears();
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

      school_years: [],
      schools:[],

      selected_school: null,
      selected_school_year: null,
      isSchoolYearFetching:false,
      requestHasError:null,
    };
  },

  watch: {
    search(olvalue, newvalue) {
      this.searDepartment();
    },
  },
  methods: {

    changeHandler(event) {
      
      let year_with_schools = this.school_years.find((i) => i.id == event.target.value);
      this.schools = year_with_schools.schools;
      this.selected_school = null;
      if (this.schools.length > 0) {
        this.selected_school = this.schools[0].id;
      }

    },
    

    
    async getAllSchoolYears() {
      this.isSchoolYearFetching = true;

      await axiosApi
        .get("api/school-year-with-schools")
        .then((res) => {
          this.school_years = res.data.data;
          if (this.school_years.length > 0) {
            this.selected_school_year = this.school_years[0].id;

            this.schools = this.school_years[0].schools;

            if (this.schools.length > 0) {
              this.selected_school = this.schools[0].id;
            }
          }
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isSchoolYearFetching = false;
        });
    },


    searDepartment: _.debounce(async function () {
      await axiosApi
        .post("api/manage-department-search", {
          search: this.search,
        })
        .then((res) => {
          this.departments = res.data.data;
        });
    }, 300),
   

    

    

    handleShowForm(department, action) {

    
      this.validationError = {};

      if (action == "add") {
        this.name = "";
        this.departmentSelected = null;
      }

      if (action == "update") {

        
        this.departmentSelected = department;

        if(this.departmentSelected.school != null){
            this.selected_school = this.departmentSelected.school.id;
        }
        if(this.departmentSelected.school.school_year != null){
            this.selected_school_year = this.departmentSelected.school.school_year.id;
        }



        console.log(this.departmentSelected);


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
              this.requestHasError = '"Oops! It seems like there was an error when  deleting department, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

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
              this.requestHasError = '"Oops! It seems like there was an error when  when deleting department, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

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

          this.requestHasError = '"Oops! It seems like there was an error when  fetchin departments, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';


        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async createDepartment() {



      let deparment_data = {
        school_id: this.selected_school,
        school_year_id: this.selected_school_year,
        name:this.name,
      }

      this.isSaving = true;
      await axiosApi
        .post("api/manage-department-create", deparment_data)
        .then((res) => {


          this.selected_school= null;
          this.selected_school_year= null;
          this.showForm = false;
          this.name = "";
          
          this.loadDepartment();
          this.getAllSchoolYears();
        })
        .catch((err) => {
        
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestHasError = '"Oops! It seems like there was an error when creating department, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

          }
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    async updateDepartment() {
      this.isSaving = true;

      let deparment_data = {
        school_id: this.selected_school,
        school_year_id: this.selected_school_year,
        name:this.name,
        id: this.departmentSelected.id,
      }

      await axiosApi
        .post("api/manage-department-update", deparment_data)
        .then((res) => {
          this.departmentSelected = null;
          this.selected_school= null;
          this.selected_school_year= null;
          this.name = "";
          this.showForm = false;
          
          this.loadDepartment();
          this.getAllSchoolYears();

        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestHasError = '"Oops! It seems like there was an error when  updating  department school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

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
