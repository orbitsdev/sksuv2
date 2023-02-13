<template>
  <LoadingScreen v-if="isFetching"/>
      <div v-else>  
        
        <div v-if="application != null" class="bg-gray-200 p-4 shadow rounded-lg">
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
 

                <p class="block font-rubik font-bold">{{ field.name }}</p>

                <input
                  v-if="field.type == 'text'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                  
                  type="text"
                />

                <input
                  v-if="field.type == 'email'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                  
                  type="email"
                />

                <input
                  v-if="field.type == 'number'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                  
                  type="text"
                />

                <textarea
                  v-if="field.type == 'textarea'"
                  
                  name="description"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                ></textarea>

                <div v-if="field.type == 'select'" class="relative rounded-md shadow-sm">
                  <LinearLoader v-if="field.is_processing" />
                  <div v-else>
                    <select
                      v-if="field.collection_for_select == 'users'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                      
                    >
                      <option v-for="item in field.data" :key="item.id" :value="item.id">
                        {{ item.first_name }} {{ item.last_name }}
                      </option>
                    </select>

                    <select
                      v-if="field.collection_for_select == 'departments'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                      
                    >
                      <option v-for="item in field.data" :key="item.id" :value="item.id">
                        {{ item.name }}
                      </option>
                    </select>

                    <select
                      v-if="field.collection_for_select == 'schools'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                      :id="field.name + field.id"
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

        <!-- <div class="mt-6">
          <div class="my-2 flex justify-end items-center">
            <div class="flex">
              <TableButton mode class="mr-2">
                Back
              </TableButton>
              <div>
                <TableButton  class="" > Submit </TableButton>
              </div>
            </div>
          </div>
        </div> -->
      </div>

      
       
      </div>
  </template>
  
  <script>

import { mapGetters } from "vuex";
  import axios from "axios";
  import axiosApi from "../api/axiosApi";
  import { find } from "filepond";
  export default {
    computed: {
    ...mapGetters(["fileType"]),
  },
    data() {
      return {
        application: null,
        isFetching: false,
      };
    },
  
    created() {

     
       this.loadApplication();
  
    },
  
    props: {
      id: {
        type:Number,
        
      }
    },
    methods: {
      loadDataforSelect() {},
      
      async loadApplication() {

        this.isFetching = true;
        const id = this.id;
        let new_fields = [];
        let request_parameters = [];
  
        await axiosApi
          .get(`api/manage-applications/${id}`)
          .then((res) => {
            let dataholder = res.data.data;
            dataholder.fields.forEach((item) => {
              // for fields
              let modified_field = {
                ...item,
                data: null,
                is_processing: true,
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
  
            dataholder.fields = new_fields;
            this.application = dataholder;
  
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
                    }
                  }
                });
              })
              .catch((error) => {});
          })
          .catch((err) => {})
          .finally(() => {
            this.isFetching = false;
          });
      },
    },
  };
  </script>
  
  <style scoped></style>
  
  