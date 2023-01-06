<template>
  <BaseCard :subtitle="'Manage Form'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            <i class="fa-solid fa-plus mr-1"></i> Create Application Form
          </TableButton>
          <BaseSearchInput :placeholder="'Search application ...'" v-model="search" />
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
        :thdata="['', 'Title', 'Fields', 'Requiments', 'Status', '']"
        :isFetching="isFetching"
      >
        <template #data>
          <tr v-for="item in applicationforms" :key="item.id">
            <td class="relative w-12 px-6 sm:w-16 sm:px-8">
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
                  <div class="font-medium capitalize text-sm pr-2 text-gray-900">
                    {{ item.title }}
                  </div>
                </div>
              </div>
            </td>
            <td class="whitespace-nowrap py-4 text-sm pl-2">
              <div v-if="item.fields.length > 0">
                <div class="flex">
                  <div class="grid grid-cols-1 gap-1">
                    <div v-for="field in item.fields" :key="field.id">
                      <span
                        class="inline-flex whitespace-normal rounded-full break-words bg-green-100 mx-1 px-2 text-xs font-semibold leading-5 text-green-800"
                        >{{ field.name }}</span
                      >
                    </div>
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
            <td class="whitespace-nowrap py-4 text-sm pl-2 ">
              <div v-if="item.requirements.length > 0">
                <div class="grid grid-cols-1 gap-1 break-words">
                  <div v-for="requirement in item.requirements" :key="requirement.id">
                    <p
                      class="inline-flex rounded-full whitespace-normal bg-green-100 px-2 text-xs break-words font-semibold leading-5 text-green-800 m-0.5"
                    >
                    
                      {{ requirement.name }}

                    </p>
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

            <td>
              <span class="capitalize">
                {{ item.status }}
              </span>
            </td>

            <td
              class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            >
            
            
          
              <button
              :disabled="selectedApplicationForms.length > 0"
                @click="makeApplicationPublic(item)"
                type="button"
                class="inline-flex z-0 items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                Make {{ item.status == "private" ? "Public" : "Private" }}
              </button>

            <router-link
              :to="'/dashboard/osas/manage-application/view/'+ item.id "
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              View
            </router-link>
              <button
              :disabled="selectedApplicationForms.length > 0"
                @click="showTheFormToUpdate(item)"
                type="button"
                class="inline-flex z-0 items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            
            </td>
          </tr>
        </template>
      </BaseTable>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'800'" :preventClose="true">
        <template #c-content>
        {{ selectedRequirements }}
          <!-- <div v-for="f in formfields" :key="f.id">
            {{ f }}
            <hr />
          </div> -->
          <p class="text-base font-bold">Application Title</p>
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
              class="relative shadow mt-3 mb-4 border p-2 rounded bg-gray-100"
            >
              <div>
                <button
                  @click="removeField(parentindex)"
                  class="closeButton flex items-center justify-center rounded-full bg-gray-400 cursor-pointer hover:scale-95"
                >
                  <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="">
                  <label class="text-sm"> Field name </label>
                  <input
                    v-model="formfields[parentindex].fieldname"
                    type="text"
                    class="w-full p-1 border"
                  />
                  <!-- <BaseInput /> -->
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
                    <label class="text-sm"> Field type </label>
                    <div class="mt-1 grid grid-cols-5 gap-1">
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
                        <span class="text-sm "> {{ option.name }}</span>
                      </label>
                    </div>
                    <div class="mt-2">
                      <div
                        class=""
                        v-if="formfields[parentindex].selectedtype == 'select'"
                      >
                        <p>Choose data for select field</p>
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
                class="border bg-green-700 text-white font-bold rounded-full  px-4 py-1 hover:shadow-lg"
                @click="handleAddFields"
              >
                <i class="fa-solid fa-plus mr-1"></i> <span class="mr-1"> Field </span>
              </Button>
            </div>
            <div class="mt-2">
              <p class="text-base font-bold">Attach Requiments</p>
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
          
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="closeTheForm"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton v-if="!isUpdatingMode" @click="createApplicationForm"> Save </TableButton>
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
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  data() {
    return {
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
      applicationforms: [],
      selectedApplicationFormToUpdate: null,
      formfields: [],
      isLoading: false,
    };
  },

  created() {
    this.loadApplicationForms();
    this.loadRequirements();
  },

  methods: {


   async showTheFormToUpdate(item) {
      this.isUpdatingMode = true;
      this.formtitle = item.title;
      this.formfields = [];
   
      this.selectedRequirements = [];

      // display initial existing feilds
      if (item.fields.length > 0) {
        item.fields.forEach((element) => {
          let field = {
            id:element.id,
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
      if(item.requirements.length > 0){
        item.requirements.forEach(element => {
            this.selectedRequirements.push(element.id);
        });
      }


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

    async updateApplicatonForm(){



    
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
          index:element.index,
          type: element.selectedtype,
          collection_for_select: selected_collection_for_select,
        });

      });

      const new_application = {
        id:this.selectedApplicationFormToUpdate,
        title: this.formtitle,
        fields: newfields,
        requirements: this.selectedRequirements,
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
