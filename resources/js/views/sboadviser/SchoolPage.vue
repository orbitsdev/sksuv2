

<template>
  <div>

    <InstructionCard class="mb-4 shadow pulse" :title="'Guide'">
      
      <p index="40px" class="text-white font-rubok text-base font-semibold">
        - Each University can have officers.  Select your desire Univerisity / Camous
      </p>
    </InstructionCard> 
    
    <BackCard class="mb-4"  @click="this.$router.back()"/>


    <div v-if="isFetching" class="flex items-center justify-center h-96">
      <Loader1 />
    </div>
    <div>
      <EmptyCard v-if="schools.length <= 0 && !isFetching" />
      <div v-else class="grid grid-cols-3 gap-y-10 gap-x-8">
        <div  v-for="school in schools" :key="school.id" style="background-image: url('/assets/undraw_hiring_re_yk5n.svg');" class="bg-cover bg-center  flex items-center justify-center min-h-40 rounded hover:bg-gray-100 shadow bg-white hover:scale-95 transition ease-in-out cursor-pointer" @click="goToPage(school.id)">
            <div class="w-full h-full px-5 py-7 bg-white">
                <p class="text-1xl font-rubik text-center uppercase leading-4 font-semibold  text-green-600">
                    {{ school.name }} 
                </p>
            </div>

            
        </div>
      </div>
    </div>
    <GlobalErrorCard @close="hasRequestError = null" :show="hasRequestError != null">
      {{ hasRequestError }}
    </GlobalErrorCard>
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  data() {
    return {
      schools: [],
      isFetching: false,
      hasRequestError: null,
    };
  },
  created () {
    this.getSchoolYearSchools();
  },
  methods: {
    
    goToPage(id) {


      this.$router.push({ name: "manage-sbo-officers", params:{ id:id} });
    },
    async getSchoolYearSchools() {
      this.isFetching = true;

        let school_year_id = parseInt(this.$route.params.id);
      await axiosApi
        .post("api/manage-officer/school-year-school", {
          school_year_id:school_year_id ,
        })
        .then((res) => {

 
            this.schools = res.data.data;
        })
        .catch((err) => {
          this.hasRequestError =
            '"Oops! It seems like there was an error when fetching school campuse adviser Please check your network connection. o and try again. if you think it it was the system please do contact the developer"';
        })
        .finally(() => {
          this.isFetching = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>


.gr{

    background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);
}
</style>
