<template>
  <BaseCard :subtitle="'Endorsed Docuements From Sbo Adviser'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          
        </template>
        <template #filters-area> </template>
        <template #actions-area>
          <!-- <TableButton
          v-if="selectedEndorsed.length > 0"
          @click="showEndorsenmentForm = true"
        >
          <i class="fa-solid fa-share mr-2"></i> Endorsed
        </TableButton> -->
      </template>
      </BaseTableSetup>
    </template>
    <BaseTable
      :thdata="['', 'Application', 'SBO Adviser', 'School', 'Status', 'School Year', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="item in endorsed_applications" :key="item">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <!-- {{ item }} -->
            <!-- <input
              v-model="selectedEndorsed"
              :value="item.id"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
            /> -->
          </td>
          <td class="text-sm py-4">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900">
                  {{ item.response.application_form.title }}
                </div>
              </div>
            </div>
          </td>

          <td class="text-sm py-4">
            <StatusCard class="capitalize">
              {{ item.campus_director.user.first_name }}
              {{ item.campus_director.user.last_name }}
            </StatusCard>
          </td>

          <td class="text-sm py-4">
            <StatusCard class="capitalize">
              {{ item.campus_director.school.name }}
            </StatusCard>
          </td>

          <td class="text-sm py-4">
            <div class="flex items-center capitalize">
              <StatusCard
                class="bg-green-100 text-green-700"
                v-if="item.status == 'approved'"
                >{{ item.status }}</StatusCard
              >
              <StatusCard
                class="bg-cyan-100 text-cyan-700"
                v-if="item.status == 're-evaluating'"
                >{{ item.status }}</StatusCard
              >
              <StatusCard
                class="bg-rose-100 text-rose-700"
                v-if="item.status == 'returned'"
                >{{ item.status }}</StatusCard
              >
            </div>
          </td>

          <td class="text-sm py-4">
            <div class="flex items-center capitalize">
              <div class="">
                SY. {{ item.campus_director.school_year.from }} -
                {{ item.campus_director.school_year.to }}
              </div>
            </div>
          </td>

          <td class="py-2 text-sm text-gray-500">
            <button
              @click="handleShowForm(item)"
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
          <ConfirmCard
            :title="`Are You Sure do you want to undo the selected endorsements to?`"
          >
          </ConfirmCard>

          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <WhiteButton class="w-full mr-2" @click="showForm = false"> No </WhiteButton>
            <div
              class="my-1 mx-2 w-full flex justify-center items-center"
              v-if="isUpdating"
            >
              <BaseSpinner />
            </div>
            <div v-else class="w-full">
              <SquareButton class="w-full" @click="deleteSelectedEndorsement">
                Yes
              </SquareButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="isApprovalForm" :width="'500'" :preventClose="true">
        <template #c-content>
          <div v-if="selectedItem != null" class="">
            <div class="">
              <h1 class="text-2xl font-rubik font-semibold uppercase leading-5 mb-4">
                {{ selectedItem.response.application_form.title }}
              </h1>

              <div class="flex bg-green-700 rounded-md relative">
                <div class="flex">
                  <div class="px-4 py-6 border-r border-green-600">
                    <div class="h-10 w-10">
                      <img
                        src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=250&q=80"
                        alt="Display Avatar of Jon Harrison"
                        role="img"
                        class="h-full w-full rounded-full overflow-hidden shadow object-cover"
                      />
                    </div>
                  </div>
                  <div class="flex flex-col justify-center pl-3 py-2 sm:py-0">
                    <p class="text-lg font-bold text-white capitalize">
                      {{ selectedItem.response.user.first_name }}
                      {{ selectedItem.response.user.last_name }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                      <p class="text-sm text-white leading-5">
                        {{ selectedItem.response.user.sbo_officer.position }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="mt-6">
                <div v-if="selectedItem.response.answers.length > 0">
                  <p
                    class="text-base font-rubik font-semibold leading-none text-gray-800 uppercase"
                  >
                    GENERAL INFORMATION
                  </p>
                  <w-divider class="my6 mb-6"></w-divider>
                  <!-- {{ selectedItem.response.answers }} -->
                  <div
                    class="mb-4"
                    v-for="af in selectedItem.response.answers"
                    :key="af.id"
                  >
                    <div>
                      <p class="text-sm font-rubik leading-none text-gray-800 capitalize">
                        {{ af.field.name }}
                      </p>
                      <div class="flex flex-wrap mt-2">
                        <p class="text-sm font-medium font-rubik leading-none capitalize">
                          {{ af.answer_value }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="selectedItem.response.response_requirements.length > 0">
                <div class="mt-8">
                  <p
                    class="text-base font-rubik font-semibold leading-none text-gray-800 uppercase"
                  >
                    Requirements & Attachment
                  </p>
                  <w-divider class="my6 mb-6"></w-divider>

                  <div
                    class="mb-4"
                    v-for="rq in selectedItem.response.response_requirements"
                    :key="rq.id"
                  >
                    <div>
                      <p class="text-sm font-rubik leading-none">
                        {{ rq.requirement.name }}
                      </p>
                      <div class="flex flex-wrap mt-4" v-if="rq.files.length > 0">
                        <a
                          :href="file.url"
                          class="hover:shadow-lg py-1 px-2 border rounded-full flex items-center mr-2 mt-1"
                          v-for="file in rq.files"
                          :key="file.id"
                        >
                          <div class="focus:outline-none">
                            <img
                              src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                              alt="icon"
                            />
                          </div>
                          <p class="text-sm leading-none text-gray-600 ml-2">
                            {{ file.file_name }}
                          </p>
                        </a>
                      </div>

                      <div class="flex flex-wrap mt-3" v-else>
                        <div class="flex items-center mr-2">
                          <div class="focus:outline-none">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke-width="1.5"
                              stroke="currentColor"
                              class="w-6 h-6 text-gray-500"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                              />
                            </svg>
                          </div>
                          <p class="text-xs leading-none text-gray-500 ml-2">No File</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-8 flex justify-between items-center border-t pt-4">
            <div>
              <button
                class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
                @click="closeApprovalForm"
              >
                Close
              </button>
            </div>
            <div>
              <button
                v-if="selectedItem.status != 'approved'"
                @click="showConfirmation = true"
                class="hover:shadow mr-2 rounded-md bg-green-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
                Approve
              </button>
              <button
                v-if="selectedItem.status == 'approved'"
                @click="showConfirmation = true"
                class="hover:shadow mr-2 rounded-md bg-green-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
                Re Evaluate
              </button>

              <button
                @click="showReturnedConfirmationForm = true"
                class="hover:shadow mr-2 rounded-md bg-red-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
              Return
                <!-- {{ confirmMode == "returned" ? "Add Remark" : "Return" }} -->
              </button>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="showConfirmation" :width="'500'" :preventClose="true">
        <template #c-content>
          <ConfirmCard
            v-if="confirmMode != 'approved'"
            :title="'Are Your Sure?'"
            :message="'Do you want to approve this application'"
          >
            <div class="col-span-1 flex justify-center items-center" v-if="isSaving">
              <BaseSpinner />
            </div>
            <button
              v-else
              @click="approveApplication"
              class="col-span-1 transition duration-150 ease-in-out hover:bg-green-600 bg-green-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
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
          <ConfirmCard
            v-if="confirmMode == 'approved'"
            :title="'Are Your Sure?'"
            :message="'Do you want to re-evaluate this application'"
          >
            <div class="col-span-1 flex justify-center items-center" v-if="isSaving">
              <BaseSpinner />
            </div>
            <button
              v-else
              @click="approveApplication"
              class="col-span-1 transition duration-150 ease-in-out hover:bg-green-600 bg-green-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            >
              Yes
            </button>s
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

    <teleport to="#app">
      <BaseDialog
        :show="showReturnedConfirmationForm"
        :width="'500'"
        :preventClose="true"
      >
        <template #c-content>
          <ConfirmCard
            :title="'Are Your Sure?'"
            :message="'Do you want to returned  this application'"
          >
            <div class="col-span-1 flex justify-center items-center" v-if="isReturning">
              <BaseSpinner />
            </div>
            <button
              v-else
              @click="returnedApplication"
              class="col-span-1 transition duration-150 ease-in-out hover:bg-green-600 bg-green-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            >
              Yes
            </button>
            <button
              class="col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
              @click="showReturnedConfirmationForm = false"
            >
              Close
            </button>
          </ConfirmCard>
        </template>
      </BaseDialog>
    </teleport>



    
    <teleport to="#app">
      <BaseDialog :show="showEndorsenmentForm" :width="'620'" :preventClose="true">
        <template #c-content>
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
              <p class="text-base font-bold mt-4">Select User</p>
              <NoDataCard v-if="users.length <= 0">Empty </NoDataCard>
              <select
                v-else
                v-model="selected_"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
              >
                <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.user.first_name }} - {{ user.user.last_name }} - {{ user.school.name }}
                </option>
              </select>
            </div>
          </section>

          <div class="flex justify-end item-center pt-4">
            <button
              class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              @click="showEndorsenmentForm = false"
            >
              Close
            </button>

              <div
                v-if="
                  selected_ == null ||
                  selected_school_year == null
                "
              ></div>
              <div v-else>
                <TableButton @click="showEndorseConfirmation = true"> <i class="fa-solid fa-share mr-2"></i>   Endorse </TableButton>
              </div>
          </div>
        </template>
      </BaseDialog>

    </teleport>
    <GlobalErrorCard @close="requestHasError = null" :show="requestHasError != null">
      {{ requestHasError }}
    </GlobalErrorCard>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  created() {
    this.getData();
  },

  data() {
    return {
      showForm: false,
      isFetching: false,
      endorsed_applications: [],
      requestHasError: null,

      isUpdating: false,
      selectedItem: null,
      selectedEndorsed: [],

      isSaving: false,
      isApprovalForm: false,
      showConfirmation: false,

      showReturnedConfirmationForm: false,
      isReturning: false,

      showEndorsenmentForm: false,
    };
  },

  methods: {
    async returnEndorsement() {},
    showReturnedConfirmation() {
      this.showReturnedConfirmationForm = true;
    },
    async returnedApplication() {
      this.isReturning = true;

      await axiosApi
        .post("api/return-sbo-adviser-endorsement", {
          id: this.selectedItem.id,
        })
        .then((res) => {
          this.showReturnedConfirmationForm = false;
          this.isApprovalForm = false;
          this.selectedItem = null;
          this.getData();
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  deleting endorsement Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isReturning = false;
        });
    },
    async approveApplication() {
      this.isSaving = true;

      await axiosApi
        .post("api/approve-sbo-adviser-endorsement", {
          id: this.selectedItem.id,
        })
        .then((res) => {
          this.showConfirmation = false;
          this.isApprovalForm = false;
          this.selectedItem = null;
          this.getData();
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  deleting endorsement Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isSaving = false;
        });
    },
    closeApprovalForm() {
      this.isApprovalForm = false;
      this.selectedItem = null;
    },
    async handleShowForm(item) {
      this.selectedItem = item;

      this.isApprovalForm = true;
    },

    async deleteSelectedEndorsement() {
      this.isUpdating = true;

      await axiosApi
        .post("api/delete-selected-endorsement", {
          indorsed_id: this.selectedEndorsed,
        })
        .then((res) => {
          this.showForm = false;
          this.selectedEndorsed = [];

          this.getData();
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  deleting endorsement Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isUpdating = false;
        });
    },

    async getData() {
      this.isFetching = true;

      await axiosApi
        .get("api/get-endorsementt-from-campus-adviser")
        .then((res) => {
          console.log(res.data);

          this.endorsed_applications = res.data.data;
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped></style>
