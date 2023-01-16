<template>
  <div class="bg-white p-6 runded-lg shadow-sm">
    <div v-if="application != null">
      <div class="mb-2">
        <h1 class="text-4xl font-bold">
          {{ application.title }}
        </h1>
      </div>

      <div v-if="application.fields.length > 0" class="mt-4">
        <h1 class="text-2xl font-bold mb-2">General Fields</h1>

        <div class="grid grid-cols-2 gap-x-4 gap-y-4">
          <div v-for="(field, index) in application.fields" :key="field.id">
            <!-- <div  v-for="field in application.fields" :key="field.id" :class="[field.type == 'textarea' ? 'col-span-2' : '']"> -->
            <!-- {{ field }} -->
            <div>
              <label class="block font-bold text-gray-700" :for="field.name">{{
                field.name
              }}</label>
              <input
                v-if="field.type == 'text'"
                class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                :id="field.name"
                v-model="field.answer"
                type="text"
              />

              <input
                v-if="field.type == 'email'"
                class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                :id="field.name"
                v-model="field.answer"
                type="email"
              />

              <input
                v-if="field.type == 'number'"
                class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                :id="field.name"
                v-model="field.answer"
                type="text"
              />

              <textarea
                v-if="field.type == 'textarea'"
                :id="field.name"
                v-model="field.answer"
                name="description"
                class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
              ></textarea>

              <div v-if="field.type == 'select'" class="relative rounded-md shadow-sm">
                <LinearLoader v-if="field.is_processing" />
                <div v-else>
                  <select
                    v-if="field.collection_for_select == 'users'"
                    class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                    :id="field.name"
                    v-model="field.answer"
                  >
                    <option v-for="item in field.data" :key="item.id" :value="item.id">
                      {{ item.first_name }} {{ item.last_name }}
                    </option>
                  </select>

                  <select
                    v-if="field.collection_for_select == 'departments'"
                    class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                    :id="field.name"
                    v-model="field.answer"
                  >
                    <option v-for="item in field.data" :key="item.id" :value="item.id">
                      {{ item.name }}
                    </option>
                  </select>

                  <select
                    v-if="field.collection_for_select == 'schools'"
                    class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                    :id="field.name + field.id"
                    v-model="field.answer"
                  >
                    <option v-for="item in field.data" :key="item.id" :value="item.id">
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <p
              class="text-xs text-red-500 mt-1"
              v-if="validationError && validationError[`answers.${index}.answer`]"
            >
              {{ validationError["answers." + index + ".answer"][0] }}

              <!-- {{ index }} -->
            </p>
          </div>
        </div>
      </div>

      <div v-if="application.requirements.length > 0" class="mt-6">
        <h1 class="my-2 text-2xl font-bold">Requirements</h1>

        <div class="grid grid-cols-4 gap-x-4 gap-y-1">
          <div
            v-for="requirement in application.requirements"
            :key="requirement.id"
            class="  "
          >
            <!-- {{ requirement }} -->

            <label class="block font-bold text-gray-700" :for="requirement.name"
              >{{ requirement.name }}
            </label>

            <span class="text-xs text-gray capitalize text-gray-500">
              {{ requirement.file_type }} |
            </span>
            <span class="text-xs text-gray capitalize text-gray-500">
              {{ requirement.upload_type }}
            </span>

            <FilePondBase
              :label="'Drag & Drop your  files here or <u>Browse</u>'"
              :multiple="requirement.upload_type == 'single-upload' ? false : true"
              :fileType="
                requirement.file_type == 'documents' ? fileType.documents : fileType.image
              "
              @fileIsUploading="requirement.handleLoading"
              @fileIsUploaded="requirement.setFile"
              @fileIsDeleted="requirement.removeFile"
              class="mt-2 tex-sm"
            />
            <LinearLoader v-if="requirement.isUploading" />
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="my-2 flex justify-end items-center">
          <div class="flex">
            <TableButton mode class="mr-2" @click="showForm = false"> Close </TableButton>
            <div>
              <BaseSpinner class="mx-2" v-if="isSaving"/>
              <TableButton  v-else class="" @click="submitData"> Submit </TableButton>
            </div>
          </div>
        </div>
      </div>
    </div>

   
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["fileType"]),
  },

  data() {
    return {
      application: null,
      isFetching: false,
      isSaving:false,
      response: {
        application_id: null,
        fields_answer: [],
        requirements_files: [],
      },
      validationError: null,
      requestError: null,
    };
  },
  props: {
    applicationId: {
      type: String,
    },
    title: {
      type: String,
    },
  },

  created() {
    this.getSpicificApplication();
  },

  methods: {
    async submitData() {

      this.isSaving = true;
      this.response.fields_answer = [];
      this.response.requirements_files = [];

      this.application.fields.forEach((item) => {
        let field_with_answer = {
          field_id: item.id,
          name: item.name,
          type: item.type,
          answer: item.answer,
        };

        this.response.fields_answer.push(field_with_answer);
      });

      this.application.requirements.forEach((item) => {
        let new_requirement_file = {
          requirement_id: item.id,
          name: item.name,
          type: item.file_type,
          upload_type: item.upload_type,
          files: item.files,
        };

        this.response.requirements_files.push(new_requirement_file);
      });

      let new_response = {
        application_id: this.response.application_id,
        answers: this.response.fields_answer,
        requirements: this.response.requirements_files,
      };

      axiosApi
        .post("api/application-form/response/create", new_response)
        .then((res) => {
          this.validationError = null;
          console.log(res.data);
          // console.log(res.data.id);
         this.$router.push({name: 'monitor-app', params: {id: res.data.id} });
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = err;
          }
        }).finally(()=>{
          this.isSaving = false;
        });
    },

    async fetchDataForSelect(request_parameters) {
      axios
        .all(
          request_parameters.map((parameter) =>
            axios.get("/api/application-fields-for-select/fetch", {
              params: parameter,
            })
          )
        )
        .then((results) => {
          this.application.fields.forEach((field) => {
            if (field.type == "select") {
              let data = results.find((result) => result.data.field_id == field.id);

              if (field.id == data.data.field_id) {
                field.data = data.data.data;
                field.is_processing = false;
                if (field.data.length > 0) {
                  field.answer = field.data[0].id;
                }
              }
            }
          });
        })
        .catch((error) => {});
    },

    modifyFields(fields) {
      let new_fields = [];

      let request_parameters = [];

      fields.forEach((item) => {
        // for fields
        let modified_field = {
          ...item,
          data: null,
          is_processing: true,
          answer: null,
        };

        // select type field
        if (item.type == "select") {
          let request_parameter = {
            tablename: item.collection_for_select,
            field_id: item.id,
          };
          request_parameters.push(request_parameter);
        } else {
          // make it false when field is not select type
          modified_field.is_processing = false;
        }

        new_fields.push(modified_field);
      });

      return {
        fields: new_fields,
        request_parameters: request_parameters,
      };
    },

    modifyRequirements(requirements) {
      let new_requirements = [];

      requirements.forEach((item, index) => {
        let requirement = {
          ...item,
          files: [],
          isUploading: false,

          handleLoading: (value) => {
            this.application.requirements[index].isUploading = value;
          },

          setFile: (response) => {
            this.application.requirements[index].files.push(response);
          },
          removeFile: (response) => {
            console.log(response);

            const newFile = response;

            this.application.requirements[index].files = this.application.requirements[
              index
            ].files.filter((file) => file.folder != newFile.folder);
          },
        };
        new_requirements.push(requirement);
      });

      return new_requirements;
    },
    async getSpicificApplication() {
      this.isFetching = true;

      await axiosApi
        .get("api/application-form/get-application", {
          params: {
            application_id: parseInt(this.applicationId),
          },
        })
        .then((res) => {
          let dataholder = res.data.data;
          this.response.application_id = dataholder.id;

          let modified_data = {
            ...this.modifyFields(dataholder.fields),
          };

          // console.log(this.modifyRequirements(dataholder.requirements));

          dataholder.fields = modified_data.fields;
          dataholder.requirements = this.modifyRequirements(dataholder.requirements);

          this.application = dataholder;
          this.fetchDataForSelect(modified_data.request_parameters);
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped></style>
