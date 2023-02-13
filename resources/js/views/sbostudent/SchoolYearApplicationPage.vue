
<template>
    <div class="py-6">
      <InstructionCard  v-if="(!isFetching && school_years.length > 0  )" class="mb-4 shadow pulse" :title="'GUIDE '">
      
        <p index="40px" class="text-white font-rubok text-base font-semibold">
         - Each school year can have multiple applications. Select the application that you want to comply 
        </p>
      </InstructionCard> 
      <div v-if="isFetching" class="flex items-center justify-center h-96">
        <Loader1 />
      </div>
  
      <div>
        <EmptyCard v-if="school_years.length <= 0 && !isFetching" />
        

        <div  v-else >
          
          <div class="grid grid-cols-3 gap-y-10 gap-x-8">
          
            <div
              class="block rounded hover:bg-gray-100 shadow bg-white hover:scale-95 transition ease-in-out cursor-pointer"
              v-for="batch in school_years"
              :key="batch"
              @click="goToPage(batch)"
            >
              <YearCard :title="`SY.${batch.from}- ${batch.to}`">
                  <!-- {{ batch }} -->
                <!-- {{ batch.schools }} -->
                <div v-if="batch.application_forms.length >0" class="border-l-2 pl-3 py-1 font-rubik border-green-600  mt-2">
                  <p tabindex="0" class="t1 focus:outline-none text-sm font-medium leading-none text-green-700 font-rubki mb-2 ">
                      Applications 
                    </p>
                    <div class="mb-1" v-for="application in batch.application_forms" :key="application.id">
                        <p tabindex="0" class="t2 italic focus:outline-none text-xs  leading-none text-green-700 capitalize ">
                            - {{application.title}}
                          </p>
    
                    </div>
      
                
                   <!-- <div class="pt-4">
                     <YearButton> Take a Peek </YearButton>
                    </div> -->
                 
      
                </div>
              </YearCard>
            </div>
        </div>

       
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        school_years: [],
        isFetching: false,
      };
    },
  
    created() {
      this.getAllSchoolYears();
    },
  
    methods: {
      goToPage(batch) {
        this.$router.push({ name: "application-from-osas", props: { page: `SY.${batch.form}-${batch.to}`},  params: { id: batch.id } });
      },
      async getAllSchoolYears() {
        this.isFetching = true;
  
        await axiosApi
          .get("api/application-form/get-school-year-application")
          .then((res) => {
            // console.log(res.data);

            this.school_years = res.data.data;
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
  