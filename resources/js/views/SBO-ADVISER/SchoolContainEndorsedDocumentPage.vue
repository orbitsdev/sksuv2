<template>
  <BaseCard :subtitle="'Endorsed Documents'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton v-if="selectedEndorsed.length > 0"  @click="showForm = true" :mode="true" class="mr-2">
            <i class="fa-regular fa-trash-can mr-2"></i> Delete Selected
          </TableButton>
        </template>
        <template #filters-area> </template>
        <template #actions-area> </template>
      </BaseTableSetup>
    </template>
    <BaseTable
      :thdata="['', 'Application', 'Endorsed to', 'Status', 'School', 'School Year', '']"
      :isFetching="isFetching"
    >
      <template #data>
        <tr v-for="item in endorsed_applications" :key="item">
          <td class="relative w-12 px-6 sm:w-16 sm:px-8">
            <input
            
            v-model="selectedEndorsed"
            :value="item.id"
              type="checkbox"
              class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
            />
          </td>
          <td class="text-sm py-4">
            <div class="flex items-center">
              <div class="">
                <div class="font-medium text-gray-900">
                  {{ item.response.application_form.title }}
                </div>
              </div>
            </div>
          </td>

          <td class="text-sm py-4">
            <StatusCard class="capitalize">
              {{ item.campus_director.user.first_name }}
              {{ item.campus_director.user.last_name }}
            </StatusCard>
          </td>
          <td class="text-sm py-4">
            
            <div class="flex items-center capitalize">
              <StatusCard
                class="bg-green-100 text-green-700"
                v-if="item.status == 'approved'"
                >{{ item.status }}</StatusCard
              >
              <StatusCard
                class="bg-cyan-100 text-cyan-700"
                v-if="item.status == 're-evaluating'"
                >{{ item.status }}</StatusCard
              >
              <StatusCard
                class="bg-rose-100 text-rose-700"
                v-if="item.status == 'returned'"
                >{{ item.status }}</StatusCard
              >
            </div>
          </td>
          <td class="text-sm py-4">   
            <StatusCard class="capitalize">
              {{ item.campus_director.school.name }}
            </StatusCard>
          </td>

          
          <td class="text-sm py-4">
            <div class="flex items-center capitalize">
              <div class="">
                SY. {{ item.campus_director.school_year.from }} -
                {{ item.campus_director.school_year.to }}
              </div>
            </div>
          </td>
         

          <td class="py-2 text-sm text-gray-500">
            <!-- <button
              @click="handleShowForm(item)"
              type="button"
              class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
            >
              <i class="fa-regular fa-pen-to-square"></i>
            </button> -->
          </td>
        </tr>
      </template>
    </BaseTable>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'500'" :preventClose="true">
        <template #c-content>

            <ConfirmCard :title="`Are You Sure do you want to undo the selected endorsements to?`">

            </ConfirmCard>
           
          <div class="my-4"></div>
          <div class="my-2 flex justify-end">
            <WhiteButton  class="w-full mr-2" @click="showForm = false"> No </WhiteButton>
            <div class="my-1 mx-2 w-full flex justify-center items-center" v-if="isUpdating">
              <BaseSpinner />
            </div>
            <div v-else class="w-full ">
              <SquareButton class="w-full " @click="deleteSelectedEndorsement"> Yes </SquareButton>
            </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>

    <GlobalErrorCard @close="requestHasError = null" :show="requestHasError != null">
      {{ requestHasError }}
    </GlobalErrorCard>
  </BaseCard>
</template>

<script>
import axiosApi from "../../api/axiosApi";

export default {
  created() {
    this.getCampusAdviserEdorsement();
  },

  data() {
    return {
      showForm: false,
      isFetching: false,
      endorsed_applications: [],
      requestHasError: null,
    
      isUpdating: false,
      selectedItem: null,
      selectedEndorsed: [],
      
    };
  },

  methods: {
    async handleShowForm(item) {
      this.selectedItem = item;

      this.showForm = true;
    },

    async deleteSelectedEndorsement() {
      this.isUpdating = true;

      await axiosApi
        .post("api/delete-selected-endorsement", {
          indorsed_id: this.selectedEndorsed,
        })
        .then((res) => {
            this.showForm = false;
            this.selectedEndorsed = [];

          this.getCampusAdviserEdorsement();

        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  deleting endorsement Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        })
        .finally(() => {
          this.isUpdating = false;
        });
    },

    async getCampusAdviserEdorsement() {
      this.isFetching = true;

      await axiosApi
        .get("api/get-endorsed-documents")
        .then((res) => {
          console.log(res.data);

          this.endorsed_applications = res.data.data;
        }).catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
        }).finally(()=>{
            this.isFetching = false;
        });

    },
  },
};
</script>

<style scoped></style>
