
<template>
  <div class="py-6">

    <div v-if="isFetching" class="flex items-center justify-center h-96">
      <Loader1 />
    </div>

    <div>
      <EmptyCard v-if="school_years.length <= 0 && !isFetching" />
      <div v-else class="grid grid-cols-3 gap-y-10 gap-x-8">
        <div
          class="block rounded hover:bg-gray-100 shadow bg-white hover:scale-95 transition ease-in-out cursor-pointer"
          v-for="batch in school_years"
          :key="batch"
          @click="goToPage(batch.id)"
        >
          <YearCard :title="`SY.${batch.from}- ${batch.to}`">
            <!-- {{ batch.schools }} -->
            <div class="border-l-2 pl-3 py-1 font-rubik border-green-600  mt-2">
              <p tabindex="0" class="t1 focus:outline-none text-sm font-medium leading-none text-green-700 font-rubki mb-2 ">
                  UNIVERSITY
                </p>
                <div class="mb-1" v-for="school in batch.schools" :key="school.id">
                    <p tabindex="0" class="t2 italic focus:outline-none text-xs  leading-none text-green-700 capitalize ">
                        - {{school.name}}
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
    goToPage(id) {
      this.$router.push({ name: "select-school-for-manage-officers", params: { id: id } });
    },
    async getAllSchoolYears() {
      this.isFetching = true;

      await axiosApi
        .get("api/manage-officer/school-year")
        .then((res) => {
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
