<template>
  <!-- <div class="my-1 p-3 flex items-center justify-space-between">
    <div class="">
      <div class="relative w-full text-gray-400 focus-within:text-gray-600">
        <div
          class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 "
        >
          <svg
            class="h-6 w-6 "
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
              clip-rule="evenodd"
            />
          </svg>
        </div>
        <input
        v-model="search"
          class="block h-full w-full border-transparent py-2   pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-base"
          placeholder="Search"
          type="search"
          name="search"
        />
      </div>
     
    </div>

    <div class="">
      <TableButton
        class="mr-2"
        v-if="selectedSchool.length > 0"
        @click="deleteSelectedSchool"
      >
        <i class="fa-regular fa-trash-can mr-2"></i> Selected ( {{ selectedSchool.length }} )
      </TableButton>

      <TableButton
        class="mr-2"
        v-if="schools.length > 0 && selectedSchool.length <= 0"
        @click="deleteAllRecord"
      >
        <i class="fa-regular fa-trash-can mr-2"></i> Delete All
      </TableButton>
      <TableButton @click="showTheForm"> Add User</TableButton>
    </div>
  </div> -->

  <BaseCard class="shadow-lg border relative">
    <BaseTableSetup>
       
      <template #search-area>
        <div class="flex ">
          <BaseSearchInput v-model="search" class="mx-1"/>
          <BaseFilter class="mx-1" />
        </div>
      </template>
      <template #actions-area>
        <div class="">
          <TableButton
            class="mr-2"
            v-if="selectedSchool.length > 0"
            @click="deleteSelectedSchool"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Selected (
            {{ selectedSchool.length }} )
          </TableButton>
        
          <TableButton
            class="mr-2"
            v-if="schools.length > 0 && selectedSchool.length <= 0"
            @click="deleteAllRecord"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Delete All
          </TableButton>
          <TableButton @click="showTheForm"> <i class="fa-solid fa-plus mr-2"></i>  Add School </TableButton>
        </div>
      </template>
    </BaseTableSetup>
    <TableLoader v-if="isFetching" />
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8"></th>

          <th
            scope="col"
            class="px-3 py-3.5 text-left text-base font-semibold text-gray-900"
          >
            SCHOOL
          </th>

          <th
            scope="col"
            class="px-3 py-3.5 text-left text-base font-semibold text-gray-900"
          >
            FEATURED IMAGE
          </th>

          <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="school in schools" :key="school.id">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <!-- Selected row marker, only show when row is selected. -->
            <div class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>

            <input
              v-model="selectedSchool"
              type="checkbox"
              :value="school.id"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
            />
          </td>
          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900">
                  {{ school.name.toUpperCase() }}
                </div>
              </div>
            </div>
          </td>

          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="flex-shrink-0">
              <div v-if="school.files.length > 0" class="flex">

                <div  v-for="(file, index) in school.files" :key="index">
                  <a :href="'https://skswbrsa.oss-ap-southeast-6.aliyuncs.com/files/schools/'+file.folder + '/' + file.file_name">view</a>
                <img
                class="h-20 w-20 mx-2"
               
                :src="'https://skswbrsa.oss-ap-southeast-6.aliyuncs.com/files/schools/' + file.folder + '/' + file.file_name"
              />
                </div>
               
                <!-- <img v-for="(file , index) in schools.files " :key="index"
                  class="object-fill h-28 w-28"
                  :src="'/uploads/files/schools/' + file.folder + '/' + file.file_name
                  "
                  alt=""
                /> -->
              </div>
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

        <!-- More people... -->
      </tbody>
    </table>
    <!-- <Pagination v-model="page" :records="200" :per-page="25" @paginate="myCallback"/> -->
    <teleport to="#app">
      <BaseDialog :show="!!showForm" :width="'600'" :preventClose="true">
        <template #c-content>
          <SchoolForm
            :schoolData="schoolData"
            :isUpdateMode="isUpdateMode"
            @close="closeForm"
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
    this.getToken();
  },

  data() {
    return {
      arrays:{
        config: []
      },
      page: 1,
      search: "",
      schools: [],
      selectedSchool: [],
      showForm: false,
      requestError: null,
      isFetching: false,
      schoolData: null,
      isUpdateMode: false,

    };
  },

  methods: {
    uploadFile(){
        
      var client = new OSS(this.arrays.config);
 
       var file =  this.$refs.attachment.files[0];
       console.log('file data', file)
       client.multipartUpload('temp/file/'+ file.name , file, {
        parallel: 4,
        progress : function(per, cpt, res) {
          console.log('percentage ', per)
          console.log('cpt ', cpt)
          console.log('res ', res)
        },
        partclientSize : 1 * 1024 * 1024,
       });
      //  console.lo  g(OSS);
      // client =  new OSS({
      //   hellow: '',
      // });
      //   console.log(client);
       
      //   var client = new OSS({
      //     accessKeyId: this.arrays.config.stsId,
      //     accessKeySecret: this.arrays.config.stsKey,
      //     region: this.arrays.config.region,
      //     stsToken: this.arrays.config.stsToken,
      //     bucket: this.arrays.config.bucket,
      //       });

      //       console.log(client)
      //   return;
      //   client.multipartUpload('/test/upload/', file, function(percentage, checkpoint){
      //   console.log(percentage);
      //   console.log(checkpoint);

      // } ,{
      //   accessKeyId: this.arrays.config.stsId,
      //   accessKeySecret: this.arrays.config.stsKey,
      //   region: this.arrays.config.region,
      //   stsToken: this.arrays.config.stsToken,
      //   bucket: this.arrays.config.bucket,
      // } );

    },
  

    async  getToken(){

      await axiosApi.get("api/oss/token").then(({ data   }) => {
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
    async searchSchool() {
      axiosApi
        .post("api/schools/search", {
          search: this.search,
        })
        .then((res) => {
          // console.log(res.data.data);

          this.schools = res.data.data;
          // this.schools = res.data;
          // this.loadSchool();
        });
    },
    async deleteSelectedSchool() {
      this.customConfirmationDialog({
        passFunction: async () => {
          await axiosApi
            .post("api/schools/delete-selected", {
              selectedSchool: this.selectedSchool,
            })
            .then((res) => {
              console.log(res);
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
          console.log(res.data);
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
