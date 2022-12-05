<template>
  <div>
    <FormHeader>Add School</FormHeader>
    {{ form }}
    <div class="pt-5">
      <BaseInput
        :label="'School Name'"
        v-model="form.name"
        :hasError="validationError.name"
      />
    </div>
    <div class="pt-2">
      <label for="cover-photo" class="block text-base font-medium text-gray-700"
        >Features Image</label
      >
      <FilePondBase
        :multiple="false"
        :fileType="fileType.image"
        @fileIsUploading="handleLoading"
        @fileIsUploaded="setFile"
        @fileIsDeleted="setFile"
        class="mt-2"
      />
    </div>
    <div class="pt-2">
      <div class="flex justify-end">
        <LinearLoader v-if="isUploading" />
        <div v-else>
          <button
            @click="$emit('close')"
            type="button"
            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Close
          </button>
          <div
            v-if="isLoading"
            type="button"
            class="rounded-md border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            <BaseSpinner />
          </div>

          <button
            v-else
            @click="addSchool"
            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Save
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
  imits: ["hasRequestError","close"],
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
      isLoading: false,
      isUploading: false,
      validationError: {},
      requestError: null,
    };
  },

  methods: {
    handleLoading(value) {
      this.isUploading = value;
    },
    async addSchool() {
      this.isLoading = true;
      await axiosApi
        .post("api/schools", this.form)
        .then((res) => {
          console.log(res);
          this.showToast();
          this.form = {
            name: "",
            files: [],
          };
          this.$emit("close");
          
          console.log(res.data.data);
        })
        .catch((err) => {
          console.log(err);
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
      this.form.files = response;
      console.log("Set  File");
      console.log(response);
    },

    showToast() {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: "Succesfully Saved",
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
