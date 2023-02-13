use App\Models\CampusSboAdviser;
<template>
  <BaseCard class="relative" :subtitle="'Campus Deans'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showMainForm = true">
            <i class="fa-solid fa-plus mr-1"></i> ADD CAMPUS DEANS
          </TableButton>
          <BaseSearchInput :placeholder="'Search name ..'" v-model="search" />
        </template>
        <template #filters-area>
          <div v-if="isSchooLoading">
            <BaseSpinner />
          </div>
          <div class="flex items-center" v-else></div>
        </template>
        <template #actions-area>
          <TableButton
            @click="showDeleteConfirmation = true"
            v-if="seleted_deans.length > 0"
            mode
          >
            <i class="fa-regular fa-trash-can mr-1"></i>
            <span class="block">Delete Selected </span>
          </TableButton>
        </template>
      </BaseTableSetup>
    </template>

    <BaseTable
      :thdata="['', 'Year', 'Campus Dean', 'University', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="item in campus_deans" :key="item.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="seleted_deans"
              :value="item.id"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-green-700">
            <p class="font-semibold font-rubik">
              SY.{{ item.school_year.from }} - {{ item.school_year.to }}
            </p>
          </td>
          <td class="whitespace-nowrap py-4">
            <!-- <StatusCard class="bg-rose-700 text-rose-100 capitalize" >
            </StatusCard> -->
            <p class="capitalize">
              {{ item.user.first_name + " " + item.user.last_name }}
            </p>
          </td>

          <td class="whitespace-nowrap py-4 text-sm text-gray-900">
            <StatusCard v-if="item.school != null" class="bg-green-700 text-white">
              {{ item.school.name }}
            </StatusCard>
            <StatusCard v-else class="bg-gray-700 text-white"> None </StatusCard>
          </td>
          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            
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

    <teleport to="#app">
      <BaseDialog :show="showMainForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <!-- {{ selected_dean }} -->
          <section class="mt-2">
            <div>
              <p class="text-base font-bold">Select School Year</p>
              <NoDataCard v-if="school_years.length <= 0"> Empty </NoDataCard>
              <select
                @change="changeHandler"
                v-else
                v-model="selected_school_year"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option v-for="sy in school_years" :key="sy.id" :value="sy.id">
                  SY. {{ sy.from }} - {{ sy.to }}
                </option>
              </select>
            </div>
          </section>
          <section class="mt-2">
            <div>
              <p class="text-base font-bold">Select University</p>
              <NoDataCard v-if="schools.length <= 0">Empty </NoDataCard>
              <select
                v-else
                v-model="selecated_school"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option v-for="school in schools" :key="school.id" :value="school.id">
                  {{ school.name }}
                </option>
              </select>
            </div>
          </section>
          <section class="mt-2">
            <div>
              <p class="text-base font-bold mt-4">Select User</p>
              <NoDataCard v-if="users.length <= 0">Empty </NoDataCard>
              <select
                v-else
                v-model="selected_dean"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.first_name }} {{ user.last_name }}
                </option>
              </select>
            </div>
          </section>

          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="handleCloseForm"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <div
                v-if="
                  selected_dean == null ||
                  selecated_school == null ||
                  selected_school_year == null
                "
              ></div>
              <div v-else>
                <TableButton v-if="isUpdatingMode" class="" @click="updateCampusAdviser">
                  Update
                </TableButton>
                <TableButton v-else class="" @click="addDean">
                  Save
                </TableButton>
              </div>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog
        :show="showDeleteConfirmation"
        :width="'600'"
        :preventClose="true"
        class="h-96"
      >
        <template #c-content>
          <ConfirmCard
            :title="'Are you sure? Do you want to delete these Campus Advisers?'"
            :message="'Be mindful that deleting this data will also remove all associated informations. This action cannot be undone. Do you still wish to proceed?'"
          >
            <div class="col-span-1 flex justify-center items-center" v-if="isDeleting">
              <BaseSpinner />
            </div>
            <button
              v-else
              @click="deleteSelected"
              class="col-span-1 transition duration-150 ease-in-out hover:bg-red-600 bg-red-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            >
              Yes
            </button>
            <button
              class="col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
              @click="showDeleteConfirmation = false"
            >
              Close
            </button>
          </ConfirmCard>
        </template>
      </BaseDialog>
    </teleport>
    <GlobalErrorCard @close="hasRequestError = null" :show="hasRequestError != null">
    </GlobalErrorCard>
    <GlobalWarning @close="hasWarning = null" :show="hasWarning != null">
      {{ hasWarning }}
    </GlobalWarning>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  created() {
    this.getDeans();
    this.getAllSchoolYears();
    // this.loadSchool();
    this.getUsers();
  },

  data() {
    return {
      filterBy: "none",
      showForm: false,
      search: "",
      sboadvisers: [],
      selectedSboAdvisers: [],
      requestError: null,
      isFetching: false,
      isSchooLoading: false,
      isSaving: false,
      requestError: null,
      showMainForm: false,
      hasRequestError: null,

      campus_deans: [],
      users: [],
      schools: [],
      school_years: [],

      selected_dean: null,
      selecated_school: null,
      selected_school_year: null,

      isSchoolYearFetching: false,
      isAvailabeUserFetching: false,
      isSchoolFetching: false,

      seleted_deans: [],
      selectedCampusAdviser: null,
      showDeleteConfirmation: false,
      isDeleting: false,
      isUpdatingMode: false,
      hasWarning: null,
      isFetchingUser: false,
    };
  },

  watch: {
    search(oldeValue, newValue) {
      this.searchDean();
    },
  },

  methods: {
  

    changeHandler(event) {
      let year_with_schools = this.school_years.find((i) => i.id == event.target.value);
      this.schools = year_with_schools.schools;
      this.selecated_school = null;
      if (this.schools.length > 0) {
        this.selecated_school = this.schools[0].id;
      }
    },

    chnageSchoolData() {},
    handleCloseForm() {
      this.selectedCampusAdviser = null;
      this.isUpdatingMode = false;
      this.showMainForm = false;
    },

    selectCampusAdviser(item) {
      this.selectedCampusAdviser = item;
      this.isUpdatingMode = true;
      console.log(item);

      this.selected_school_year = item.school_year.id;

      if (item.school != null) {
        this.selecated_school = item.school.id;
      }

      this.showMainForm = true;
    },

    async deleteSelected() {
      this.isDeleting = true;

      await axiosApi
        .post("api/manage-campus-dean/delete-selected", {
          campus_deans_id: this.seleted_deans,
        })
        .then((res) => {
          console.log(res);

          this.showDeleteConfirmation = false;
          this.seleted_deans = [];
          this.getDeans();
          this.getUsers();
        })
        .catch((err) => {
          this.hasRequestError =
            "Oops! It seems like there was an error when  when deleting campus advisers. if you think it it was the system please do contact the developer";
        })
        .finally(() => {
          this.isDeleting = false;
        });
    },

    async getDeans() {
      this.isFetching = true;

      await axiosApi
        .get("api/manage-campus-dean/get-all-campus-dean")
        .then((res) => {
          this.campus_deans = res.data.data;
        })
        .catch((err) => {
          this.hasRequestError =
            "Oops! It seems like there was an error when  fetchin  campus advisers, Please check your network connection. o and try again. if you think it it was the system please do contact the developer";
        })
        .finally(() => {
          this.isFetching = false;
        });
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
              this.selecated_school = this.schools[0].id;
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
  
    async getUsers() {
      this.isFetchingUser = true;

await axiosApi
  .get("api/available-users")
  .then((res) => {
    this.users = res.data.data;

    if (this.users.length > 0) {
      this.selected_dean = this.users[0].id;
    }
  })
  .catch((err) => {
    this.hasRequestError =
      '"Oops! It seems like there was an error when  fetchin available users school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
  })
  .finally(() => {
    this.isSchoolYearFetching = false;
  });
    },

    async addDean() {
      this.isSaving = true;

      let campus_director_data = {
        user_id: this.selected_dean,
        school_id: this.selecated_school,
        school_year_id: this.selected_school_year,
      };
      console.log(campus_director_data);
      await axiosApi
        .post("api/manage-campus-dean/create", campus_director_data)
        .then((res) => {
          // console.log(res.data.data ===1);
          

          if (res.data.data ===1) {

            this.hasWarning = '" You can only set one user Per School in each school year "';
          }
          
          else {
            this.showMainForm = false;

            this.getAllSchoolYears();
            this.getDeans();
            this.getUsers();
          }

          console.log(res.data.data);
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when adding campuse adviser Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

    closeTheForm() {
      this.showForm = false;
    },
    showTheForm() {
      this.showForm = true;
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
    async searchDean() {
      axiosApi
        .post("api/campus/campus-adviser/search", {
          search: this.search,
        })
        .then((res) => {
          this.campus_deans = res.data.data;
        });
    },

    async getDeans() {
      this.isFetching = true;
      await axiosApi
        .get("api/manage-campus-dean/get-all-campus-dean")
        .then((res) => {
          // console.log(res.data);
          this.campus_deans = res.data.data;
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
