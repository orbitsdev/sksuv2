<template>
  <BaseCard :subtitle="'Manage Requirements'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            Create Requirements
          </TableButton>
          <BaseSearchInput :placeholder="'Search Requirements ...'" v-model="search" />
        </template>
        <template #filters-area></template>
        <template #actions-area>
          <TableButton
            v-if="selectedRequirements.length > 0"
            @click="deleteSelectedRequirement"
            :mode="true"
            class="mr-2"
          >
            <i class="fa-regular fa-trash-can mr-2"></i> Delete Selected
            {{ selectedRequirements.length }})
          </TableButton>
        </template>
      </BaseTableSetup>
      <BaseTable
        :thdata="['', 'Name', 'File Type', 'Upload Type', '']"
        :isFetching="isFetching"
      >
        <template #data>
          <tr v-for="item in requirements" :key="item.id">
            <td class="relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                v-model="selectedRequirements"
                :value="item"
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="text-sm">
              <div class="flex items-center">
                <div class="capitalize">
                  {{ item.name }}
                </div>
              </div>
            </td>
            <td class="text-sm">
              <div class="flex items-center">
                <div class="capitalize">
                  <span
                    class="inline-flex rounded bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5"
                  >
                    {{ item.file_type }}
                  </span>
                </div>
              </div>
            </td>
            <td class="text-sm">
              <div class="flex items-center">
                <div class="capitalize">
                  <span
                    class="inline-flex rounded bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 m-0.5"
                  >
                    {{ item.upload_type }}
                  </span>
                </div>
              </div>
            </td>

            <td class="py-2 text-sm text-gray-500">
              <button
                :disabled="selectedRequirements.length > 0"
                @click="selectRequirement(item)"
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
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true">
        <template #c-content>

          <p class="text-base font-bold">Requirement Name</p>

          <div class="py-2">
            <div>
              <BaseInput v-model="requirementForm.title" />
              <p class="text-xs text-red-500 mt-1" v-if="validationError.name">
                {{ validationError.name[0] }}
              </p>
            </div>
          </div>

          <w-divider class="my6"></w-divider>
          <div>
            <div class="mt-1">
              <p class="text-base font-bold">Attachment Type</p>
            </div>
            <div class="">
              <div v-for="type in requirementForm.attachmentsData" :key="type.id">
                <div class="flex items-center p-1 rounded-sm">
                  <input
                    v-model="type.selected"
                    @change="handleSelecteAttachmentType(type)"
                    type="checkbox"
                    class="w-4 h-4 accent-green-600 text-white mr-1 border-blue-700 border-2 cursor-pointer"
                  />
                  <label class="mr-1 capitalize text-xs"> {{ type.name }} </label>
                </div>
              </div>
              <p class="text-xs text-red-500 mt-1" v-if="validationError.file_type">
                {{ validationError.file_type[0] }}
              </p>
            </div>
            <w-divider class="my6 my-2"></w-divider>
          </div>
          <div>
            <div class="mt-1">
              <p class="text-base font-bold">Uploads</p>
            </div>
            <div class="">
              <div v-for="uploadtype in requirementForm.uploadData" :key="uploadtype.id">
                <div class="flex items-center p-1 rounded-sm">
                  <input
                    v-model="uploadtype.selected"
                    @change="handleUploadType(uploadtype)"
                    type="checkbox"
                    class="w-4 h-4 accent-green-600 text-white mr-1 border-blue-700 border-2 cursor-pointer"
                  />
                  <label class="mr-1 capitalize text-xs"> {{ uploadtype.name }} </label>
                </div>
              </div>
            </div>
            <p class="text-xs text-red-500 mt-1" v-if="validationError.upload_type">
              {{ validationError.upload_type[0] }}
            </p>

            <w-divider class="my6 my-2"></w-divider>
          </div>

          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="closeTheForm"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton v-if="isUpdateMode" class="" @click="updateRequirement">
                Update
              </TableButton>
              <TableButton v-else class="" @click="createRequirement"> Save </TableButton>
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
      search: "",
      isFetching: false,
      showForm: false,
      isSaving: false,
      requestError: null,
      requirements: [],
      selectedRequirement: null,
      selectedRequirements: [],
      validationError: {},
      isUpdateMode: false,
      isDeleting: false,

      requirementForm: {
        title: "",
        selectedType: "",
        selectedUploadType: "",
        attachmentsData: [
          { id: 0, name: "Image", value: "image", selected: false },
          { id: 1, name: "Documents", value: "documents", selected: false },
        ],
        uploadData: [
          { id: 0, name: "Single Upload", value: "single-upload", selected: false },
          { id: 1, name: "Multiple Upload", value: "multiple-upload", selected: false },
        ],
      },
    };
  },

  created() {
    this.loadRequirements();
  },

  
  watch: {
    search(olvalue, newvalue) {
      this.searchRequirement();
    },
  },

  methods: {

     
       async searchRequirement() {

      await axiosApi
        .post("api/manage-requirement/search", {
          search: this.search,
        })
        .then((res) => {
          this.requirements = res.data.data;
        });
    },

    selectRequirement(item) {
      this.isUpdateMode = true;

      // Get The details
      const selected_requirement = {
        id: item.id,
        name: item.name,
        file_type: item.file_type,
        upload_type: item.upload_type,
      };

      this.requirementForm.title = selected_requirement.name;
      this.requirementForm.selectedType = selected_requirement.file_type;
      this.requirementForm.selectedUploadType = selected_requirement.upload_type;

      this.requirementForm.attachmentsData.forEach((i) => {
        if (i.value == item.file_type) {
          i.selected = true;
        }
      });

      this.requirementForm.uploadData.forEach((i) => {
        if (i.value == item.upload_type) {
          i.selected = true;
        }
      });

      this.selectedRequirement = selected_requirement;

      this.showForm = true;
    },

    async updateRequirement() {
      this.selectedRequirement.name = this.requirementForm.title;
      this.selectedRequirement.file_type = this.requirementForm.selectedType;
      this.selectedRequirement.upload_type = this.requirementForm.selectedUploadType;

      await axiosApi
        .post("api/manage-requirement/update", this.selectedRequirement)
        .then((res) => {
          this.clearRequirementForm();
          this.loadRequirements();
          this.selectedRequirement = null;
          this.showForm = false;
        })
        .catch((err) => {
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

    clearRequirementForm() {
      this.validationError = {};
      this.requirementForm.title = "";
      (this.requirementForm.selectedType = ""),
        (this.requirementForm.selectedUploadType = ""),
        this.requirementForm.attachmentsData.forEach((i) => {
          i.selected = false;
        });
      this.requirementForm.uploadData.forEach((i) => {
        i.selected = false;
      });

      this.selectedRequirements = [];
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

    async deleteSelectedRequirement() {
      this.customConfirmationDialog({
        title: "Are you sure do you want to delete selecred requiremens?",
        passFunction: async () => {
          const selected_requirements_id = [];

          this.selectedRequirements.forEach((element) => {
            selected_requirements_id.push(element.id);
          });

          this.isDeleting = true;

          await axiosApi
            .post("api/manage-requirement/delete-selected", {
              requirements_id: selected_requirements_id,
            })
            .then((res) => {
              this.clearRequirementForm();
              this.loadRequirements();
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

    async loadRequirements() {
      this.isFetching = true;

      await axiosApi
        .get("api/manage-requirement")
        .then((res) => {
          this.requirements = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async createRequirement() {
      this.isSaving = true;
      const newRequirement = {
        name: this.requirementForm.title,
        file_type: this.requirementForm.selectedType,
        upload_type: this.requirementForm.selectedUploadType,
      };

      await axiosApi
        .post("api/manage-requirement/create", newRequirement)
        .then((res) => {
          this.clearRequirementForm();
          this.loadRequirements();
          this.selectedRequirement = null;
          this.showForm = false;
        })
        .catch((err) => {
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
      this.isUpdateMode = false;
      this.validationError = {};
      this.clearRequirementForm();
      this.showForm = true;
    },
    closeTheForm() {
      this.clearRequirementForm();
      this.showForm = false;
    },

    handleSelecteAttachmentType(item) {
      this.requirementForm.attachmentsData.forEach((i) => {
        i.selected = false;
      });
      item.selected = true;
      this.requirementForm.selectedType = item.value;
    },
    handleUploadType(item) {
      this.requirementForm.uploadData.forEach((i) => {
        i.selected = false;
      });

      item.selected = true;
      this.requirementForm.selectedUploadType = item.value;
    },
  },
};
</script>

<style scoped></style>
