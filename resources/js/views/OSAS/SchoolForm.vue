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


    <div class="py-2" v-if="isUpdateMode && existingFile.length > 0">
      <label for="cover-photo" class="block text-base font-medium text-gray-700"
        >Your Files
      </label>
      <div class="py-2 flex flex-wrap">
        <FileChip
          @click="removeExistingFile(file.id)"
          class="m-1"
          v-for="(file, index) in existingFile"
          :key="file.id"
        >
          {{ file.file_name }}
        </FileChip>
      </div>
      <w-divider class="my-2"></w-divider>
    </div>

    <div class="pt-2">
      <label for="cover-photo" class="block    text-base text-gray-700" >Features Image</label
      >
      <FilePondBase
        v-if="noExisintData"
        :multiple="allowmultiple"
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
            @click="handleClose"
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
            :disabled="isLoading"
            v-else
            @click="handleSubmit"
            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-green-700 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
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
        files: [],
      }

      this.existingFile = this.schoolData.files;
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
    
  emits: ["hasRequestError", "close", "hasUnsaveFile"],
  computed: {
    ...mapGetters(["fileType"]),
    name() {
      return this.data;
    },

    noExisintData(){
      return (this.existingFile.length <=0);
    }
  },

  data() {
    return {
      allowmultiple: false,
      form: {
        name: "",
        files: [],
      },
      existingFile: [],
      fileToBeRemove: [],
      isLoading: false,
      isUploading: false,
      validationError: {},
      requestError: null,
    };
  },

  methods: {

    handleClose(){

      if(this.form.files.length > 0){
        const filesfolder = [];
        this.form.files.forEach(file=>{
            filesfolder.push(file.folder);
        });

        this.$emit('hasUnsaveFile',  filesfolder)
       

      }else{
        this.$emit('close', false);
      }

    
    },  

   

    removeExistingFile(id) {  

      const  file =  this.existingFile.find(file=>  file.id == id);
      this.existingFile =  this.existingFile.filter(file=>  file.id != id);
      this.fileToBeRemove.push(file);
      console.log(this.fileToBeRemove);
        // console.log(this.existingFile);

    },

    handleSubmit() {

      if (this.isUpdateMode) {
        this.updateSchool();
      } else {
        this.addSchool();
      }
    },
    async updateSchool() {

      await axiosApi
        .put("api/schools/" + this.schoolData.id, {
          ...this.form,
          filetoberemove: this.fileToBeRemove
        })
        .then((res) => {

 
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
