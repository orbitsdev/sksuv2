use App\Models\SchoolYear;
<template>
  <BaseCard :subtitle="'Manage Form'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            <i class="fa-solid fa-plus mr-1"></i> Create Application Form
          </TableButton>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area></template>
        <template #actions-area>
          <TableButton
            @click="deleteAllSelectedApplicationForm"
            v-if="selectedApplicationForms.length > 0"
            v-model="selectedApplicationForms"
            :mode="true"
            class="mr-2"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Selected (
            {{ selectedApplicationForms.length }} )
          </TableButton>
        </template>
      </BaseTableSetup>
      <BaseTable
        :thdata="['', 'Title', 'Body', 'Approvers ', 'Status', '']"
        :isFetching="isFetching"
      >
        <template #data>
          <tr v-for="item in applicationforms" :key="item.id">
            <td class="relative w-12 px-6 sm:w-16 sm:px-8 align-top py-4">
              <input
                v-model="selectedApplicationForms"
                :value="item.id"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="whitespace-nowrap py-4 text-sm">
              <div class="flex items-center">
                <div class="pl-1">
                  <div
                    class="font-medium capitalize text-sm font-rubik pr-2 text-gray-900"
                  >
                    {{ item.title }}
                  </div>
                </div>
              </div>
            </td>
            <td class="whitespace-nowrap py-4 align-top">
              <p class="mb-2 font-bold uppercase">Requestments</p>

              <div v-if="item.fields.length > 0">
                <div v-for="field in item.fields" :key="field.id">
                  <StatusCard
                    class="mb-1 bg-purple-700 text-white font-rubik uppercase"
                    >{{ field.name }}</StatusCard
                  >
                </div>
              </div>
              <div v-else>
                <StatusCard class="bg-gray-700 tett-white">None</StatusCard>
              </div>

              <div v-if="item.requirements.length > 0">
                <w-divider class="my6 my-2"></w-divider>
                <p class="mb-2 font-bold uppercase">Requestments</p>
                <div class="grid grid-cols-1 gap-1 break-words">
                  <div v-for="requirement in item.requirements" :key="requirement.id">
                    <StatusCard class="bg-rose-700 text-white mb-1">
                      {{ requirement.name }}
                    </StatusCard>
                  </div>
                </div>
              </div>
              <div v-else>
                <span
                  class="inline-flex rounded-full bg-green-100 mx-1 px-2 text-xs font-semibold leading-5 text-green-800"
                  >None</span
                >
              </div>
            </td>

            <td class="whitespace-nowrap py-4 align-top">
              <div
                class="grid grid-cols-1 gap-1 break-words"
                v-if="item.application_form_approvals.length > 0"
              >
                <StatusCard
                  class="bg-green-700 text-white"
                  v-for="authorize in item.application_form_approvals"
                  :key="authorize"
                >
                  {{ authorize.role_name }}
                </StatusCard>
              </div>
              <StatusCard class="bg-gray-700 text-white capitalize" v-else>
                None
              </StatusCard>
            </td>
            <td class="whitespace-nowrap py-4 align-top">
              <StatusCard class="capitalize bg-sky-700 text-white">
                {{ item.status }}
              </StatusCard>
            </td>

            <td
              class="align-top relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            >
            <div class="grid grid-cols-1">          
              <button
                :disabled="selectedApplicationForms.length > 0"
                @click="makeApplicationPublic(item)"
                type="button"
                class="mb-1 z-0 items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                Make {{ item.status == "private" ? "Public" : "Private" }}
              </button>

              <button
                @click="showSampleForm(item.id)"
                class="mb-1 items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                View Form
              </button>
              <button
                :disabled="selectedApplicationForms.length > 0"
                @click="showTheFormToUpdate(item)"
                type="button"
                class="mb-1 z-0 items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </div>
            </td>
          </tr>
        </template>
      </BaseTable>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'800'" :preventClose="true">
        <template #c-content>
          <section class="mt-2">
            <div>
              <p class="text-base font-bold">School Year</p>
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

         
          <!-- <section class="mt-4">
            <div>
              <p class="text-base font-bold">Select University</p>
              <NoDataCard v-if="schools.length <= 0">Empty </NoDataCard>
              <div v-else class="overflow-y-auto  max-h-60  grid grid-cols-3 gap-x-4 gap-y-2">
                  <label :for="school.id" v-for="school in schools" :key="school.id" class="px-2 py-2  border  flex items-center rounded cursor-pointer">
                    <input
                    :id="school.id"
                    :value="school.id"
                      type="checkbox"
                      class="w-4 h-4 accent-green-600 text-white mr-2 border-blue-700 border-2 "
                    />
                    <p class="text-sm font-rubik capitalize leading-3">
                        {{ school.name }}
                        
                      </p> 
                  </label>
              </div>
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
          </section> -->

          <p class="text-base font-bold mt-4">Application Title</p>
          <BaseInput v-model="formtitle" />
          <p
            class="text-xs text-red-500 mt-1"
            v-if="validationError != null && validationError.title"
          >
            {{ validationError.title[0] }}
          </p>
          <div class="mt-2">
            <div
              v-for="(field, parentindex) in formfields"
              :key="field.id"
              class="relative shadow mt-3 mb-4 border px-3 py-2 rounded bg-gray-100"
            >
              <div>
                <button
                  @click="removeField(parentindex)"
                  class="closeButton flex items-center justify-center rounded-full bg-gray-400 cursor-pointer hover:scale-95"
                >
                  <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="">
                  <label class="font-bold font-rubik"> Field name </label>
                  <input
                    v-model="formfields[parentindex].fieldname"
                    type="text"
                    class="w-full p-1 border"
                  />
                  <p
                    class="text-xs text-red-500 mt-1"
                    v-if="
                      validationError != null &&
                      validationError['fields.' + parentindex + '.name']
                    "
                  >
                    {{ validationError["fields." + parentindex + ".name"][0] }}
                  </p>
                </div>
                <div class="mt-2 flex justify-between">
                  <div>
                    <label class="mb-1 font-bold font-rubik"> Field type </label>
                    <div class="grid grid-cols-5 gap-1">
                      <label
                        v-for="(option, index) in field.fieldtypeOption"
                        :key="option.id"
                        class="inline-flex items-center rounded cursor-pointer"
                      >
                        <input
                          v-model="option.selected"
                          @change="handleFieldTypeSelection(parentindex, index, option)"
                          type="checkbox"
                          class="mr-1 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
                        />
                        <span class="text-sm font-rubik"> {{ option.name }}</span>
                      </label>
                    </div>
                    <div class="mt-2">
                      <div
                        class=""
                        v-if="formfields[parentindex].selectedtype == 'select'"
                      >
                        <p class="mt-1 font-rubik font-bold">
                          Choose data for select field
                        </p>
                        <w-divider class="my6 my-2"></w-divider>
                        <label
                          v-for="(collection, index) in formfields[parentindex].data"
                          :key="collection"
                          class="mt-3 border cursor-pointer flex items-center px-2 py-1 rounded"
                        >
                          <input
                            v-model="collection.selected"
                            @change="handleDdataSelection(parentindex, index, collection)"
                            type="checkbox"
                            class="mr-1 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
                          />
                          <span class="text-sm"> {{ collection.name }} </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-end">
              <Button
                class="border bg-green-700 text-white font-bold rounded-full px-4 py-1 hover:shadow-lg"
                @click="handleAddFields"
              >
                <i class="fa-solid fa-plus mr-1"></i> <span class="mr-1"> Field </span>
              </Button>
            </div>
            <div v-if="isRequirementLoading" class="min-h-23 h-24 flex items-center">
              <Loader1 />
            </div>
            <div class="mt-2" v-else>
              <p class="text-base font-bold">Requirement Check List</p>
              <w-divider class="my6"></w-divider>
              <div class="">
                <div v-for="requirement in requirements" :key="requirement.id">
                  <div class="flex items-center p-1 my-1">
                    <input
                      v-model="selectedRequirements"
                      type="checkbox"
                      :value="requirement.id"
                      class="w-4 h-4 accent-green-600 text-white mr-1 border-blue-700 border-2 cursor-pointer"
                      :id="requirement.id"
                    />
                    <label :for="requirement.id" class="mr-1 capitalize cursor-pointer">
                      {{ requirement.name }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="isRolesLoading" class="min-h-23 h-24 flex items-center">
            <Loader1 />
          </div>
          <div class="mt-2" v-else>
            <p class="text-base font-bold">Authorize Roles for Approval</p>
            <w-divider class="my6"> </w-divider>

            <div v-for="approver in approvers" :key="approver">
              <div class="flex items-center p-1 my-1">
                <input
                  v-model="selectedApprover"
                  :value="approver.id"
                  type="checkbox"
                  class="w-4 h-4 accent-green-600 text-white mr-1 border-blue-700 border-2 cursor-pointer"
                />
                <label
                  :for="approver.id"
                  class="mr-2 font-rubik capitalize cursor-pointer"
                >
                  {{ approver.name }}
                </label>
              </div>
            </div>
          </div>

          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="closeTheForm"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton v-if="!isUpdatingMode" @click="createApplicationForm">
                Save
              </TableButton>
              <TableButton v-else @click="updateApplicatonForm"> Update </TableButton>
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
      <BaseDialog
        class="bg-gray-200"
        :show="selectedApplicationToView != null"
        :width="'600'"
        :preventClose="true"
      >
        <template #c-content>
          <h1 class="mb-4 text-lg font-bold">( View only )</h1>

          <FormComponent :id="selectedApplicationToView" />
          <div class="">
            <TableButton mode class="mr-2" @click="selectedApplicationToView = null">
              Close
            </TableButton>
          </div>
        </template>
      </BaseDialog>
    </teleport>
    <GlobalErrorCard @close="hasRequestError = null" :show="hasRequestError != null">
    </GlobalErrorCard>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  data() {
    return {
      search: "",
      formtitle: "",
      showForm: false,
      validationError: null,
      requestError: null,
      isSaving: false,
      isFetching: false,
      isUpdatingMode: false,
      isApplicationFormFetching: false,
      isRequirementLoading: false,
      selectedRequirements: [],
      selectedApplicationForms: [],
      requirements: [],
      approvers: [1, 2, 3],
      applicationforms: [],
      selectedApplicationFormToUpdate: null,
      formfields: [],
      isLoading: false,
      selectedApplicationToView: null,
      selectedApprover: [],
      isRolesLoading: false,

      schools: [],
      isSchoolYearFetching: false,
      selected_school_year: null,
      school_years: [],
      hasRequestError: null,
      selecated_school: null,
    };
  },

  created() {
    this.getAllSchoolYears();
    this.loadApplicationForms();
    this.loadRequirements();
    this.loadApprovers();
  },

  watch: {
    search(olvalue, newvalue) {
      this.searchApplication();
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

    showSampleForm(id) {
      this.selectedApplicationToView = id;
    },
    async searchApplication() {
      await axiosApi
        .post("api/manage-applications/search", {
          search: this.search,
        })
        .then((res) => {
          this.applicationforms = res.data.data;
        });
    },

    async showTheFormToUpdate(item) {
      this.isUpdatingMode = true;
      this.formtitle = item.title;
      this.formfields = [];

      this.selectedRequirements = [];
      this.selectedApprover = [];

      // display initial existing feilds
      if (item.fields.length > 0) {
        item.fields.forEach((element) => {
          let field = {
            id: element.id,
            name: element.name,
            index: element.index,
            type: element.type,
            collection_for_select: element.collection_for_select,
          };

          let defaulttypeoption = [
            { id: 1, name: "Text", value: "text", selected: false },
            { id: 2, name: "Email", value: "email", selected: false },
            { id: 3, name: "Select", value: "select", selected: false },
            { id: 4, name: "Number", value: "number", selected: false },
            { id: 5, name: "Text Area", value: "textarea", selected: false },
          ];

          let defaultdataoption = [
            { id: 1, name: "Users", value: "users", selected: false },
            { id: 2, name: "School", value: "schools", selected: false },
            { id: 3, name: "Department", value: "departments", selected: false },
          ];

          defaulttypeoption.forEach((element) => {
            if (element.value == field.type) {
              element.selected = true;
            }
          });

          defaultdataoption.forEach((element) => {
            if (element.value == field.collection_for_select) {
              element.selected = true;
            }
          });

          const createdField = {
            id: field.id,
            fieldname: field.name,
            index: field.index,
            selectedtype: field.type,
            selecteddata: field.collection_for_select,
            fieldtypeOption: defaulttypeoption,
            data: defaultdataoption,
          };

          this.formfields.push(createdField);
          this.formfields.sort((a, b) => a.index - b.index);
        });
      }
      // check existing requirements
      if (item.requirements.length > 0) {
        item.requirements.forEach((element) => {
          this.selectedRequirements.push(element.id);
        });
      }

      // console.log(item.application_form_approvals);

      if (item.application_form_approvals.length > 0) {
        item.application_form_approvals.forEach((ap) => {
          this.selectedApprover.push(ap.role_id);
        });

        console.log(this.selectedApprover);
      }
      // if(item.application_form_approvals.length > 0){

      //       item.application_form_approvals.forEach(approver => {
      //         this.selectedApprover.push(approver.id);
      //       });
      // }

      let newfields = [];
      let selected_collection_for_select = null;

      this.formfields.forEach((element) => {
        if (element.selectedtype == "select") {
          selected_collection_for_select = element.selecteddata;
        }

        // newfields.push({
        //   name: element.fieldname,
        //   index: element.index,
        //   type: element.selectedtype,
        //   collection_for_select: selected_collection_for_select,
        // });
      });

      // const new_application = {
      //   id:item.id,
      //   title: this.formtitle,
      //   fields: newfields,
      //   requirements: this.selectedRequirements,
      // };

      this.selectedApplicationFormToUpdate = item.id;

      this.showForm = true;
    },

    async updateApplicatonForm() {
      this.isSaving = true;
      let newfields = [];
      let selected_collection_for_select = null;

      this.formfields.forEach((element) => {
        if (element.selectedtype == "select") {
          selected_collection_for_select = element.selecteddata;
        }

        newfields.push({
          id: element.id,
          name: element.fieldname,
          index: element.index,
          type: element.selectedtype,
          collection_for_select: selected_collection_for_select,
        });
      });

      const new_application = {
        id: this.selectedApplicationFormToUpdate,
        title: this.formtitle,
        fields: newfields,
        requirements: this.selectedRequirements,
        approvers: this.selectedApprover,
      };

      await axiosApi
        .post("api/manage-applications/update", new_application)
        .then((res) => {
          console.log(res.data);
          this.validationError = null;
          this.showForm = false;
          this.formtitle = "";
          this.formfields = [];
          this.selectedRequirements = [];
          this.selectedApprover = [];
          this.selectedApplicationFormToUpdate = null;
          this.loadApplicationForms();
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

    showTheForm() {
      this.isUpdatingMode = false;
      this.formtitle = "";
      this.formfields = [];
      this.selectedApprover = [];

      this.showForm = true;
    },

    makeApplicationPublic(item) {
      let m = item.status == "Priavte " ? "Public" : "Private";
      this.customConfirmationDialog({
        title:
          "Are you sure do you want to change the status of this application form into " +
          m,
        text: "",
        confirmButtonText: "Yes ",
        passFunction: async () => {
          this.isLoading = true;
          let currentStatus = "";

          if (item.status == "private") {
            currentStatus = "public";
          } else {
            currentStatus = "private";
          }

          axiosApi
            .post("api/manage-applications/make-application-public", {
              id: item.id,
              status: currentStatus,
            })
            .then((res) => {
              this.loadApplicationForms();
            })
            .catch((err) => {
              this.requestError = err;
            })
            .finally(() => {
              this.isLoading = false;
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
    async deleteAllSelectedApplicationForm() {
      this.customConfirmationDialog({
        title: "Are you sure do you want to delete selected application forms ?",
        passFunction: async () => {
          await axiosApi
            .post("api/manage-applications/delete-selected", {
              applicationforms: this.selectedApplicationForms,
            })
            .then((res) => {
              this.selectedApplicationForms = [];
              this.loadApplicationForms();
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

    async loadApplicationForms() {
      this.isFetching = true;
      await axiosApi
        .get("api/manage-applications")
        .then((res) => {
          this.applicationforms = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async loadApprovers() {
      this.isRolesLoading = true;

      await axiosApi
        .get("api/form/approvers")
        .then((res) => {
          this.approvers = res.data.data;
          // console.log(res.data.data);
        })
        .catch((err) => {})
        .finally(() => {
          this.isRolesLoading = false;
        });
    },
    async loadRequirements() {
      this.isRequirementLoading = true;

      await axiosApi
        .get("api/manage-requirement")
        .then((res) => {
          this.requirements = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isRequirementLoading = false;
        });
    },

    closeTheForm() {
      this.showForm = false;
      //this.formfields = [];
      // this.formtitle = '';
    },

    clearForm() {
      this.validationError = null;
    },
    async createApplicationForm() {
      this.isSaving = true;
      let newfields = [];
      let selected_collection_for_select = null;

      this.formfields.forEach((element, index) => {
        if (element.selectedtype == "select") {
          selected_collection_for_select = element.selecteddata;
        }
        newfields.push({
          name: element.fieldname,
          index: index,
          type: element.selectedtype,
          collection_for_select: selected_collection_for_select,
        });
      });

      const new_application = {
        title: this.formtitle,
        fields: newfields,
        requirements: this.selectedRequirements,
        approvers: this.selectedApprover,
        school_year_id: this.selected_school_year,
      };

      await axiosApi
        .post("api/manage-applications/create", new_application)
        .then((res) => {
          console.log(res.data);
          this.validationError = null;
          this.showForm = false;
          this.formtitle = "";
          this.formfields = [];
          this.selectedRequirements = [];
          this.selectedApprover = [];
          this.loadApplicationForms();
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

    removeField(parentindex) {
      this.formfields.splice(parentindex, 1);
    },
    handleAddFields() {
      const id = this.formfields.length + 1;
      const newfields = {
        id: id,
        fieldname: "",
        index: id,
        selectedtype: "text",
        selecteddata: null,

        fieldtypeOption: [
          { id: 1, name: "Text", value: "text", selected: true },
          { id: 2, name: "Email", value: "email", selected: false },
          { id: 3, name: "Select", value: "select", selected: false },
          { id: 4, name: "Number", value: "number", selected: false },
          { id: 5, name: "Text Area", value: "textarea", selected: false },
        ],
        data: [
          { id: 1, name: "Users", value: "users", selected: false },
          { id: 2, name: "School", value: "schools", selected: false },
          { id: 3, name: "Department", value: "departments", selected: false },
        ],
      };

      this.formfields.push(newfields);
    },
    handleFieldTypeSelection(parentindex, index, item) {
      this.formfields[parentindex].fieldtypeOption.forEach((i) => {
        i.selected = false;
      });
      item.selected = true;

      this.formfields[parentindex].selectedtype = item.value;
    },

    handleDdataSelection(parentindex, index, item) {
      this.formfields[parentindex].data.forEach((i) => {
        i.selected = false;
      });
      item.selected = true;

      this.formfields[parentindex].selecteddata = item.value;
      console.log(this.formfields[parentindex].selectedtype);
      console.log(this.formfields[parentindex].selecteddata);
    },
  },
};
</script>

<style scoped>
.closeButton {
  position: absolute;
  top: -10px;
  right: -10px;
  width: 24px;
  height: 24px;
}
</style>
