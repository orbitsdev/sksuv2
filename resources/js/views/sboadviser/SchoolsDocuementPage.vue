
<template>
    <div class="py-6">
  
      <div v-if="isFetching" class="flex items-center justify-center h-96">
        <Loader1 />
      </div>
  
      <div>
        <EmptyCard v-if="schools.length <= 0 && !isFetching" />
        <div v-else class="grid grid-cols-2 gap-y-10 gap-x-8">
          <div
            class="block rounded hover:bg-gray-100 shadow bg-white hover:scale-95 transition ease-in-out cursor-pointer"
            v-for="school in schools"
            :key="school"
            @click="goToPage(school.id)"
          >
            <YearCard :title="`${school.name}`" :image="'/assets/undraw_my_files_swob.svg'">

              <div class="border-l-2 pl-3 py-1 font-rubik border-green-600  mt-2">
                <p tabindex="0" class="t1 focus:outline-none text-sm font-medium leading-none text-green-700 font-rubki mb-2 ">
                                  
                    Officers Document  {{ school.responses.length }}
                </p>


              </div>
  

            </YearCard>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        schools: [],
        isFetching: false,
      };
    },
  
    created() {
      this.getAllSchoolYears();
    },
  
    methods: {
      goToPage(id) {
        this.$router.push({ name: "officers-documents", params: { id: id } });
      },
      async getAllSchoolYears() {
        this.isFetching = true;
  
        await axiosApi
          .get("api/officers/schools")
          .then((res) => {
            console.log(res.data);

            this.schools = res.data.data;
          })
          .catch((err) => {
            this.requestError =
              '"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer';
          })
          .finally(() => {
            this.isFetching = false;
          });
      },
    },
  };
  </script>
  
  <style  scoped></style>
  