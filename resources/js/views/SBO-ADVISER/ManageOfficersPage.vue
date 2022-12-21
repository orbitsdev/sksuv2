


<template>
    <BaseCard :subtitle="'Manage SBO Officers'">
        <template #header>
            <BaseTableSetup>
            <template #searchs-area>
                <TableButton ><i class="fa-solid fa-plus mr-1"> </i> Add Officer
                  </TableButton>
            </template>
            <template #filters-area>
            </template>
            <template #actions-area>
            </template>
            </BaseTableSetup>
        </template>
        <BaseTable :thdata="['', 'Student Name',  'Position', '']" :isFetching="isFetching">
            <template #data>

                <tr >
                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                      <input
                        v-model="selectedDeparment"
                        :value="department"
                        type="checkbox"
                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
                      />
                    </td>
                    <td class="text-sm">
                      <div class="flex items-center">
                        <div class="">
                          <div class="font-medium text-gray-900"> BRIAN ORBINO</div>
                        </div>
                      </div>
                    </td>
                    <td class="py-2 text-sm text-gray-500">
                        Mayor
                    </td>
                    <td class="py-2 text-sm text-gray-500">

                    </td>
                  </tr>
                
            </template>
        </BaseTable>

    </BaseCard>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
            
                isFetching: false,
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>