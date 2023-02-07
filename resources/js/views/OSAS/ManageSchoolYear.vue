<template>
  <BaseCard :subtitle="'Manage School Year'">
    <template #header>
      {{ selectedSchoolYear }}  
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showForm = true">
            <i class="fa-solid fa-plus mr-1"></i> Add School Year
          </TableButton>
        </template>
        <template #actions-area>
          <TableButton
            class="mr-2"
            mode
            @click="showConfirmation = true"
            v-if="selectedSchoolYears.length > 0"
          >
            Delete School Yeaer
            {{ selectedSchoolYears.length }}
          </TableButton>
        </template>
      </BaseTableSetup>

      <BaseTable :thdata="[' ', 'School Year', 'Univerity', '']" :isFetching="isFetching">
        <template #data>
          

          <tr v-for="schoolyear in schoolyears" :key="schoolyear">
            <td class="whitespace-normal align-top relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                v-model="selectedSchoolYears"
                :value="schoolyear.id"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="whitespace-normal align-top py-4">
              <p
                tabindex="0"
                class="whitespace-normal pl-2 align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800 "
              >
                SY. {{ schoolyear.from }}-{{ schoolyear.to }}
              </p>
            </td>
            <td class="whitespace-normal align-top py-4">
              <p
                tabindex="0"
                class="whitespace-normal pl-2 align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800 "
              >
                <StatusCard class="bg-green-100 text-green-700"> {{ schoolyear.schools.length }} </StatusCard>
              </p>
            </td>
            <td>
              <button
                @click="selecSchoolYear(schoolyear)"
                :disabled="selectedSchoolYears.length > 0"
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
      <BaseDialog :show="showForm" :width="'600'" :preventClose="true" class="h-96">
        <template #c-content>
          <p class="text-lg font-bold">Choose Year</p>
         
          <div class=" bg-green-700 py-4 px-6 rounded-lg  grid grid-cols-2 my-2 gap-x-2 mt-4">
            <div class="col-span-1">
              <p class="mb-1 text-sm font-bold  capitalize text-white">From</p>

              <Datepicker
                class="px-2 py-2 w-full text-lg border"
                v-model="fromYear"
                :inputFormat="'yyyy'"
                :minimum-view="'year'"
              />
            </div>
            <div class="col-span-1">
              <p class="mb-1 text-sm font-bold  capitalize text-white">to</p>

              <Datepicker
                class="px-2 py-2 w-full text-lg border"
                v-model="toYear"
                :inputFormat="'yyyy'"
                :minimum-view="'year'"
              />
            </div>
          </div>

          <div class="my-4 h-72 flex items-center justify-center">
            <img src="/assets/undraw_my_files_swob.svg" alt="" class="h-36">
          </div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="handleCloseForm"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>

            <div v-else>
              <TableButton
                v-if="this.selectedSchoolYear == null"
                class=""
                @click="saveYear"
              >
                Save
              </TableButton>
              <TableButton v-else
              @click="updateSchoolYear"
              class=""> Update </TableButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>
    <teleport to="#app">
      <BaseDialog
        :show="showConfirmation"
        :width="'600'"
        :preventClose="true"
        class="h-96"
      >
        <template #c-content>
          <ConfirmCard
            :title="'Are you sure? Do you want to delete this school years?'"
            :message="'Be mindful that deleting this data will also remove all associated informations. This action cannot be undone. Do you still wish to proceed?'"
          >
            <div class="col-span-1 flex justify-center items-center" v-if="isDeleting">
              <BaseSpinner />
            </div>
            <button
              v-else
              @click="deleteSelectedSchoolYear"
              class="col-span-1 transition duration-150 ease-in-out hover:bg-red-600 bg-red-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            >
              Yes
            </button>
            <button
              class="col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
              @click="showConfirmation = false"
            >
              Close
            </button>
          </ConfirmCard>
        </template>
      </BaseDialog>
    </teleport>

    <GlobalErrorCard  @close="requestError = null" :show="requestError != null">
    </GlobalErrorCard>
  </BaseCard>
</template>

<script>


import axiosApi from "../../api/axiosApi";
export default {
  components: {
  
  },

  created() {
    this.getAllSchoolYears();
  },
  data() {
    return {
      yearFormat: "YYYY",

      viewMode: "years",
      isSaving: false,
      search: "",
      showForm: false,
      isFetching: false,
      schoolyears: [],
      selectedSchoolYears: [],
      selectedSchoolYear: null,
      validationError: null,
      requestError: null,
      fromYear: new Date(),
      toYear: new Date(),
      isUpdatingMode: false,
      showConfirmation: false,
      isDeleting: false,
    };
  },

  methods: {
    showConfirmationModal() {
      this.showConfirmation = true;
    },

    closeConfirmationModal() {
      this.showConfirmation = false;
    },

    async deleteSelectedSchoolYear() {
      console.log(this.selectedSchoolYears);

      this.isDeleting = true;

      await axiosApi
        .post("api/school-year/delete-selected-school-year", {
          school_years: this.selectedSchoolYears,
        })
        .then((res) => {
          this.selectedSchoolYears = [];
          this.showConfirmation = false;
          this.getAllSchoolYears();
        })
        .catch((err) => {
          console.log(err);

          this.requestError = '"Oops! It seems like there was an error when deleting, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isDeleting = false;
        });
    },

    async getAllSchoolYears() {
      this.isFetching = true;

      await axiosApi
        .get("api/school-year-with-schools")
        .then((res) => {
          this.schoolyears = res.data.data;
        })
        .catch((err) => {
          this.requestError = '"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

        })
        .finally(() => {
          this.isFetching = false;
        });
    },
    handleCloseForm() {
      this.isUpdatingMode = false;
      this.selectedSchoolYear = null;
      this.showForm = false;
    },

    selecSchoolYear(item) {
      this.selectedSchoolYear = item;
      this.fromYear =  new Date(item.from, 0, 1);
      this.toYear =  new Date(item.to, 0, 1);
      this.showForm = true;
    },

    async updateSchoolYear() {
      this.isSaving = true;
      

      let school_year = {
        fromYear: this.fromYear.getFullYear(),
        toYear: this.toYear.getFullYear(),
        id: this.selectedSchoolYear.id,
      };

      await axiosApi
        .post("api/school-year/update", school_year)
        .then((res) => {
          this.showForm = false;
          this.selectedSchoolYears = [];
          this.getAllSchoolYears();
        })
        .catch((err) => {
          this.requestError = '"Oops! It seems like there was an error when  updating school year , Please check your network connection. o and try again. if you think it it was the system please do contact the developer';

        })
        .finally(() => {
          this.isSaving = false;
        });
    },
    async saveYear() {
      this.isSaving = true;
 
      let school_year = {
        fromYear: this.fromYear.getFullYear(),
        toYear: this.toYear.getFullYear(),
      };

      await axiosApi
        .post("api/school-year/create", school_year)
        .then((res) => {
          this.showForm = false;
          this.selectedSchoolYears = [];
          this.getAllSchoolYears();
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isSaving = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
