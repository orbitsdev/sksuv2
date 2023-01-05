<template>
  <div class="" v-if="application != null">
    <div class="mx-auto max-w-lg w-full mt-20 p-4 bg-white rounded shadow-md">
      <router-link :to="'/dashboard/osas/manage-application'"> Back </router-link>
      <h1 class="text-lg font-bold mb-4">{{ application.title }}</h1>

      <!-- {{ application }} -->
      <div
        class="border-2 shadow border-green-200 my-1"
        v-for="field in application.fields"
        :key="field.id"
      >
        <p class="my-1 p-2">name :{{ field.name }}</p>
        <p class="my-1 p-2">type: {{ field.type }}</p>
        <p class="my-1 p-2">collection :{{ field.collection_for_select }}</p>
        <p class="my-1 p-2">data :{{ field.data }}</p>
        <div class="flex">
            <p class="my-1 p-2">processing :{{ field.is_processing   }}</p>
            <BaseSpinner v-if="field.is_processing"/>
        </div>
      </div>
      <!-- <div class="mb-4" v-for="field in application.fields" :key="field">
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
              v-if="field.type == 'textarea'"
              class="block font-bold mb-2 text-gray-700"
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
              class="block font-bold mb-2 text-gray-700"
              for="satisfaction"
              >{{ field.name }}</label
            >
            <div v-if="field.type == 'select'" class="relative rounded-md shadow-sm">
              {{ field.data }}

              <select
                v-if="field.collection_for_select == 'users'"
                class="block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                id="satisfaction"
              >
                <option v-for="item in field.data" :key="item.id">
                  {{ item.first_name }} {{ item.last_name }}
                </option>
              </select>
            </div>
          </div>
        </div> -->

      <div class="mt-4">
        <div class="my-2 flex justify-end">
          <TableButton mode class="mr-2"> Close </TableButton>
          <div class="my-1 mx-2">
            <BaseSpinner />
          </div>
          <div>
            <TableButton> Save </TableButton>
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
import axios from "axios";
import axiosApi from "../api/axiosApi";
import { find } from 'filepond';
export default {
  data() {
    return {
      application: null,
      isFetching: false,
    };
  },

  created() {
    this.loadApplication();
  },

  watch() {},

  methods: {
    loadDataforSelect() {},
    async loadApplication() {
      const id = this.$route.params.id;
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
            }else{
                // make it false when field is not select type
                modified_field.is_processing = false;
            }

            new_fields.push(modified_field);

            

          });

          dataholder.fields = new_fields;
          this.application = dataholder;

          // console.log(new_fields);
          // console.log(request_parameters);

          axios.all(
              request_parameters.map((parameter) =>
                axios.get("/api/application-fields-for-select/fetch", {
                  params: parameter,
                })
              )
            )
            .then((results) => {
                // results.forEach(element => {
                //         console.log(element.data.data);
                // });

                this.application.fields.forEach(field => {

                    if(field.type == "select"){
                        let  ob = results.find((result) => result.data.field_id == field.id);
                        console.log(ob.data.field_id);


                    }
 
                });
            })
            .catch((error) => {});
        })
        .catch((err) => {})
        .finally(() => {});
    },
  },
};
</script>

<style scoped></style>gi
