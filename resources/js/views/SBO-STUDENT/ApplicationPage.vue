


<template>
  <div>
    <div class="flex mb-4 items-center justify-between">
      <BackCard class="" @click="this.$router.back()" />
      <p class="text-2xl font-rubik font-bold text-green-700">{{ page }}</p>
    </div>


    <div v-if="isFetching">
      <div class="h-screen flex justify-center items-center">
        <Loader1 />
      </div>
    </div>
    <div v-else>
    
      <FormParentCard  v-if="response != null" :title="response.application_form.title">
        <template #action>
          <div class="flex justify-end"> 
            <TableButton @click="showForm = true">
              Update <i class="ml-2 text-xs fa-solid fa-pencil"> </i>
            </TableButton>
           </div>      
        </template>
        <section class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4">
  
          <h1 class="text-lg font-bold font-rubik mb-2 uppercase">University</h1>
          <p class="block font-rubik ">Sultan Kudarat Saye Univsersit</p>
  
        </section>
        <section class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4">
  
          <h1 class="text-lg font-bold font-rubik mb-2  uppercase">General Information</h1>
          
          <div class="mb-2"   v-for="answer in response.answers"
          :key="answer.id">
            <p class="block font-rubik font-bold">{{ answer.field.name }}</p>
            <p class="block font-rubik  "> {{  answer.answer_value  }}</p>
          </div>
        
        </section>
        <section class="px-3 bg-gray-300 pt-2 pb-4 rounded-lg mt-4">
  
          <h1 class="text-lg font-bold font-rubik mb-2  uppercase">Requirements</h1>
          <div class="mb-2"  v-for="rf in response.response_requirements" :key="rf.id"
          >
          <p class="block font-rubik font-bold mb-1">{{  rf.requirement.name }}</p>
            
          
          <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
            <!-- {{ response.response_requirements}} -->
              
              <div v-if="rf.files.length > 0" class=" bg-gray-400  rounded-lg p-4">
                <a :href="file.url"
                  class="bg-gray-700 inline-block mr-2 my-2 cursor-pointer hover:scale-105 hover:bg-gray-900 transition-all ease-in-out   p-2 rounded-lg"
                  v-for="file in rf.files"
                  :key="file.id"
                   >

                  <div class="mb-0.5">
                    <div class="flex flex-wrap items-center">
                      <svg
                        class="h-5 w-5 mr-1 text-white font-bold"
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
                      <span class="font-rubik text-white">{{ file.file_name }}</span>
                      <!-- <div class="ml-2 text-xs uppercase"> <i class=" fa-regular fa-file"></i></div> -->
                    </div>
                  
                </div>
              </a>
               
             
            </div>
             <div v-else class=" inline-block font-rubik   text-gray-500 p-1 rounded-lg ">
                No File
              </div>
          </dd>
          </div>
        
        </section>
      </FormParentCard>
  
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
        .post("api/monitor/specific-response", {
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
