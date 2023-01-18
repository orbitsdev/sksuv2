<template>
  <div v-if="isFetching">
    <div class="h-80 flex justify-center items-center">
      <Loader1 />
    </div>
  </div>
  <div v-else>
    <h3
      class="text-lg font-extrabold leading-6"
      v-if="application.application_id != null"
    >
      <!-- {{ application.application_form.title }} -->
      {{ application.form_title }}
    </h3>
    <p class="mt-1 max-w-2xl text-sm font-bold">General Information</p>
    <w-divider class="my-1"></w-divider>

    <div v-if="application.fields.length > 0" class="">
      <div v-for="field in application.fields" :key="field.id" class="mb-4">
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
      </div>
    </div>

    <div v.if="application.requirements.length > 0">
        <!-- {{application.requirements}} -->
      
        <div v-for="(requirement_file, parentindex) in application.requirements" :key="requirement_file.id">
            {{ requirement_file }}
            <p class="block font-bold text-gray-700" >{{
                    requirement_file.name
              }}</p>

            <div  v-if="requirement_file.files.length > 0 ">
                <div class="py-2   flex flex-wrap">

                    <FileChip
                    @click="removeExistingFile(parentindex,file.id)"
                    class="m-1"
                    v-for="file in requirement_file.files" :key="file.id">
                        {{ file.file_name }}
                    </FileChip>    
                </div>
            </div>

            <div v-else>
                NOne
            </div>

        </div>


    </div>
  </div>
</template>

<script>
export default {
  props: ["data"],

  data() {
    return {
      application: {
        application_id: null,
        form_id: null,
        form_title: null,
        fields: [],
        requirements: [],
      },
      isSaving: false,
      isFetching: false,
      fields: [],
    };
  },

  created() {
    this.getApplicationForm();
  },

  methods: {

    removeExistingFile(parentindex,id) { 
        
        const  file = this.application.requirements[parentindex].files.find(file=>  file.id == id);
        this.application.requirements[parentindex].files = this.application.requirements[parentindex].files.filter(file=> file.id != id);
        this.application.requirements[parentindex].fileToBeRemove.push(file);
        console.log(this.application.requirements[parentindex].fileToBeRemove);


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

    async getApplicationForm() {
      const dataholder = this.data;

      let new_fields = [];
      let request_parameters = [];
      //   console.log(dataholder);

      dataholder.answers.forEach((item) => {
        // console.log(item);

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

      this.application.application_id = dataholder.id;
      this.application.form_id = dataholder.application_form.id;
      this.application.form_title = dataholder.application_form.title;
      this.application.fields = new_fields;
      // console.log(request_parameters);
      this.fetchDataForSelect(request_parameters);

      let new_requirements = [];

    //   console.log(dataholder);

      dataholder.response_requirements.forEach(item => {

        // console.log(item);

        let new_requirement = {
            response_id: item.id,
            ...item.requirement,
            files: item.files,
            fileToBeRemove: [],

        }

        new_requirements.push(new_requirement);

        // console.log("____________________");
        // console.log(new_requirement);
        
        
      });

      this.application.requirements = new_requirements;

      



    },

 

   
  },
};
</script>

<style scoped></style>
