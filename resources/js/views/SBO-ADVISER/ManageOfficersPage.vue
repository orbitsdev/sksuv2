<template>
  <BaseCard :subtitle="'Manage Department'">
    <template #header>
     
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2"
            ><i class="fa-solid fa-plus mr-1"> </i> Add Officer
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
      </BaseTableSetup>

      <ul
        role="list"
        class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <li
          class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow"
          v-for="item in officers"
          :key="item"
        >
          <div class="flex flex-1 flex-col p-8">
            <img
              class="mx-auto h-32 w-32 flex-shrink-0 rounded-full"
              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
              alt=""
            />
            <h3 class="mt-6 text-sm font-medium text-gray-900">
              {{ item.first_name }} {{ item.first_name }}
            </h3>
            <dl class="mt-1 flex flex-grow flex-col justify-between">
              <dt class="sr-only">Title</dt>
              <dd class="text-sm text-gray-500">Paradigm Representative</dd>
              <dt class="sr-only">Role</dt>
              <dd class="mt-3">
                <span
                  class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800"
                  >Admin</span
                >
              </dd>
            </dl>
          </div>
          <div>
            <div class="-mt-px flex divide-x divide-gray-200">
              <div class="flex w-0 flex-1">
                <a
                  href="mailto:janecooper@example.com"
                  class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                >
                  <!-- Heroicon name: mini/envelope -->
                  <svg
                    class="h-5 w-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z"
                    />
                    <path
                      d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z"
                    />
                  </svg>
                  <span class="ml-3">Email</span>
                </a>
              </div>
              <div class="-ml-px flex w-0 flex-1">
                <a
                  href="tel:+1-202-555-0170"
                  class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                >
                  <!-- Heroicon name: mini/phone -->
                  <svg
                    class="h-5 w-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span class="ml-3">Call</span>
                </a>
              </div>
            </div>
          </div>
        </li>

        <!-- More people... -->
      </ul>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'600'" :preventClose="true">
        <template #c-content>
<!-- 
          {{ selectedStudent }}
          {{ selectedPosition }}
          {{ selectedDepartment }} -->
          {{ officers }}
            <div class="mb-4" >
              <div>
                <label
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  >Choose Student from:  <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5">{{ User.schools[0].name }} </span>

                </label>

                <select
                v-model="selectedStudent"
                v-if="studentoptions.length > 0"
                  class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
                > 
                  <option v-for="item in studentoptions" :key="item.id" :value="item.id"> {{ item.first_name }} {{ item.first_name }} </option>
                </select>
              </div>
              <p class="text-xs mx-1 text-red-500 mt-1"
              v-if="validationError != null && validationError.student_id"
              > 
            {{ validationError.student_id[0] }}
            </p>
   
            
              <!-- <p
              class="text-xs text-red-500 mt-1"
              v-if="validationError != null && validationError.title"
            >
              {{ validationError.title[0] }}
            </p> -->
            </div>


            <div class="mb-4" >
              <div>
                <label
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  >Choose Sbo position

                </label>

                <select
                v-model="selectedPosition"
                v-if="position.length > 0"
                  class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
                > 
                  <option v-for="item in position" :key="item.id" :value="item"> {{ item.name }} </option>
                </select>
              </div>
              <p class="text-xs mx-1 text-red-500 mt-1"
              v-if="validationError != null && validationError.position_name"
              > 
            {{ validationError.position[0] }}
            </p>
            </div>
            <div class="mb-4" >
              <div>
                <label
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  >Choose Department

                </label>

                <select
                v-model="selectedDepartment"
                v-if="departments.length > 0"
                  class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-gray focus:border-gray-300 sm:text-sm sm:leading-5"
                > 
                  <option v-for="item in departments" :key="item.id" :value="item.id" class="capitalize"> <span class="capitalize">{{ item.name }}</span> </option>
                </select>
              </div>
              <p class="text-xs mx-1 text-red-500 mt-1"
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
            <div >
              <TableButton
              @click="createOfficer"
                class=""
              >
                Save
              </TableButton>

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
  data() {
    return {
      search: "",
      isSaving: false,
      isFetching: false,
      isStudentFetching: false,
      showForm: true,
      requestError: null,
      validationError: {},
      officers: [],
      studentoptions: [],
      departments: [],
      position: [
      ],

      selectedStudent: null,
      selectedDepartment: null,
      selectedPosition:null,


    };
  },



  created() {
    this.getOfficers();
    this.getStudent();
    this.loadDepartment();

    this.position = [
        { id:  1,  name: 'Governor', value: 'Governor'},
        { id:  2,  name: 'Vice Governor', value: 'Vice Governor'},
        { id:  3,  name: 'Board Member', value: 'Board Member'},
    ];

    this.selectedPosition = this.position[0];
  
  },

  computed: {
    ...mapGetters(['User']),
  },

  methods: {


    async createOfficer(){
      this.isSaving = true;

      const newOfficer = {
        student_id: this.selectedStudent,
        position: this.selectedPosition.name,
        department_id:  this.selectedDepartment, 

      }


      await axiosApi
        .post("api/manage-officer/create-officer", newOfficer )
        .then((res)=>{
          console.log(res)
      }).catch(err=>{
        if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = err;
          }
      }).finally(()=>{
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

          if(this.departments.length > 0){
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
      await axiosApi
        .get("api/manage-officer/get-students")
        .then((res) => {



          this.studentoptions = res.data.data;

          if(this.studentoptions.length > 0){
            this.selectedStudent = this.studentoptions[0].id;
          }
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {});
    },
    async getOfficers() {
      await axiosApi
        .get("api/manage-officer/get-officers")
        .then((res) => {

            console.log(res.data.data);
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

<style scoped></style>
