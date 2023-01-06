<template>
  <div class="mx-auto max-w-lg w-full mt-10" v-if="application != null">
    <div class="bg-white rounded mt-10 mb-5 border-t-4 border-green-600 p-4 shadow">
      <h1 class="text-lg font-bold mb-4">{{ application.title }}</h1>
    </div>

    <div class="p-4 bg-white rounded shadow-md">
      <div class="mb-4" v-for="field in application.fields" :key="field">
        <!-- {{ field.type }} -->
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
            type="number"
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

      <div class="mt-4">
        <div class="my-2 flex justify-end items-center">
          <div class="flex">
            <TableButton mode class="mr-2"> Close </TableButton>

            <div>
              <TableButton> Save </TableButton>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white rounded mt-10 mb-5 p-4 shadow">
      <router-link
        :to="'/dashboard/osas/manage-application'"
        class="text-blue-600 font-bold"
      >
        GO BACK TO MANAGE APPLICATION
      </router-link>
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
</template>

<script>
import axios from "axios";
import axiosApi from "../api/axiosApi";
import { find } from "filepond";
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
        .finally(() => {});
    },
  },
};
</script>

<style scoped></style>
gi
