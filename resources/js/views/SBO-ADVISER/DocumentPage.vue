
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
              <TableButton
                :mode="true"
                class="mr-2"
              >
                <i class="fa-regular fa-trash-can mr-2"></i>  CLICK ME
              </TableButton>
            </template>
          </BaseTableSetup>

          <BaseTable
          :thdata="['','Applications', 'Officers', 'Status', 'Submitted Date ']"
          :isFetching="isSaving"
        >

        <template  #data>
            <tr >
                <td class="whitespace-normal relative w-12 px-6 sm:w-16 sm:px-8">
                
                </td>
                <td class="whitespace-normal text-sm">
                  <div class="flex items-center">
                    <div class="">
                      <div class="font-medium text-gray-900">
                        Enrollmen Acrredtion for Sbo Student Organuzaution
                      </div>
                    </div>
                  </div>
                </td>
    
                <td class="whitespace-normal">
                  <div class="font-medium text-gray-900">
                    Mariak Kate Romo 
                  </div>
                  <div class="mt-1 font-medium text-gray-900">
                    Governor 
                  </div>
                </td>
                <td class="whitespace-normal">
                  <div class="font-medium text-gray-900">ExampleData</div>
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