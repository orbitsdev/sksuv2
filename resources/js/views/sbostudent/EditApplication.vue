<template>
  <div v-if="isFetching">
    <div class="h-80 flex justify-center items-center">
      <Loader1 />
    </div>
  </div>
  <div v-else>
    <div v-if="application.response_id != null">
      <h3 class="text-lg font-extrabold leading-6">
        <!-- {{ application.application_form.title }} -->
        {{ application.application_form_title }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm font-bold uppercase ">General Information</p>
      <w-divider class="my-1"></w-divider>

      <div v-if="application.fields.length > 0" class="">
        <div v-for="(field,index) in application.fields" :key="field.id" class="mb-4">
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
                  <option v-for="item in field.data" :key="item.id" :value="item.name">
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
          v-if="validationError && validationError[`fields.${index}.answer_value`]"
        >
          {{ validationError["fields." + index + ".answer_value"][0] }}
  
          <!-- {{ index }} -->
        </p>
        </div>
       
      </div>

      <div v.if="application.requirements.length > 0">

        <p class="mt-1 max-w-2xl text-sm font-bold uppercase ">Requirement Attachment </p>
      <w-divider class="my-1"></w-divider>


        <div
        
          v-for="(requirement_file, parentindex) in application.requirements"
          :key="requirement_file.id"
        > 



          <p class="block font-bold text-gray-700">
            {{ requirement_file.name }}
            <span class="text-xs"> ( {{ requirement_file.upload_type }} ) </span>
            <span
              class="text-xs"
              v-if="requirement_file.upload_type == 'multiple-upload'"
            >
              - Existing files ({{ requirement_file.existingFile.length }})
            </span>
          </p>

          <div v-if="requirement_file.existingFile.length > 0" class="mb-2">
            <div class="py-1 flex flex-wrap">
              <FileChip
                class="mx-1 mb-1"
                v-for="file in requirement_file.existingFile"
                :key="file.id"
                @click="removeExistingFile(parentindex, file.id)"
              >
                {{ file.file_name }}
              </FileChip>
            </div>

            <div v-if="requirement_file.upload_type == 'multiple-upload'">
              <FilePondBase
                :label="'Drag & Drop your image here or <u> Browse </u>'"
                :multiple="requirement_file.upload_type == 'single-upload' ? false : true"
                :fileType="getFileTypeData(requirement_file.file_type)"
                @fileIsUploading="requirement_file.handleLoading"
                @fileIsUploaded="requirement_file.setFile"
                @fileIsDeleted="requirement_file.removeFile"
                class="mt-2"
              />
            </div>
          </div>
          <div v-else>
            <div>
              <FilePondBase
                :label="'Drag & Drop your image here or <u> Browse </u>'"
                :multiple="requirement_file.upload_type == 'single-upload' ? false : true"
                :fileType="getFileTypeData(requirement_file.file_type)"
                @fileIsUploading="requirement_file.handleLoading"
                @fileIsUploaded="requirement_file.setFile"
                @fileIsDeleted="requirement_file.removeFile"
                class="mt-2"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" @click="this.$emit('close')"> Close </TableButton>
            <div class="my-1 mx-2" v-if="isSaving">
              <BaseSpinner />
            </div>
            <div v-else>
              <TableButton
             
                class=""
                @click="updateResponse"
              >
                Update
              </TableButton>
              
            </div>
          </div>
    </div>


  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["data"],

  emits: ['close', 'updated'],
  computed: {
    ...mapGetters(["fileType"]),
  },

  data() {
    return {
      application: {
        response_id: null,
        application_form_id: null,
        application_form_title: null,
        fields: [],
        requirements: [],
      },
      isSaving: false,
      isFetching: false,
      validationError: null,
      requestError: null,

    };
  },

  created() {
    this.getApplicationForm();
  },

  methods: {

    async updateResponse(){
      
      this.isSaving = true;


      let new_fields = [];
      let new_requirements = [];



      this.application.fields.forEach(item => {

        // get only th important field data
        let new_field = {
          field_name: item.name,
          field_id:  item.id,
          answer_id: item.answer_id,
          answer_value: item.answer,
        }

        new_fields.push(new_field);

      });



      // also the requirements

      this.application.requirements.forEach(item => {

        let new_requirement = {
          requirement_id: item.id,
          response_requirement_id: item.response_requirement_id,
          files: item.files,
          fileToBeRemove: item.fileToBeRemove,
        };

        new_requirements.push(new_requirement);

      });


        let response_data = {
        response_id: this.application.response_id,
        application_form_id: this.application.application_form_id,
        application_form_title:this.application.application_form_title,
        fields: new_fields,
        requirements: new_requirements,
        }


        // console.log(response_data);
      
        await axiosApi.post("api/application-form/response/update", response_data).then(res=>{
         
            this.validationError = null;
            this.$emit('updated');
          
        }).catch(err=>{

          if (err.response.status === 422) {
            this.validationError = err.response.data.errors;
          } else {
            this.requestError = err;
          }

        }).finally(()=>{
          this.isSaving = false;
        });



    },
    getFileTypeData(someValue) {
      if (someValue == "documents") {
        return this.fileType.documents;
      }

      if (someValue == "image") {
        return this.fileType.image;
      }
    },
    removeExistingFile(parentindex, id) {
      const file = this.application.requirements[parentindex].existingFile.find(
        (file) => file.id == id
      );
      this.application.requirements[
        parentindex
      ].existingFile = this.application.requirements[parentindex].existingFile.filter(
        (file) => file.id != id
      );
      this.application.requirements[parentindex].fileToBeRemove.push(file);
    
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
              

                  field.data.forEach(i => {
                      if(field.asnwer == i.name){

                        field.answer = field.data[0].name;
                      }
                  });

                }
              }
            }
          });
        })
        .catch((error) => {});
    },

    async getApplicationForm() {
      const dataholder = this.data;




      let new_fields = [];
      let request_parameters = [];
   

      dataholder.answers.forEach((item) => {
      

        let new_field = {
          ...item.field,
          answer_id: item.id,
          answer: item.answer_value,
          data: null,
          is_processing: true,
        };

        if (item.field.type == "select") {
          let request_parameter = {
            tablename: item.field.collection_for_select,
            field_id: item.field.id,
          };

          request_parameters.push(request_parameter);
        } else {
          new_field.is_processing = false;
        }

        new_fields.push(new_field);
      });

      // new application

      new_fields.sort(function (a, b) {
        return a.index - b.index;
      });

      this.application.response_id = dataholder.id;
      this.application.application_form_id = dataholder.application_form.id;
      this.application.application_form_title = dataholder.application_form.title;
      this.application.fields = new_fields;
      this.fetchDataForSelect(request_parameters);

      let new_requirements = [];



      dataholder.response_requirements.forEach((item, index) => {


        let new_requirement = {
          response_requirement_id: item.id,
          ...item.requirement,
          files: [],
          existingFile: item.files,
          fileToBeRemove: [],
          isUploading: false,
          isComplete: false,
          isAdding: false,

          handleLoading: (value) => {
            this.application.requirements[index].isUploading = value;
          },

          setFile: (response) => {
            this.application.requirements[index].files.push(response);
          },
          removeFile: (response) => {


            const newFile = response;

            this.application.requirements[index].files = this.application.requirements[
              index
            ].files.filter((file) => file.folder != newFile.folder);
          },
        };

        new_requirements.push(new_requirement);

      });

      this.application.requirements = new_requirements;
    },
  },
};
</script>

<style scoped></style>
