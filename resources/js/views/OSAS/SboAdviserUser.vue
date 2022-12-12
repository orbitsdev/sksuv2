


<template>
    <BaseCard class="relative" :subtitle="'Manage Sbo Advisers'">
        <template #header>
          <BaseTableSetup>
            <template #searchs-area>
              <!-- <TableButton class="mr-2" @click="showTheForm">
                <i class="fa-solid fa-plus mr-1"></i> Add Sbo Adviser
              </TableButton> -->
              <BaseSearchInput :placeholder="'Search name ..'" v-model="search" />
            </template>
            <template #filters-area>
              <select           
              v-model="filterBy"
              @change="filterSbo"

              class="block hover:shadow-lg  border px-3 py-2 border text-gray-600  placeholder-gray-500 focus:border-gray-300 focus:placeholder-gray-400 focus:outline-none  sm:text-sm"> 
              <option v-for="option in schools" :key="option.id"  class="py-2" :value="option.name"> {{ option.name }} </option>
              
            </select>
            </template>
            <template #actions-area>
              <!-- <TableButton :mode="true" class="mr-2">
                <i class="fa-regular fa-trash-can mr-2"></i> Selected (1 )
              </TableButton> -->
              <!-- <TableButton :mode="true">
                <i class="fa-regular fa-trash-can mr-1"></i>
                <span class="block">Delete All</span>
              </TableButton> -->
            </template>
          </BaseTableSetup>
        </template>
    
        <BaseTable :thdata="['', 'Sbo Adviser Name', 'Schools', '']" :isFetching="isFetching">
          <template #data>
            <tr v-for="sboadviser in sboadvisers" :key="sboadviser.id">
              <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                <input
                  v-model="selecteSboAdviser"
                  type="checkbox"
                  class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
                />
              </td>
              <td class="whitespace-nowrap py-4">
                <div class="flex items-center">
                  <div class="h-10 w-10 flex-shrink-0">
                    <img
                      class="h-10 w-10 rounded-full"
                      src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                      alt=""
                    />
                  </div>
                  <div class="ml-4">
                    <div class="font-medium text-gray-900">
                        
                      {{ sboadviser.first_name + " " + sboadviser.last_name }}
                    </div>
                    <div class="text-gray-900">{{ sboadviser.email }}</div>
                  </div>
                </div>
              </td>
    
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">

                  <div v-if=" sboadviser.schools.length > 0">
                    <span v-for="sboschool  in  sboadviser.schools" :key="sboschool.id">
                      {{ sboschool.name}}
                  </span>
                  </div>
              </td>
              <td
                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
              >
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
      </BaseCard>
</template>

<script>
import axiosApi from '../../api/axiosApi';
    export default {
  created() {

    this.loadSboAdvisers();
    this.loadSchool();
  },

  data() {
    return {
      search: "",
      sboadvisers: [],
      schools: [],
      selecteSboAdviser: [],
      requestError: null,
      isFetching: false,
      requestError: null,
       
    };
  },

  watch: {


    search(oldeValue, newValue) {

      this.searchSbo();
      // if(newValue == ""){
      //   this.loadSboAdvisers();
      // }else{

      // }

    },
  
  },
  


  methods: {
    async searchSbo() {
      
      axiosApi
        .post("api/sbo-advisers/search", {
          search: this.search,
        })
        .then((res) => {

            this.sboadvisers =res.data.data;
                console.log(res.data.data);
       
        });
    },

        async filterSbo(){
            
          await axiosApi.post('api/sbo-advisers/filter', {
            filter: this.filterBy
          }).then(res=>{
            this.sboadvisers = res.data.data;
          }).catch(err=>{
            console.log(err);
          });
        
        },
    async loadSboAdvisers() {
      this.isFetching = true;
      await axiosApi
        .get("api/sbo-advisers")
        .then((res) => {

          
           this.sboadvisers = res.data.data;
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
    async loadSchool() {

      this.isFetching = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {

          this.schools = res.data.data;
          if(this.schools.length > 0){
            this.filterBy = this.schools[0].name;
          }
         
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style  scoped>

</style>php ar