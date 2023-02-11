<template>
  <div>
    <BackCard class="mb-4" @click="this.$router.back()" />
    <div v-if="isFetching" class="flex items-center justify-center h-96">
      <Loader1 />
    </div>
    <div  v-else class="bg-gray-200 p-4 shadow rounded-lg">
    
      <div v-if="application != null">
        <div class="mb-2 border-b-4 pb-2 border-gray-900 uppercase">
          <h1 class="text-2xl font-rubik font-semibold">
            {{ application.title }}
          </h1>
        </div>
        <div
        v-if="application.fields.length > 0"
        class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4"
      >
      <h1 class="text-lg font-bold font-rubik mb-2 uppercase">University</h1>
      <section class="mt-2">
        <div>

          <p class="block font-rubik mb-1">Choose where to Send</p>
          <NoDataCard v-if="schools.length <= 0">Empty </NoDataCard>
          <select
            v-else
            v-model="selected_school"
            class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
          >
            <option v-for="school in schools" :key="school.id" :value="school.id">
              {{ school.name }} 
            </option>
          </select>
        </div>
      </section>
      </div>
       
       

        <div
          v-if="application.fields.length > 0"
          class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4"
        >
          <h1 class="text-lg font-bold font-rubik mb-2 uppercase">General Fields</h1>

          <div class="grid grid-cols-2 gap-x-16 gap-y-6 mt-1 px-2">
            <div v-for="(field, index) in application.fields" :key="field.id">
              <!-- <div  v-for="field in application.fields" :key="field.id" :class="[field.type == 'textarea' ? 'col-span-2' : '']"> -->
              <!-- {{ field }} -->
              <div>
                <label class="block font-rubik mb-1" :for="field.name">{{
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

        <div
          v-if="application.requirements.length > 0"
          class="mt-4 px-3 bg-gray-300 pt-2 pb-4 rounded-lg"
        >
          <h1 class="text-lg font-bold font-rubik mb-2 uppercase">Requirements</h1>

          <div class="grid grid-cols-4 gap-x-4 gap-y-1">
            <div
              v-for="requirement in application.requirements"
              :key="requirement.id"
              class="  "
            >
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
                  requirement.file_type == 'documents'
                    ? fileType.documents
                    : fileType.image
                "
                @fileIsUploading="requirement.handleLoading"
                @fileIsUploaded="requirement.setFile"
                @fileIsDeleted="requirement.removeFile"
                class="mt-2 tex-sm"
              />
              <!-- <LinearLoader v-if="requirement.isUploading" /> -->
            </div>
          </div>
        </div>

        <div class="mt-6">
          <div class="my-2 flex justify-end items-center">
            <div class="flex">
              <TableButton mode class="mr-2" @click="this.$router.back()">
                Back
              </TableButton>
              <div>
                <BaseSpinner class="mx-2" v-if="isSaving" />
                <TableButton v-else class="" @click="submitData"> Submit </TableButton>
              </div>
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
      isSaving: false,
      response: {
        application_id: null,
        fields_answer: [],
        requirements_files: [],
      },
      validationError: null,
      requestError: null,

      school_years: [],
      schools: [],
      selected_school: null,
      isSchoolFetching: false,
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
    this.getOfficersSchool();
    // this.getAllSchoolYears();
    this.getSpicificApplication();
  },

  methods: {
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
              this.selected_school = this.schools[0].id;
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

    async getOfficersSchool() {
      this.isSchoolFetching = true;

      await axiosApi
        .get("api/application-form/get-school-of-officer")
        .then((res) => {

          console.log(res.data.data);
          this.schools = res.data.data;

          if (this.schools.length > 0) {
            this.selected_school = this.schools[0].id;
          }
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  fetchin information school information, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isSchoolFetching = false;
        });
    },

    changeHandler(event) {
      let year_with_schools = this.school_years.find((i) => i.id == event.target.value);
      this.schools = year_with_schools.schools;
      this.selected_school = null;
      if (this.schools.length > 0) {
        this.selected_school = this.schools[0].id;
      }
    },

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
        school_year_id: this.selected_school_year,
        school_id: this.selected_school,
      };

      axiosApi
        .post("api/application-form/response/create", new_response)
        .then((res) => {
          this.validationError = null;
          console.log(res.data);
          // console.log(res.data.id);
          this.$router.push({ name: "monitor-app", params: { id: res.data.id } });
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
