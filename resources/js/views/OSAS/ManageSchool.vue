<template>
  <BaseCard class="relative" :subtitle="'Manage University'">
    <template #header>

      <BaseTableSetup>
  
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            <i class="fa-solid fa-plus mr-1"></i> Add University
          </TableButton>
        <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #filters-area>
          <!-- <BaseFilter class="mx-1"/>
          <BaseFilter class="mx-1"/> -->
        </template>
        <template #actions-area>
          <TableButton
            v-if="selectedSchool.length > 0"
            :mode="true"
            class="mr-2"
            @click="deleteSelectedSchool"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Selected ({{
              selectedSchool.length
            }}
            )
          </TableButton>
          <TableButton
            v-if="!selectedSchool.length > 0 && schools.length > 0"
            :mode="true"
            @click="deleteAllRecord"
          >
            <i class="fa-regular fa-trash-can mr-1"></i>
            <span class="block">Delete All</span>
          </TableButton>
        </template>
      </BaseTableSetup>
    </template>

    <BaseTable
      :thdata="[' ', 'School Year', 'University Name'  ,'Featured Image', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="school in schools" :key="school.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
              v-model="selectedSchool"
              type="checkbox"
              :value="school.id"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
            />
          </td>
          <td > 
            <p
            tabindex="0"
            class="whitespace-normal pl-2 align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800 "
          >
            SY.{{ school.school_year.from }} -{{ school.school_year.to }}
          </p>
          </td>
        
          <td class="whitespace-nowrap py-4 text-sm">
            <div class="flex items-center">
              <div class="pl-1 ">
                <div class="font-medium capitalize text-sm pr-2 text-gray-900">
                  {{ school.name }}
                </div>
              </div>
            </div>
          </td>
         
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div v-if="school.files.length > 0">
              <img
                v-for="schoolfile in school.files"
                :key="schoolfile.id"
                :src="
                  '/uploads/files/' +
                  schoolfile.owned_by +
                  '/' +
                  schoolfile.folder +
                  '/' +
                  schoolfile.file_name
                "
                class="h-24 w-24 rounded mx-2"
                :alt="schoolfile.file_name"
              />
            </div>
            <div v-if="school.files.length > 0">
             
            </div>
            <div v-else class="flex items-centerh-24 w-24">
              <img

              :src="'/assets/No-Image-Placeholder.svg.png'"
               
              class=" rounded mx-2 w-full h-full"
              alt="No Imaghe"
            />
            </div>
          </td>
          
         
          <td
            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
          >
            <button
              @click="selectSchool(school, 'update')"
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
            <button
              :disabled="selectedSchool.length > 0"
              @click="selectSchool(school, 'delete')"
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </td>
        </tr>
      </template>
      <template #ac> 
      

      </template>
    </BaseTable>

    <teleport to="#app">
      <BaseDialog :show="!!showForm" :width="'600'" :preventClose="true">
        <template #c-content>
          <SchoolForm
            :organizationsData="organizations"
            :schoolData="schoolData"
            :isUpdateMode="isUpdateMode"
            @close="closeForm"
            @hasUnsaveFile="handleUnsaveFiles"
            @hasRequestError="showErrorDialog"
          />
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
            @close="closeErrorDialog"
            :message="requestError.message"
          />
        </template>
        <template #c-actions> </template>
      </BaseErrorDialog>
    </teleport>
  </BaseCard>
</template>

<script>
import SchoolForm from "./SchoolForm.vue";
import { ref } from "vue";
import axiosApi from "../../api/axiosApi";

export default {
  components: {
    SchoolForm,
  },

  watch: {
    search(oldeValue, newValue) {
      this.searchSchool();
    },
  },
  created() {
    this.loadSchool();
    // this.getToken();
    this.loadOrganizaions();
  },

  data() {
    return {
      arrays: {
        config: [],
      },
      page: 1,
      search: "",
      schools: [],
      selectedSchool: [],
      organizations: [],
      showForm: false,
      requestError: null,
      isFetching: false,
      schoolData: null,
      isUpdateMode: false,
    };
  },

  methods: {
    async loadOrganizaions() {
      await axiosApi.get("api/manage-department").then(res=>{
        
        this.organizations = res.data.data;
      }).catch(err=>{
        this.requestError = err;
      });
    },

    async handleUnsaveFiles(folders) {
      this.customConfirmationDialog({
        title: "You have  unsave file upload in the form ",
        text: "Are you sure you want to close it",
        icon: "warning",
        confirmButtonText: "Yes ",

        passFunction: () => {
          this.deleteTemporaryStorage(folders);
        },
      });
    },

    async deleteTemporaryStorage(filesfolder) {
      axiosApi
        .post("api/files/delete-temporary-files", {
          folders: filesfolder,
        })
        .then((res) => {
          this.showForm = false;
        })
        .catch((err) => {
          this.requestError = err;
        });
    },
    uploadFile() {
      var client = new OSS(this.arrays.config);

      var file = this.$refs.attachment.files[0];
      console.log("file data", file);
      client.multipartUpload("temp/file/" + file.name, file, {
        parallel: 4,
        progress: function (per, cpt, res) {
          console.log("percentage ", per);
          console.log("cpt ", cpt);
          console.log("res ", res);
        },
        partclientSize: 1 * 1024 * 1024,
      });
    },

    async getToken() {
      await axiosApi.get("api/oss/token").then(({ data }) => {
        console.log(data);
        this.arrays.config = data.data;
      });
    },

    showTheForm() {
      this.schoolData = {};
      this.showForm = true;
      this.isUpdateMode = false;
    },

    clearSelectedSchool() {
      this.selectedSchool = [];
    },


    searchSchool: _.debounce(async function () {
      await axiosApi
        .post("api/schools/search", {
          search: this.search,
        })
        .then((res) => {
          this.schools = res.data.data;
        });
    }, 300),

   
    async deleteSelectedSchool() {
      this.customConfirmationDialog({
        passFunction: async () => {
          await axiosApi
            .post("api/schools/delete-selected", {
              selectedSchool: this.selectedSchool,
            })
            .then((res) => {
              this.loadSchool();
              this.selectedSchool = [];
              this.$swal("Deleted!", "Your data has been deleted.", "success");
            })
            .catch((err) => {
              console.log(err);
              this.requestError = err;
            });
        },
      });
    },

    async deleteAllRecord() {
      this.customConfirmationDialog({
        passFunction: async () => {
          await axiosApi
            .post("api/schools/delete-all")
            .then((res) => {
              this.loadSchool();
              this.$swal("Deleted!", "Your data has been deleted.", "success");
            })
            .catch((err) => {
              this.requestError = err;
            });
        },
      });
    },

    async loadSchool() {
      this.isFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data.data;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async selectSchool(school, action) {
      if (action === "update") {
        this.schoolData = {};

        
        const schoolData = {
          id: school.id,
          name: school.name,
          files: school.files.length > 0 ? [...school.files] : [],
          organizations: school.departments.length > 0 ? [...school.departments] : [],
          school_year: school.school_year.id,
          created_at: school.created_at,
          update_at: school.update_at,
        };
        
        this.schoolData = schoolData;
        this.isUpdateMode = true;
        this.showForm = true;
      }
      if (action == "delete") {
        this.isUpdateMode = false;
        this.customConfirmationDialog({
          passFunction: () => {
            this.deletesSchool(school.id);
          },
        });
      }
    },
    async deletesSchool(schoolId) {
      axiosApi
        .delete("api/schools/" + schoolId)
        .then((res) => {
          this.loadSchool();
          this.$swal("Deleted!", "Your data has been deleted.", "success");
        })
        .catch((err) => {
          this.requestError = err;
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
    showErrorDialog(error) {
      this.requestError = error;
    },

    closeErrorDialog() {
      this.requestError = null;
    },
    showError() {},

    closeForm(isSchoolAdded) {
      if (isSchoolAdded) {
        this.loadSchool();
      }
      this.showForm = false;
    },
  },
};
</script>

<style scoped></style>
