use App\Models\CampusSboAdviser;
<template>
  <BaseCard class="relative" :subtitle="'Campus SBO advisers'">
    <template #header>
      {{ selectedCampusAdviser }}

      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showMainForm = true">
            <i class="fa-solid fa-plus mr-1"></i> ADD SBO-ADVISER
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
            v-if="selectedAdvisers.length > 0"
            mode
          >
            <i class="fa-regular fa-trash-can mr-1"></i>
            <span class="block">Delete Selected </span>
          </TableButton>
        </template>
      </BaseTableSetup>
    </template>

    <BaseTable
      :thdata="['', 'Year', 'Sbo Adviser Name', 'University', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="adviser in campus_advisers" :key="adviser.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectedAdvisers"
              :value="adviser.id"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-green-700">
            <p class="font-semibold font-rubik">
              SY.{{ adviser.school_year.from }} - {{ adviser.school_year.to }}
            </p>
          </td>
          <td class="whitespace-nowrap py-4">
            <!-- <StatusCard class="bg-rose-700 text-rose-100 capitalize" >
            </StatusCard> -->
            <p class="capitalize">
              {{ adviser.user.first_name + " " + adviser.user.last_name }}
            </p>
          </td>

          <td class="whitespace-nowrap py-4 text-sm text-gray-900">
            <StatusCard v-if="adviser.school != null" class="bg-green-700 text-white">
              {{ adviser.school.name }}
            </StatusCard>
            <StatusCard v-else class="bg-gray-700 text-white"> None </StatusCard>
          </td>
          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            <!-- <button
              @click="selectCampusAdviser(adviser)"
              :disabled="selectedAdvisers.length > 0"
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

    <teleport to="#app">
      <BaseDialog :show="showMainForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <!-- {{ selecated_campuse_adviser }} -->
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
                v-model="selecated_campuse_adviser"
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
                  selecated_campuse_adviser == null ||
                  selecated_school == null ||
                  selected_school_year == null
                "
              ></div>
              <div v-else>
                <TableButton v-if="isUpdatingMode" class="" @click="updateCampusAdviser">
                  Update
                </TableButton>
                <TableButton v-else class="" @click="addCampusAdviser">
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
              @click="deleteSelectedCampusAdviser"
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
    this.getAllCampusAdvisers();
    this.getAllSchoolYears();
    // this.loadSchool();
    this.getUserWhereIsNotCampusAdviser();
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

      campus_advisers: [],
      users: [],
      schools: [],
      school_years: [],

      selecated_campuse_adviser: null,
      selecated_school: null,
      selected_school_year: null,

      isSchoolYearFetching: false,
      isAvailabeUserFetching: false,
      isSchoolFetching: false,

      selectedAdvisers: [],
      selectedCampusAdviser: null,
      showDeleteConfirmation: false,
      isDeleting: false,
      isUpdatingMode: false,
      hasWarning: null,
    };
  },

  watch: {
    search(oldeValue, newValue) {
      this.searchCampusAdviser();
    },
  },

  methods: {
    async updateCampusAdviser() {
      this.isSaving = true;

      let campus_sbo_data = {
        id: this.selectedCampusAdviser.id,
        user_id: this.selecated_campuse_adviser,
        school_id: this.selecated_school,
        school_year_id: this.selected_school_year,
      };

      console.log(campus_sbo_data);

      await axiosApi
        .post("api/campus/campus-adviser/update", campus_sbo_data)
        .then((res) => {
          this.showMainForm = false;
          this.isUpdatingMode = false;
          this.selectedCampusAdviser = null;
          this.selecated_campuse_adviser = null;
          this.school_id = null;
          this.getAllCampusAdvisers();
          this.getUserWhereIsNotCampusAdviser();
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when updating campuse adviser Please check your network connection. o and try again. if you think it it was the system please do contact the developer"';
        })
        .finally(() => {
          this.isSaving = false;
        });
    },

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

    async deleteSelectedCampusAdviser() {
      this.isDeleting = true;

      await axiosApi
        .post("api/campus/delete-selected", {
          campus_advisers_id: this.selectedAdvisers,
        })
        .then((res) => {
          console.log(res);

          this.showDeleteConfirmation = false;
          this.selectedAdvisers = [];
          this.getAllCampusAdvisers();
          this.getUserWhereIsNotCampusAdviser();
        })
        .catch((err) => {
          this.hasRequestError =
            "Oops! It seems like there was an error when  when deleting campus advisers. if you think it it was the system please do contact the developer";
        })
        .finally(() => {
          this.isDeleting = false;
        });
    },

    async getAllCampusAdvisers() {
      this.isFetching = true;

      await axiosApi
        .get("api/campus/campus-advisers")
        .then((res) => {
          this.campus_advisers = res.data.data;
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
    async loadSchool() {
      this.isSchoolFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;

          if (this.schools.length > 0) {
            this.selecated_school = this.schools[0].id;
          }
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when fetching schools. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },

    async getUserWhereIsNotCampusAdviser() {
      this.isAvailabeUserFetching = true;
      await axiosApi
        .get("api/campus-available-users")
        .then((res) => {
          this.users = res.data.data;

          if (this.users.length > 0) {
            this.selecated_campuse_adviser = this.users[0].id;
          }
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when fetching avvalabe users. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isAvailabeUserFetching = false;
        });
    },

    async addCampusAdviser() {
      this.isSaving = true;

      let campus_sbo_data = {
        user_id: this.selecated_campuse_adviser,
        school_id: this.selecated_school,
        school_year_id: this.selected_school_year,
      };
      console.log(campus_sbo_data);
      await axiosApi
        .post("api/campus/campus-adviser", campus_sbo_data)
        .then((res) => {
          // console.log(res.data.data ===1);
          

          if (res.data.data ===1) {

            this.hasWarning = '" You can only set one user Per School in each school year "';
          }
          
          else {
            this.showMainForm = false;

            
            
            this.getAllSchoolYears();
            this.getAllCampusAdvisers();
            this.getUserWhereIsNotCampusAdviser();
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
    async searchCampusAdviser() {
      axiosApi
        .post("api/campus/campus-adviser/search", {
          search: this.search,
        })
        .then((res) => {
          this.campus_advisers = res.data.data;
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
  },
};
</script>

<style scoped></style>
