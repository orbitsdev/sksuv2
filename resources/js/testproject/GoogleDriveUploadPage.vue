<template>
  <div class="p-20 bg-indigo-600">
    <input type="file" @change="selectFile" />
    <hr/>
    <TableButton @click="getFiles"> Get Files</TableButton>
  </div>
</template>

<script>
import axios from "axios";
import axiosApi from "../api/axiosApi";

export default {
  data() {
    return {
      file: null,
      description: "",
      productId: 0,
    };
  },
  methods: {
    selectFile() {
      this.file = event.target.files[0];
      console.log(this.file);

      const data = new FormData();
      data.append("files", this.file);
      axios.post("/api/google-drive-upload", data).then(res=>{
        console.log(res);
      }).catch(err=>{
        console.log(err);
      });
    },

    getFiles(){
        axios.post("/api/google-drive-get-files").then(res=>{
        console.log(res);
      }).catch(err=>{
        console.log(err);
      });
    }

  },
};
</script>

<style scoped></style>
