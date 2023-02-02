<template>
  <BaseCard :subtitle="'Officers Documents'">
    <template #header>
      <!-- <h1> {{confirmMode}}</h1> -->
      <!-- <hr> -->

      <p v-if="selectedItem != null">

        {{ selectedItem.response_approvals }}
      </p>

      <BaseTableSetup>
        <template #searchs-area>
          <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />
        </template>
        <template #actions-area> </template>
      </BaseTableSetup>

      <BaseTable
        :thdata="[
          '',
          'Application',
          'Status',
          'Officer',
          'Dates',
          '',
        ]"
        :isFetching="isFetching"
      >
        <template #data>

          <tr v-if="applications.length < 0">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            
          </tr>
          <tr v-else class="" v-for="item in applications" :key="item.id">

            <td class="whitespace-normal  align-top relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="whitespace-normal  align-top py-4">
              <div class="flex">
                <div
                  role="img"
                  aria-label="monitor icon"
                  tabindex="0"
                  class="focus:outline-none w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 text-green-700"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                    />
                  </svg>
                </div>

                <div class="whitespace-normal  align-top text-wrap pl-4">
                  <p
                    tabindex="0"
                    class="whitespace-normal  align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800 pb-2"
                  >
                    {{ item.application_form.title }}
                  </p>
                  <div>
                    <div class="flex items-center">
                      <div
                        class="w-5 h-5 rounded-full flex items-center justify-center mr-2"
                      >
                      <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth="{1.5}"
                      stroke="currentColor"
                      class="w-6 h-6 text-orange-700"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                      />
                    </svg>
                      </div>
                     
                      <StatusCard class="mt-2 first-letter:capitalize bg-orange-100 text-orange-900"> 
                        {{ item.response_requirements.length > 0 ? item.response_requirements.length : '' }} Requirements
                         
                      </StatusCard>
                    </div>
                    <div class="flex items-center ">
                      <div
                        class="w-5 h-5 mt-2 rounded-full flex items-center justify-center mr-2"
                      >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  text-lime-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                      </svg>
                      
                      </div>

                      <StatusCard class="mt-2 first-letter:capitalize bg-lime-100 text-lime-900"> 
                        {{ totalFiles(item.response_requirements) }}   Uploads
                         
                      </StatusCard>

                   
                   
                     
                    </div>
                   
                    <button 
                      @click="showRemarksFormToEditRemarks(item)"
                    v-if="item.remarks.length > 0 " class="flex items-center mt-2">
                      <div
                        class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                      >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-700 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                      </svg>
                      
                      </div>
                      <p
                        tabindex="0"
                        class="focus:outline-none text-sm leading-none bg-red-100 text-red-900 px-3 py-1 rounded-full font-semibold"
                      >
                        {{ item.remarks.length  }} {{ item.remarks.length >1 ?  'Remarks' : 'Remark'  }}
                      </p>
                    </button>
                  </div>
                </div>
              </div>
            </td>

            <td class="whitespace-normal  align-top py-4">
              <div v-if="item.response_approvals.length > 0">
                <p
                tabindex="0"
                class="focus:outline-none text-sm leading-none text-gray-800 font-semibold "
              >
                  Approval Satus
              </p>
              <div class="" v-for="ap in item.response_approvals" :key="ap.id">
                <StatusCard class="mt-2 capitalize bg-blue-100 text-blue-900"  v-if="ap.status == 'null'">Processing  </StatusCard>
                <StatusCard class="mt-2 capitalize bg-blue-100 text-blue-900"  v-if="ap.status == 'processing'">{{ ap.status }}  </StatusCard>
                <StatusCard class="mt-2 capitalize bg-cyan-100 text-cyan-900"  v-if="ap.status == 're-evaluating'">{{ ap.status }}  </StatusCard>
                <StatusCard class="mt-2 capitalize bg-green-100 text-green-900"  v-if="ap.status == 'approved'"> {{ ap.status }}  </StatusCard>
                <StatusCard class="mt-2 capitalize bg-red-100 text-red-900"  v-if="ap.status == 'returned'"> {{ ap.status }}  </StatusCard>
              </div>
            </div>
            <div v-else></div>

            <div class="mt-4">
              <p
              tabindex="0"
              class="focus:outline-none text-sm leading-none text-gray-800 font-semibold"
            >
              Indorsed Status
            </p>
            <div class=" flex items-center">
              <StatusCard class="mt-2 first-letter:capitalize bg-green-100 text-green-900"> 
                Indorsed
              </StatusCard>
             
              <StatusCard class="mt-2 first-letter:capitalize bg-gray-100 text-gray-900"> 
                Not Yet
              </StatusCard>
             
              
            </div>
            </div>
            <div>

            </div>
             

            </td>
            
            <td class="whitespace-normal  align-top py-4">
              <p
                tabindex="0"
                class="focus:outline-none text-sm leading-none text-gray-800 font-semibold capitalize"
              > 

              {{ item.user.first_name  }}               {{ item.user.last_name  }}

              </p>

              
              <StatusCard class="mt-2 first-letter:capitalize bg-gray-100 text-gray-700 font-semibold"> 
                 {{ item.user.officer.position }} 
                 
              </StatusCard>
              


            </td>
            <td class="whitespace-normal  align-top py-3">
              

              <DateCard class="mt-2">
                <template #label> 
                  Officer Submitted
                </template>
                {{ formatDate(item.created_at) }}
  
              </DateCard>
              <DateCard class="mt-2" >
                <template #label> 
                  Aprroved Date
                </template>
                {{ formatDate(item.update_at) }}
  
              </DateCard>
              <DateCard class="mt-2" >
                <template #label> 
                  Indorsed Date
                </template>
                {{ formatDate(item.created_at) }}
  
              </DateCard>
              
            </td>
            <td class="whitespace-normal  align-top py-4">
              <button
              @click="showApprovalForm(item)"
                type="button"
                class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </td>
          </tr>
        </template>
      </BaseTable>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showDecisionForm" :width="'600'" :preventClose="true">
        <template #c-content>
          <div v-if="selectedItem !=  null" class="">
            <div class="">
              <h1 class="text-2xl text-gray-800 font-bold leading-5 mb-4">
                {{selectedItem.application_form.title}} 
              </h1>

              <div class="flex bg-green-700 rounded-md relative">
                <div class="flex">
                  <div class="px-4 py-6 border-r border-green-600">
                    <div class="h-10 w-10">
                      <img
                        src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=250&q=80"
                        alt="Display Avatar of Jon Harrison"
                        role="img"
                        class="h-full w-full rounded-full overflow-hidden shadow object-cover"
                      />
                    </div>
                  </div>
                  <div class="flex flex-col justify-center pl-3 py-2 sm:py-0">
                    <p class="text-lg font-bold text-white  capitalize">{{selectedItem.user.first_name}} {{selectedItem.user.last_name}} </p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                      <p class="text-sm text-white leading-5">{{selectedItem.user.officer.position}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div class="mt-6">
               
                  <div v-if="selectedItem.answers.length > 0">
                    <p class="text-base font-bold leading-none text-gray-800 uppercase">
                      GENERAL INFORMATION
                    </p>
                    <w-divider class="my6 mb-6"></w-divider>
                      <!-- {{ selectedItem.answers }} -->
                    <div class="mb-4" v-for="af in selectedItem.answers" :key="af.id">
                      
                      <div>
                        <p class="text-base font-bold leading-none text-gray-800 capitalize"  >{{ af.field.name }}</p>
                        <div class="flex flex-wrap mt-2">
                          <p class="text-sm leading-none text-gray-600 capitalize" >
                            {{ af.answer_value }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
             <div v-if="selectedItem.response_requirements.length > 0">
            
              <div class="mt-8">
                <p class="text-base font-bold leading-none text-gray-800 uppercase">
                  Requirements & Attachment
                </p>
                <w-divider class="my6 mb-6"></w-divider>


                <div class="mb-4"  v-for="rq in selectedItem.response_requirements " :key="rq.id">
                  <div>
                    <p class="text-base font-bold leading-none text-gray-800">
                      {{ rq.requirement.name }}
                    </p>
                    <div class="flex flex-wrap mt-4" v-if="rq.files.length > 0" >
                      <a href="#" class="hover:shadow-lg py-1 px-2  border rounded-full flex items-center mr-2 mt-1"   v-for="file in  rq.files" :key="file.id">
                        <div class="focus:outline-none">
                          <img
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                            alt="icon"
                          />
                        </div>
                        <p class="text-sm leading-none text-gray-600 ml-2">{{ file.file_name }}</p>
                      </a>
                    </div>

                    <div class="flex flex-wrap mt-3" v-else>
                      <div class="flex items-center mr-2">
                        <div class="focus:outline-none">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                            />
                          </svg>
                        </div>
                        <p class="text-sm leading-none text-gray-600 ml-2">No File</p>
                      </div>
                    </div>

                    
                  </div>
                </div>

             
              </div>
             </div>
              

            
            </div>
          </div>
          <div class="mt-8 flex justify-between items-center border-t pt-4">
            <div>
              <button
                class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
                @click="closeApprovalForm()"
              >
                Close
              </button>
            </div>
            <div>
              
              <button
              v-if="( confirmMode != 'approved'   ) "
              @click="showConfirmationForm"
                class="hover:shadow mr-2 rounded-md bg-green-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
                Approve
              </button>
              <button
              v-if="confirmMode == 'approved'"

              @click="showConfirmationForm"
                class="hover:shadow mr-2 rounded-md bg-green-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
              Re Evaluate
              </button>


              <button
              
              @click="showRemarksForm = true "
                class="hover:shadow mr-2 rounded-md bg-red-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
              >
               {{ confirmMode == 'returned' ? 'Add Remark' : 'Return' }}
              </button>

            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
      <BaseDialog :show="showRemarksForm" :width="'620'" :preventClose="true">
        <template #c-content>
          <div
          tabindex="0"
          class="focus:outline-none   text-sm bg-indigo-100 text-indigo-700 dark:text-indigo-600 rounded font-medium p-2  "
        >
        Please specify if there is a mistake or missing files in the information
        This way, the applicant can correct and resubmit the application for your
        review.
        </div>
          
      

          <div class="mt-4">
            <p class="text-base font-bold leading-none text-gray-800">Remarks</p>
            <textarea
            v-model.trim="remark"
            
              class="mt-2 focus:ring-1 focus:ring-gray-200 py-3 pl-3 overflow-y-auto h-24 border placeholder-gray-600 rounded w-full resize-none focus:outline-none"
            ></textarea>
          </div>
          <div class="flex justify-end item-center pt-4">
            <button
            class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
            @click="showRemarksForm = false"
          >
            Close
          </button>
          <div class="p-2" v-if="isReturning">
            <BaseSpinner  />
          </div>
          <button
          :disabled="remark.length <=0"
          v-else
          @click="returnForm"
            :class="[' mr-2 rounded-md  px-3.5 py-1.5 text-base font-semibold leading-7  shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600', remark.length > 0 ? 'bg-rose-700 hover:bg-red-500 text-white hover:shadow' :'bg-gray-50 text-gray-400' ]"
          >
            Submit
          </button>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <teleport to="#app">
        <BaseDialog :show="showConfirmation" :width="'500'" :preventClose="true">
          <template #c-content>

            
            <ConfirmCard v-if="(confirmMode != 'approved' )  " :title="'Are Your Sure?'" :message=" 'Do you want to approve this application'">
              <div class=" col-span-1  flex justify-center items-center" v-if="isSaving">
                  <BaseSpinner/>
              </div>
              <button v-else @click="approveForm" class="col-span-1  transition duration-150 ease-in-out hover:bg-green-600 bg-green-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm">Yes</button>
                <button class=" col-span-1  ml-3 bg-gray-100  transition duration-150 text-gray-600  ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" @click="showConfirmation = false"> Close</button>
            </ConfirmCard>
            <ConfirmCard v-if="(confirmMode == 'approved')" :title="'Are Your Sure?'" :message=" 'Do you want to re-evaluate this application'">
              <div class=" col-span-1  flex justify-center items-center" v-if="isSaving">
                  <BaseSpinner/>
              </div>
              <button v-else @click="approveForm" class="col-span-1  transition duration-150 ease-in-out hover:bg-green-600 bg-green-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm">Yes</button>
                <button class=" col-span-1  ml-3 bg-gray-100  transition duration-150 text-gray-600  ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" @click="showConfirmation = false"> Close</button>
            </ConfirmCard>

          </template>
        </BaseDialog>
        <BaseDialog :show="showRemarksFormToEdit" :width="'500'" :preventClose="true">
          <template #c-content> 
            
            <div class="relative">
              <h1 class="text-lg font-bold my-2 px-4">{{selectedItem.application_form.title}}</h1>
              <ul class="max-h-80 overflow-y-auto border-t-2 rounded-t-lg px-4 ">
      
      
                  <RemarksCard v-for="(i, index ) in adviser_remarks" :key="i.id" :message="i.message" :index="index+1" :date="formatDate(i.updated_at)" :active="selectedRemark == i.id" @click="selectRemark(i)">
      
                  </RemarksCard>
                 
              </ul>
              <div class="py-2 ">
          
                  <textarea
                  v-model.trim="remarksForEdit"
                  
                    class="mt-2 focus:ring-1 focus:ring-gray-200 py-3 pl-3 overflow-y-auto h-24 border placeholder-gray-600 rounded w-full resize-none focus:outline-none"
                  ></textarea>
      
                  
               <div class="flex justify-end items-center mt-2">
                  <button
                  @click="closeRemarksFormToEditRemarks"
                  class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
                >
                  Close
                </button> 
                  <div class="p-2" v-if="isUpdating" >
                      <BaseSpinner  />
                    </div>
                    <div v-else>
                      <button 
                      @click="updateRemark"
                      :disabled="(remarksForEdit.length <=0  || selectedRemark == null )"
                      :class="[' mr-2 rounded-md  px-3.5 py-1.5 text-base font-semibold leading-7  shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600', (remarksForEdit.length > 0  && selectedRemark != null )  ? 'bg-green-700 hover:bg-green-500 text-white hover:shadow' :'bg-gray-50 text-gray-400' ]"
                      
                      >
                      Update
                    </button>
                     
                  </div>
                  <div class="p-2" v-if="isDeletingRemarks" >
                    <BaseSpinner  />
                  </div>
              <button
              v-else
                  @click="deleteRemark"
                :disabled="selectedRemark == null"
                 :class="['hover:shadow mr-2 rounded-md  px-3.5 py-1.5 text-base font-semibold leading-7  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600' ,selectedRemark != null  ? 'hover:bg-red-500 text-white shadow-sm bg-red-600' : 'bg-gray-50 text-gray-400' ]"
              >
                    Delete
              </button>

               </div>
              </div>
          </div>
          </template>
        </BaseDialog>
      </teleport>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";
import moment from "moment";
export default {
  created() {
    this.getAllOfficersApplications();
  },

  
  data() {
    return {
      search: "",
      remark:'',
      remarksForEdit:'',
      showDecisionForm: false,
      showConfirmation:false,
      showRemarksForm: false,
      isFetching: false,
      applications: [],
      isSaving: false,
      confirmMode: null,
      selectedItem:null,
      requestError :null,
      isReturning: false,
      showRemarksFormToEdit: false,
      adviser_remarks: [],
      selectedRemark: null,
      isUpdating: false,
      isDeletingRemarks: false,
    };
  },
  methods: {

    closeRemarksFormToEditRemarks(){
      this.remarksForEdit= '';
      this.selectedRemark= null;
      this.selectedItem = null;
      this.showRemarksFormToEdit = false;


    },

    selectRemark(item){


      this.selectedRemark = item.id;
      this.remarksForEdit = item.message;

    },

    async deleteRemark(){

      this.isDeletingRemarks = true;
      let remark_data = {
          response_id: this.selectedItem.id,
          remark_id: this.selectedRemark,
      }

      await axiosApi.post('api/form/remark/delete', remark_data).then(res=>{

        this.remarksForEdit = '';
        this.selectedRemark = null;
        this.getAllOfficersApplications();
        this.showRemarksFormToEdit = false;

}).catch(err=>{ 

console.log(err);
}).finally(()=>{
  this.isDeletingRemarks = false;
});
      
    },

    async updateRemark(){

      this.isUpdating = true;
      let remark_data = {
          response_id: this.selectedItem.id,
          remark_id: this.selectedRemark,
          message: this.remarksForEdit
      }


      
        await axiosApi.post('api/form/remark/update', remark_data).then(res=>{



          this.getAllOfficersApplications();
          this.remarksForEdit = '';
          this.selectedRemark = null;
          this.showRemarksFormToEdit = false;

        }).catch(err=>{ 

          console.log(err);
        }).finally(()=>{
            this.isUpdating = false;
        });
    },

    showRemarksFormToEditRemarks(item){
      
      this.selectedItem = item;
      this.adviser_remarks = this.selectedItem.remarks;

      this.showRemarksFormToEdit = true;
    },
    async returnForm(){
      // this.isReturning = true;
      let current_approval = this.findApproval(this.selectedItem);

      
      let decision_data = {
          response_id: this.selectedItem.id,
          approval_id: current_approval.id,
          status: 'returned',
          remark: this.remark
      };


      console.log(decision_data);

      await axiosApi.post('api/form/return', decision_data ).then(res=>{
       
              this.showRemarksForm = false;
              this.showDecisionForm = false;
              this.selectedItem = null;
              this.confirmMode = null;
              this.getAllOfficersApplications();
              this.remark = '';
          }).catch(err=>{
              console.log(err);
          }).finally(()=>{
            this.isReturning = false;
          });



    },
   async approveForm(){
      
    this.isSaving = true;
    

      // console.log(this.selectedItem);
      let current_approval = this.findApproval(this.selectedItem);
    

      let current_status = '';

      if(current_approval.status != 'null' ||  current_approval.status != 'approved' ){
          current_status = 'approved';
      }
      
      if(current_approval.status == 'approved'){
        current_status = 're-evaluating';
      }


      let decision_data = {
          response_id: this.selectedItem.id,
          approval_id: current_approval.id,
          status: current_status,
      };
      // console.log(decision_data);

          await axiosApi.post('api/form/approve', decision_data ).then(res=>{
              console.log(res.data);
              this.showConfirmation = false; 
              this.showDecisionForm = false;
              this.selectedItem = null;
              this.confirmMode = null;
              

              this.getAllOfficersApplications();
              
          }).catch(err=>{
              console.log(err);
          }).finally(()=>{
            this.isSaving = false;
          });
    },

    formatDate(date) {
      return moment(date).format("MMM, D YYYY hh:mm a");
    },
    totalFiles(item) {
    let total = 0;
    item.forEach(item => {
      total += item.files.length;
    });
    return total;
  },

    closeApprovalForm(){
      this.selectedItem = null;
      this.showDecisionForm = false;
    },
    showApprovalForm(item){
      
      this.selectedItem = item;

      let current_approval = this.findApproval(item);
      this.confirmMode = current_approval.status;
      this.showDecisionForm  = true;
    },

    findApproval(item){
      let current_approval = item.response_approvals.find(element => element.role_name === 'sbo-adviser' && element.response_id === item.id);
    
      return current_approval;
    },

    showConfirmationForm(){
      
    
      this.showConfirmation = true;
    

      

    },  

    async getAllOfficersApplications() {
      this.isFetching = true;

      await axiosApi
        .get("api/officers/documents")
        .then((res) => {
          console.log(res.data.data);
          this.applications = res.data.data;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style scoped></style>
