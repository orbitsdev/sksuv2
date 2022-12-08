<template>
  <input type="file" ref="attachment" @change="uploadFile" /> Upload Image
</template>

<script>
export default {
  created() {
    this.getToken();
  },
  data() {
    return {
      arrays: {
        config: [],
      },
    };
  },
  methods: {
    uploadFile() {
      var client = new OSS(this.arrays.config);

      var file = this.$refs.attachment.files[0];
      console.log("file data", file);
      client.multipartUpload("temp/file/" + file.name, file, {
        parallel: 4,
        progress: function (per, cpt, res) {
          console.log("percentage ", per);
          console.log("cpt ", cpt);
          console.log("res ", res);
        },
        partclientSize: 1 * 1024 * 1024,
      });
    },

    async getToken() {
      await axiosApi.get("api/oss/token").then(({ data }) => {
        console.log(data);
        this.arrays.config = data.data;
      });
    },
  },
};
</script>

<style lang="scss" scoped></style>
