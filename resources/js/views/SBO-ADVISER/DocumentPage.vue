
<template>
    <BaseCard :subtitle="'Officers Documents'">   

    <template #header>
        <BaseTableSetup>
            <template #searchs-area>
              <!-- <TableButton class="mr-2" 
                ><i class="fa-solid fa-plus mr-1"> </i> Add Officer
              </TableButton> -->

              <BaseSearchInput :placeholder="'Search Name ...'" v-model="search" />

            
            </template>
            <template #actions-area>
            </template>
          </BaseTableSetup>

          <BaseTable
          :thdata="['Application','Files','Status', 'Submitted At','Officer', '']"
          :isFetching="isSaving"
        >

        <template  #data>
          <tr>

            <td class="whitespace-normal text-sm">
              <div class="flex items-center">
                <div class="">
                  <div class="font-medium text-gray-900">
              ENROLL MEN ACCREDITATION 
                  </div>
                </div>
              </div>
            </td>

            <td>
              <div class=" rounded text-blue   text-xs font-bold leading-5  "> <i class="pr-1  fa-regular fa-file"></i> 5 Requrements</div>
              <div class=" rounded text-blue   text-xs font-bold leading-5  "> <i class="pr-1  fa-solid fa-paperclip"></i> 2 Attachments </div>
            </td>
            <td>
              <span class="inline-flex rounded bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Approved</span>
              <!-- <span class="inline-flex rounded bg-blue-100 px-2 text-xs font-semibold leading-5 text-green-800">Pending</span>
              <span class="inline-flex rounded bg-red-100 px-2 text-xs font-semibold leading-5 text-green-800">Denied</span> -->
            </td>
            <td>
              <div class="font-medium text-gray-900">11/2023</div>
            </td>

            
            <td   class="w-full max-w-0 py-4  pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none ">
              <p class="font-bold"> Kate Romo</p>
              <dd class=" truncate text-gray-700">Governor</dd>
            </td>
            <td class="whitespace-normal py-2 text-sm text-gray-500">
              <button

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
      <BaseDialog :show="true" :width="'860'">
        <template #c-content>

        </template>
      </BaseDialog>
    </teleport>
    
    </BaseCard>




    
     
    </template>
    
    <script>
        export default {

            data() {
                return {
                    search: ''
                }
            },
            
        }
    </script>
    
    <style  scoped>
    
    </style>