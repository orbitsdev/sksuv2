<template>
  <div class="bg-white p-6">
    <div v-if="application != null">
      <div class="mb-2">
        <h1 class="text-4xl font-bold">
          {{ application.title }}
        </h1>
    </div>
    
    
    <div v-if="application.fields.length > 0" class="mt-4">

        <h1 class=" text-2xl font-bold mb-2"> General Fields </h1>


        <div class="grid grid-cols-2 gap-4 ">

            <div class="  " v-for="field in application.fields" :key="field.id">
                <div>
                  <label
                    class="block font-bold mb-2 text-gray-700 capitalize"
                    :for="field.name"
                    >{{ field.name }}</label
                  >
                  <input
                    v-if="field.type == 'text'"
                    class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                    :id="field.name"
                    type="text"
                  />
                  
                  <input
                    v-if="field.type == 'email'"
                    class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                    :id="field.name"
                    type="email"
                  />
        
                  <input
                          v-if="field.type == 'number'"
                          class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                          id="number"
                          type="text"
                        />
        
                        <textarea
                          v-if="field.type == 'textarea'"
                          id="description"
                          name="description"
                          class="block w-full rounded-lg p-2 border border-gray-400 focus:outline-none focus:border-green-500"
                        ></textarea>
        
                        <div v-if="field.type == 'select'" class="relative rounded-md shadow-sm">
                            <LinearLoader v-if="field.is_processing" />
                            <div v-else>
                              <select
                                v-if="field.collection_for_select == 'users'"
                                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                                id="satisfaction"
                              >
                                <option v-for="item in field.data" :key="item.id">
                                  {{ item.first_name }} {{ item.last_name }}
                                </option>
                              </select>
                
                              <select
                                v-if="field.collection_for_select == 'departments'"
                                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
                                id="satisfaction"
                              >
                                <option v-for="item in field.data" :key="item.id">
                                  {{ item.name }}
                                </option>
                              </select>
                
                              <select
                                v-if="field.collection_for_select == 'schools'"
                                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"
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
      
    
    </div>

    
    <div v-if="application.requirements.length > 0" class="mt-6">
        <h1 class="my-2 text-2xl font-bold ">Requirements</h1>

        <div class="grid grid-cols-2 gap-4 shadow-sm ">
            <div v-for="requirement in application.requirements" :key="requirement.id" class="  ">
                <!-- {{ requirement.id }}
                {{ requirement.name }}
                {{ requirement.file_type }} -->
  
  
                <label
                class="block font-bold   text-gray-700 capitalize"
                :for="requirement.name"
                >{{ requirement.name}}  </label
              >
                
              <span class="text-xs text-gray capitalize">  {{requirement.file_type}} type  </span>
  
                <FilePondBase
  
                :label="  'Drag & Drop your ' +requirement.file_type "
                :multiple="requirement.upload_type =='single-upload' ? false : true "
                :fileType="requirement.file_type == 'documents' ? fileType.documents :fileType.image"
                @fileIsUploading="false"
                @fileIsUploaded="setFile"
                @fileIsDeleted="removeFile"
                class="mt-2 capitalize"
              />
  
              </div>

        </div>
        
        </div>

        <div class="mt-4">
            <div class="my-2 flex justify-end items-center">
              <div class="flex">
                  <TableButton mode class="mr-2" @click="showForm = false"> Close </TableButton>
                <div>
                  <TableButton class="cursor-not-allowed"> Submit </TableButton>
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
      
    };
  },
  props: {
    applicationId: {
      type: Number,
    },
    title: {
      type: String,
    },
  },

  created() {
    this.getSpicificApplication();
  },

  methods: {

    async submitData(){
        
        // applicationid
        // field_id
        //field_response
        //requirement_id,
        //requirement_file,

        // const application_response = {
        //     title_id: 1,
        //     fields_response: [
        //         {
        //             field_id :1,
        //             field_answer: 1,

        //         }
        //     ], 
        //     requirement_response: [
        //     {
        //         requirement_id: 1,
        //         requirement_file: "data",

        //     }],
        // }

    },
    async getSpicificApplication() {
      this.isFetching = true;


        let new_fields = [];
        let request_parameters = [];

      await axiosApi
        .get("api/application-form/get-application", {
          params: {
            application_id: this.applicationId,
          },
        })
        .then((res) => {
          console.log(res.data.data);
          // console.log(res.data.data);
          this.application = res.data.data;


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
