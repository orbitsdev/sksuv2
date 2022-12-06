<template>
  <div>
    <FormHeader>Add School</FormHeader>

    <div class="pt-5">
      <BaseInput
        :label="'School Name'"
        v-model="form.name"
        :hasError="validationError.name"
      />
    </div>


    <!-- {{ schoolData }}
    {{ isUpdateMode }} -->

        {{ form }}
    <div class="py-2" v-if="isUpdateMode && initialFiles.length > 0">
      <label for="cover-photo" class="block text-base font-medium text-gray-700"
        >Your Files
      </label>
      <div class="py-2 flex flex-wrap">
        <FileChip
          @click="removeInitialFiles(file.id)"
          class="m-1"
          v-for="(file, index) in initialFiles"
          :key="file.id"
        >
          {{ file.file_name }}
        </FileChip>
      </div>
      <w-divider class="my-2"></w-divider>
    </div>

    <div class="pt-2">
      <label for="cover-photo" class="block text-base font-medium text-gray-700"
        >Features Image</label
      >

      <FilePondBase
        :multiple="true"
        :fileType="fileType.image"
        @fileIsUploading="handleLoading"
        @fileIsUploaded="setFile"
        @fileIsDeleted="removeFile"
        class="mt-2"
      />
    </div>
    <div class="pt-2">
      <div class="flex justify-end">
        <LinearLoader v-if="isUploading" />
        <div v-else class="flex justify-center items-center">
          <button
            @click="$emit('close', false)"
            type="button"
            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Close
          </button>
          <div
            v-if="isLoading"
            class="bg-white px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            <BaseSpinner />
          </div>

          <button
            v-else
            @click="handleSubmit"
            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            {{ isUpdateMode ? "Update" : "Save" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axiosApi from "../../api/axiosApi";
export default {
  created() {

    if(this.isUpdateMode){
      this.form = {
        name: this.schoolData.name,
        files: this.schoolData.files,
      }
    }
   
  },
  props: {
    isUpdateMode: {
      type: Boolean,
      default: false,
    },
    schoolData: {
      type: Object,
      default: {},
    },
  },
  imits: ["hasRequestError", "close"],
  computed: {
    ...mapGetters(["fileType"]),
    name() {
      return this.data;
    },
  },
  data() {
    return {
      form: {
        name: "",
        files: [],
      },
      initialFiles: [],
      isLoading: false,
      isUploading: false,
      validationError: {},
      requestError: null,
    };
  },

  methods: {
    removeInitialFiles(id) {

      this.form.files =this.form.files.filter((item) => item.id != id);
      this.initialFiles = this.initialFiles.filter((item) => item.id != id);
    },

    handleSubmit() {

      if (this.isUpdateMode) {
        this.updateSchool();
      } else {
        this.addSchool();
      }
    },
    async updateSchool() {



      this.isLoading = true;
      await axiosApi
        .put("api/schools/" + this.schoolData.id, this.form)
        .then((res) => {
            console.log('UPDATE');
            console.log(res.data);
          this.showToast({title: 'Succesfully Update'});
          this.form = {
            name: "",
            files: [],
          };
          this.$emit("close", true);
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.$emit("hasRequestError", {
              statusCode: String(err.response.status),
              message: err.response.statusText,
            });
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    handleLoading(value) {
      this.isUploading = value;
    },
    async addSchool() {
      this.isLoading = true;
      await axiosApi
        .post("api/schools", this.form)
        .then((res) => {
          console.log(res);
          this.showToast({ title: "Succesfully Update" });
          this.form = {
            name: "",
            files: [],
          };
          this.$emit("close", true);
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.$emit("hasRequestError", {
              statusCode: String(err.response.status),
              message: err.response.statusText,
            });
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    setFile(response) { 

      const newfile = response;
      this.form.files.push(newfile);

      if(this.isUpdateMode){
        if(this.initialFiles.length > 0){
          this.form.files =   this.form.files.concat(this.initialFiles);
          
        }
      }


    },
    removeFile(response) {
      const newFile = response;
      this.form.files = this.form.files.filter(file=>  file.folder != newFile.folder);
    },

    showToast({ title = "Succesfully Saved" }) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },
  },
};
</script>

<style scoped></style>
