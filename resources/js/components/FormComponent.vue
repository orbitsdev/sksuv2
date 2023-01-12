<template>
  <LoadingScreen v-if="isFetching"/>
      <div v-else>

        <div class="" v-if="application != null">
          <div class=" rounded  mb-4 border-t-4 border-green-600 p-4 shadow">
            <h1 class="text-lg font-bold mb-4">{{ application.title }}</h1>
          </div>
          <div v-if="application.fields.length == 0" class="flex justify-center">
            <div>

              <img src="/assets/empty.svg" alt="" width="100" height="100">
              <p class="text-center text-lg font-bold mt-4 capitalize"> This Application doesnt have  any fields yet </p>
            </div> 
              
          </div>
          <div class="p-4 rounded shadow-md" v-if="application.fields.length > 0">
            <div class="mb-4" v-for="field in application.fields" :key="field">
              <div>
                <label
                  v-if="field.type == 'text'"
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  for="name"
                  >{{ field.name }}</label
                >
                <input
                  v-if="field.type == 'text'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-indigo-500"
                  id="name"
                  type="text"
                  placeholder="John Smith"
                />
      
                <label
                  v-if="field.type == 'email'"
                  class="block font-bold mb-2 text-gray-700"
                  for="email"
                  >{{ field.name }}</label
                >
                <input
                  v-if="field.type == 'email'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-indigo-500"
                  id="email"
                  type="email"
                  placeholder="john@example.com"
                />
      
                <label
                  v-if="field.type == 'number'"
                  class="block font-bold mb-2 text-gray-700"
                  for="number"
                  >{{ field.name }}</label
                >
                <input
                  v-if="field.type == 'number'"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-indigo-500"
                  id="number"
                  type="text"
                  placeholder="0912300023"
                />
      
                <label
                  v-if="field.type == 'textarea'"
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  for="email"
                  >{{ field.name }}</label
                >
                <textarea
                  v-if="field.type == 'textarea'"
                  id="description"
                  name="description"
                  class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-indigo-500"
                ></textarea>
      
                <label
                  v-if="field.type == 'select'"
                  class="block font-bold mb-2 text-gray-700 capitalize"
                  for="satisfaction"
                  >{{ field.name }}</label
                >
                <div v-if="field.type == 'select'" class="relative rounded-md shadow-sm">
                  <LinearLoader v-if="field.is_processing" />
                  <div v-else>
                    <select
                      v-if="field.collection_for_select == 'users'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                      id="satisfaction"
                    >
                      <option v-for="item in field.data" :key="item.id">
                        {{ item.first_name }} {{ item.last_name }}
                      </option>
                    </select>
      
                    <select
                      v-if="field.collection_for_select == 'departments'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                      id="satisfaction"
                    >
                      <option v-for="item in field.data" :key="item.id">
                        {{ item.name }}
                      </option>
                    </select>
      
                    <select
                      v-if="field.collection_for_select == 'schools'"
                      class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                      id="satisfaction"
                    >
                      <option v-for="item in field.data" :key="item.id">
                        {{ item.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class=" rounded mt-4 mb-4 border-t-4 border-green-600 p-4 shadow">
            <h1 class="text-lg font-bold mb-4">Application Requirements</h1>
               
     
            <div v-if="application.requirements.length > 0">
          
              <div v-for="requirement in application.requirements" :key="requirement.id" class="mb-4 ">
                <!-- <p class="text-gray-400 text-sm my-2">Not Authorize </p>  -->
                <label
                class="block font-bold mb-2 text-gray-700 capitalize"
                for="email"
                >{{ requirement.name }}</label
              >
           
                <FilePondBase

                :label="'Drag & Drop your files here or <u> Browse </u>'"
                :multiple="requirement.upload_type =='single-upload' ? false : true "
                :fileType="requirement.file_type == 'documents' ? fileType.documents :fileType.image"
                @fileIsUploading="false"
                @fileIsUploaded="setFile"
                @fileIsDeleted="removeFile"
                class="mt-2"
              />
              <w-divider class="my-4"></w-divider>
              </div>
            </div>
          </div>
         
          <div class="mt-4">
            <div class="my-2 flex justify-end items-center">
              <div class="flex">
                <div>
                  <TableButton class="cursor-not-allowed"> Submit </TableButton>
                </div>
              </div>
            </div>
          </div>
         
        </div>
      
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
  
  