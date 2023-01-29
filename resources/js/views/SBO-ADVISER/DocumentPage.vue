<template>
    <BaseCard :subtitle="'Officers Documents'">
        <template #header>
            {{ applications }}
            <BaseTableSetup>
                <template #searchs-area>
               
                    <BaseSearchInput
                        :placeholder="'Search Name ...'"
                        v-model="search"
                    />
                </template>
                <template #actions-area> </template>
            </BaseTableSetup>

            <BaseTable
                :thdata="[
                    'Application',
                    'Attachments',
                    'Status',
                    'Submitted At',
                    'Officer',
                    '',
                ]"
                :isFetching="isSaving"
            >
                <template #data>
                
                    <tr class="" v-for="item in  applications" :key="item.id">


                        <td class="whitespace-normal  py-4 sm:pl-6 pl-4">
                            <div class="flex items-center">
                                <div
                                role="img"
                                aria-label="monitor icon"
                                tabindex="0"
                                class="focus:outline-none w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"
                            >
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                  </svg>
                            </div>
                                

                                
                                <div class="whitespace-normal text-wrap pl-5">
                                    <p
                                        tabindex="0"
                                        class="whitespace-normal text-wrap focus:outline-none text-sm font-semibold leading-none text-gray-800 pb-2"
                                    >
                                        Dixons {{ item.application_form.title }} Lorem ipsum dolor, sit amet consectetur 
                                    </p>
                                    <!-- <p
                                        tabindex="0"
                                        class="focus:outline-none text-xs leading-3 text-gray-500"
                                    >
                                        meguc@ruj.io
                                    </p> -->
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-normal py-4 sm:pl-6 pl-4">
                            <div class="flex items-center">
                                <p
                                    tabindex="0"
                                    class="focus:outline-none text-sm leading-tight text-gray-500 pl-3"
                                >
                                    {{ item.response_requirements.length}} Requrements
                                 </p> 
                            </div>
                            <div class="flex items-center">
                                
                                <p
                                    tabindex="0"
                                    class="focus:outline-none text-sm leading-tight text-gray-500 pl-3"
                                >
                                    {{ item.response_requirements.length}} Uploaded 
                                 </p> 
                            </div>
                        </td>
                        <td class="whitespace-normal py-4 sm:pl-6 pl-4">
                            <p
                                tabindex="0"
                                class="focus:outline-none text-sm font-semibold leading-none text-gray-800"
                            >
                            </p>
                            <p v-for="approver in item.approvals" :key="approver.id"
                                tabindex="0"
                                class="focus:outline-none text-xs leading-3 text-gray-500 pt-2"
                            >
                                {{ approver.user.roles }}
                            </p>
                        </td>
                        <td class="whitespace-normal py-4 sm:pl-6 pl-4">
                            <p
                                tabindex="0"
                                class="focus:outline-none text-sm leading-none text-gray-800"
                            >
                                $891.2
                            </p>
                        </td>
                        <td class="whitespace-normal py-4 sm:px-6 px-4">
                            <div class="flex items-center">
                                <p
                                    tabindex="0"
                                    class="focus:outline-none text-sm font-semibold pr-3 leading-none text-gray-800"
                                >
                                    68%
                                </p>
                                <img
                                    src="https://tuk-cdn.s3.amazonaws.com/can-uploader/card89-svg10.svg"
                                    alt="down"
                                />
                            </div>
                        </td>
                    </tr>
                    
                    
                    
                </template>
            </BaseTable>
        </template>

        <teleport to="#app">
            <BaseDialog :show="showDecisionForm" :width="'600'">
                <template #c-content>
                    <div class="">
                        <div class="">
                            <h1
                                class="text-lg text-gray-800 font-semibold mb-4"
                            >
                                Enrollment Accreditaion Application
                            </h1>

                            <div class="flex bg-green-700 rounded-md relative">
                                <div class="flex">
                                    <div
                                        class="px-4 py-6 border-r border-green-600"
                                    >
                                        <div class="h-10 w-10">
                                            <img
                                                src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=250&q=80"
                                                alt="Display Avatar of Jon Harrison"
                                                role="img"
                                                class="h-full w-full rounded-full overflow-hidden shadow object-cover"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-col justify-center pl-3 py-2 sm:py-0"
                                    >
                                        <p
                                            class="text-sm font-bold text-white pb-1"
                                        >
                                            Jon Harrison
                                        </p>
                                        <div
                                            class="flex flex-col sm:flex-row items-start sm:items-center"
                                        >
                                            <p
                                                class="text-xs text-white leading-5"
                                            >
                                              Vice Governor 
                                            </p>

                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>

                        <div>
                            <div class="mt-8">
                                <p
                                    class="text-base font-bold leading-none text-gray-800 uppercase"
                                >
                                    GENERAL INFORMATION
                                </p>
                                <w-divider class="my6 mb-6"></w-divider>

                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Fullname
                                        </p>
                                        <div class="flex flex-wrap mt-2">
                                            <p
                                                class="text-sm leading-none text-gray-600"
                                            >
                                                Maria teresisa Angela
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Contact
                                        </p>
                                        <div class="flex flex-wrap mt-2">
                                            <p
                                                class="text-sm leading-none text-gray-600"
                                            >
                                                Maria teresisa Angela
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Desciption
                                        </p>
                                        <div class="flex flex-wrap mt-2">
                                            <p
                                                class="text-sm leading-none text-gray-600"
                                            >
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit.
                                                Maiores, architecto? Unde, quae
                                                commodi. Culpa odio asperiores,
                                                magnam nam totam atque sapiente
                                                dolore adipisci perferendis
                                                nihil, minima enim voluptatibus
                                                beatae eius.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <p
                                    class="text-base font-bold leading-none text-gray-800 uppercase"
                                >
                                    Requirements Attachment
                                </p>
                                <w-divider class="my6 mb-6"></w-divider>

                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Employee Performance
                                        </p>
                                        <div class="flex flex-wrap mt-3">
                                            <div class="flex items-center mr-2">
                                                <div class="focus:outline-none">
                                                    <img
                                                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                                                        alt="icon"
                                                    />
                                                </div>
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2"
                                                >
                                                    Document
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Employee Performance
                                        </p>
                                        <div class="flex flex-wrap mt-4">
                                            <div
                                                class="flex items-center mr-2 mt-1"
                                            >
                                                <div class="focus:outline-none">
                                                    <img
                                                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                                                        alt="icon"
                                                    />
                                                </div>
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2"
                                                >
                                                    Document
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center mr-2 mt-1"
                                            >
                                                <div class="focus:outline-none">
                                                    <img
                                                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                                                        alt="icon"
                                                    />
                                                </div>
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2"
                                                >
                                                    Document
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center mr-2 mt-1"
                                            >
                                                <div class="focus:outline-none">
                                                    <img
                                                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/grid_card_2-svg3.svg"
                                                        alt="icon"
                                                    />
                                                </div>
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2"
                                                >
                                                    Document
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div>
                                        <p
                                            class="text-base font-bold leading-none text-gray-800"
                                        >
                                            Employee Performance
                                        </p>
                                        <div class="flex flex-wrap mt-3">
                                            <div class="flex items-center mr-2">
                                                <div class="focus:outline-none ">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-4 h-4"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                                                        />
                                                    </svg>
                                                </div>
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2"
                                                >
                                                    No File
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    

                                </div>

                            </div>
                            <!-- <div class="bg-green-50 rounded  p-4">
                               
                              <p class="text-green-700 font-bold uppercase"> Remarks </p>
                              <p class="text-gray-600 text-sm mt-1">To help the applicant understand what needs to be  corrected
                                Please specify if there is a mistake or missing files in the information This way, the applicant can correct and resubmit the application for your review. 
                              </p>
                             

                              <textarea

                              name="description"
                              class="mt-4 block w-full rounded-lg p-2 border border-gray-200 focus:outline-none focus:border-green-500"
                            ></textarea>
                            </div> -->
                        </div>
                    </div>
                    <div class="mt-8 flex justify-between items-center border-t  pt-4 ">
                      <div>
                        <button  class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border  shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" @click="showDecisionForm = false">Close</button>
                      </div>
                      <div>

                        <button  class="hover:shadow mr-2 rounded-md bg-green-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Approve</button>
                        <button  class="hover:shadow mr-2 rounded-md bg-red-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Return </button>
                      </div>
                    </div>
                </template>
            </BaseDialog>

            
        </teleport>

        <teleport to="#app">
          <BaseDialog  :show="showRemarksForm" :width="'620'">
            <template  #c-content>
             

  
            <div class=" rounded-lg  text-green-800 bg-blue-50  py-1 px-3 ">
              <div class="flex items-center">
                <div
                    role="img"
                    aria-label="monitor icon"
                    tabindex="0"
                    class="focus:outline-none  bg-blue-100 rounded-full flex items-center justify-center "
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                
                </div>
                <p
                    tabindex="0"
                    class="focus:outline-none text-sm leading-tight text-gray-500 pl-3"
                >
                Please specify if there is a mistake or missing files in the information This way, the applicant can correct and resubmit the application for your review.
                </p>
            </div>
            
            </div>

            <div class="mt-4">
              <p
              class="text-base font-bold leading-none text-gray-800"
          >
              Remarks
          </p>
              <textarea  class="mt-2 focus:ring-1 focus:ring-gray-200  py-3 pl-3 overflow-y-auto h-24 border placeholder-gray-600 rounded   w-full resize-none focus:outline-none"></textarea>
          </div>
          <div class="flex justify-end item-center   pt-4 ">
           
            <div>
      
              <button  class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border  shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" @click="showRemarksForm = false">Close</button>
              <button  class="hover:shadow mr-2 rounded-md bg-red-600 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Return </button>
            </div>
          </div>

            </template>
          </BaseDialog>
        </teleport>
    
    </BaseCard>
</template>

<script>
import axiosApi from '../../api/axiosApi';
export default {

    created () {
        this.getAllOfficersApplications();
    },
    data() {
        return {
            search: "",
            showDecisionForm: false,
            showRemarksForm: false,
            isFetching: false,
            applications: [],
        };
    },
    methods: {
        async getAllOfficersApplications(){
                this.isFetching = true;

                await axiosApi.get('api/officers/documents').then(res=> {
                        console.log(res.data.data);
                        this.applications = res.data.data;

                }).finally(()=>{
                    this.isFetching = false;
                });
        }
    }
};
</script>

<style scoped></style>
