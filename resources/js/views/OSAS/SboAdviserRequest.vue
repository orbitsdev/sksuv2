<template>
  <div>
    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi dolores adipisci et
    qui amet cumque deserunt, quidem hic iste nulla reiciendis? Ipsa similique modi
    perferendis, repellendus est voluptas iure ratione.
    {{ users }}
  </div>
</template>

<script>
import axiosApi from "../../api/axiosApi";
export default {
  created() {
    this.loadUser();
  },
  data() {
    return {
      users: [],
      isFetchin: false,
    };
  },
  methods: {
    async loadUser() {
      this.isFetching = true;
      await axiosApi
        .get("api/sbo-requests")
        .then((res) => {
          console.log(res);
          this.users = res.data;
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

<style lang="scss" scoped></style>
