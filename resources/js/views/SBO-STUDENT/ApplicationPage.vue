<template>
  <div>
    <div v-if="isFetching">
      <div class="h-screen flex justify-center items-center">
        <Loader1 />
      </div>
    </div>

    <div v-else>
      <div v-if="response != null">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-extrabold leading-6">
              {{ response.application_form.title }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm font-bold">General Information</p>
          </div>
          <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
              <div
                v-if="response.answers.length == 0"
                class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
              ></div>

              <div
                v-else
                class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                v-for="answer in response.answers"
                :key="answer.id"
              >
                <dt class="text-sm font-medium text-gray-500">{{ answer.field.name }}</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 capitalize">
                  {{ answer.answer_value }}
                </dd>
              </div>

              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6" v-if=" response.response_requirements.length == 0">

              </div>

              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6" v-else>
                <!-- {{ response.response_requirements }} -->
             
                <dt class="text-sm font-medium text-gray-500">Attachments</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                   
                   <!-- {{ response.response_requirements}} -->
                    <div v-for="rf in  response.response_requirements" :key="rf.id">
                        <p class="capitalize font-semibold mb-1"> {{ rf.requirement.name }}</p>

                        <div v-if="rf.files.length > 0" class=" my-1 ">
                          
                            <div  class="" v-for=" file in rf.files " :key="file.id">
                                <!-- Heroicon name: mini/paper-clip -->
                                <div>
                                    <div class="inline-flex flex-nowrap items-center justify-center border  px-2 rounded py-1">                                    
                                        <svg class="h-5 w-5 mr-1  text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="">{{file.file_name}}</span>
                                        <div class="ml-2 text-xs uppercase"> <i class=" fa-regular fa-file"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            None 
                        </div>
                        
                    </div>


                </dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
      <div v-else>
        <EmptyCard
          :url="'/assets/undraw_thoughts_re_3ysu.svg'"
          :m="'No Application Is Available'"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  props: ["id"],

  data() {
    return {
      isFetching: false,
      response: null,
    };
  },
  created() {
    this.getResponse();
  },
  methods: {
    async getResponse() {
      this.isFetching = true;

      axiosApi
        .post("api/monitor/response", {
          id: this.id,
        })
        .then((res) => {
          this.response = res.data.data;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },

    async setInitialValueToForm() {},
  },
};
</script>

<style scoped></style>
