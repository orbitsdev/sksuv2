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
                   
                    'Approval Status',
                    'Indorsed Status',
                    'Officer',
                    'Submitted At',
                    '',
                ]"
                :isFetching="isSaving"
            >
                <template #data>
                
                    <tr class="">


                        <td class="whitespace-normal  py-4 ">
                            <div class="flex ">
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
                                        class="whitespace-normal font-bold text-wrap focus:outline-none text-sm  leading-none text-gray-800 pb-2"
                                    >
                                        Dixons Enollment Accreditation
                                    </p>
                                    <div>
                                    <p class=" ml-1 ">Attachments</p>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mr-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-700 ">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                              </svg>
                                              
                                        </div>
                                        <p
                                            tabindex="0"
                                            class="focus:outline-none text-sm leading-tight p-1 rounded  text-pink-700 "
                                        >
                                         5  Checklist 
                                         </p> 
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-4 h-4 text-blue-700 ">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                              </svg>

                                           
                                              
                                              
                                        </div>
                                        <p
                                            tabindex="0"
                                            class="focus:outline-none text-sm leading-tight p-1 rounded  text-blue-700   "
                                        >
                                            5 Uploads
                                         </p> 
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                      
                        <td class="whitespace-normal py-4 ">

                            <div class="flex items-center ">
                                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center mr-1">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-yellow-700">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                                    </svg>
      
                                    
                              </div>
                  <p
                      tabindex="0"
                      class="focus:outline-none text-sm  leading-none text-gray-800"
                  >
                  Processing
                  </p>
                            </div>
                           
                           
                          
                        </td>
                        <td class="whitespace-normal py-4 ">
                            <div class="flex items-center ">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-1">
<!-- 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-yellow-700">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                                    </svg> -->

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                      </svg>
                                      
      
                                    
                              </div>
                  <p
                      tabindex="0"
                      class="focus:outline-none text-sm  leading-none text-gray-800"
                  >
                  Not Yet Inodorsed
                  </p>
                            </div>
                           
                           
                        </td>
                        <td class="whitespace-normal py-4 ">
                            <p
                                tabindex="0"
                                class="focus:outline-none text-sm leading-none text-gray-800"
                            >
                              Maria Kte Romoe Bonifiacio
                            </p>
                            
                            <p
                                 tabindex="0"
                                class="focus:outline-none text-xs leading-none text-blue-600 font-semibold mt-1"
                            >
                            (  GOVERNOR  ) </p>

                            </td>
                        <td class="whitespace-normal">
                            <div class="flex items-center">
                                <p
                                    tabindex="0"
                                    class="focus:outline-none text-sm  leading-none text-gray-800"
                                >
                                    January 12 202032
                                </p>
                            
                            </div>
                        </td>
                        <td class="whitespace-normal py-4 ">
                            <div class="flex items-center">
                                <p
                                    tabindex="0"
                                    class="focus:outline-none text-sm font-semibold pr-3 leading-none text-gray-800"
                                >
                                    Options
                                </p>
                               
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
                    class="focus:outline-none text-sm leading-tight text-gray-500 "
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
