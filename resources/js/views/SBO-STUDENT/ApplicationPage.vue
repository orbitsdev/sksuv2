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
          <div class="flex items-center justify-between">
            <div class="px-4 py-5 sm:px-6">
              <h3 class="text-lg font-extrabold leading-6">
                {{ response.application_form.title }}
              </h3>
              <p class="mt-1 max-w-2xl text-sm font-bold">General Information</p>
            </div>
            <div class="px-8">
              <button
                @click="showForm = true"
                class="border px-2 py-1 hover:shadow-lg cursor-pointer rounded-lg text-white bg-green-700"
              >
                <div class="flex items-center">
                  <span class="text-sm mr-1">Edit</span>
                  <i class="text-xs fa-solid fa-pencil"> </i>
                </div>
              </button>
            </div>
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

              <div
                class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                v-if="response.response_requirements.length == 0"
              ></div>

              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6" v-else>
                <!-- {{ response.response_requirements }} -->

                <p class="mt-1 max-w-2xl text-sm font-bold">Requirement Attachment</p>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                  <!-- {{ response.response_requirements}} -->
                  <div v-for="rf in response.response_requirements" :key="rf.id">
                    <p class="capitalize font-semibold mb-2">{{ rf.requirement.name }}</p>

                    <div v-if="rf.files.length > 0" class="  ">
                      <div
                        class="inline-flex mr-2 mb-1 text-green-800 bg-green-100 font-bold text-sm flex-nowrap items-center justify-center px-2 rounded-lg py-1 hover:shadow-lg cursor-pointer"
                        v-for="file in rf.files"
                        :key="file.id"
                      >
                        <div class="mb-0.5">
                          <div class="flex flex-wrap items-center">
                            <svg
                              class="h-5 w-5 mr-1 text-green-800 font-bold"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                              aria-hidden="true"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                clip-rule="evenodd"
                              />
                            </svg>
                            <span class="">{{ file.file_name }}</span>
                            <!-- <div class="ml-2 text-xs uppercase"> <i class=" fa-regular fa-file"></i></div> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else class="flex items-center rounded-full">
                      <div
                        class="inline-flex mr-2 mb-1 text-gray-400 text-sm flex-nowrap items-center justify-center px-2 py-1"
                      >
                        <div class="mb-0.5">
                          <div class="flex flex-wrap items-center">
                            <span class="">No file</span>
                            <!-- <div class="ml-2 text-xs uppercase"> <i class=" fa-regular fa-file"></i></div> -->
                          </div>
                        </div>
                      </div>
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

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'600'" :preventClose="true">
        <template #c-content>
          <EditApplication
            @close="showForm = false"
            @updated="handleUpdate"
            :data="response"
          />
        </template>
      </BaseDialog>
    </teleport>
  </div>
</template>

<script>
import EditApplication from "./EditApplication.vue";
import axiosApi from "../../api/axiosApi";
export default {
  props: ["id"],

  components: {
    EditApplication,
  },
  data() {
    return {
      isFetching: false,
      response: null,
      showForm: false,
      isSaving: false,
    };
  },
  created() {
    this.getResponse();
  },
  methods: {
    handleUpdate() {
      this.showForm = false;

      this.getResponse();
    },

    updateResponse() {
      console.log("yow");
    },

    showEditForm() {
      this.showEditForm = true;
    },
    async getResponse() {
      this.isFetching = true;

      axiosApi
        .post("api/monitor/response", {
          id: this.id,
        })
        .then((res) => {
          res.data.data.answers.sort((a, b) => {
            return a.field.index - b.field.index;
          });

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
