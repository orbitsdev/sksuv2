<template>
    <hr>
    {{ passFiletype }}
    <hr>
    {{ maxSize }}
    <hr>
    {{ fileType }}
    <hr>
    {{ insertFile }}
    <hr>
    {{ multiple }}
    <hr>
    <!-- {{ fileType }} -->
  <file-pond
    credits="false"
    name="files"
    ref="pond"
    allowFileSizeValidation="true"
    allowPdfPreview="false"
    pdfComponentExtraParams="toolbar=0&view=fit&page=1"
    :maxFileSize="maxSize"
    :allow-multiple="multiple"
    :accepted-file-types="fileType"
    :itemInsertLocation="insertFile"
    @init="handleFilePondInit"
    @initFile="handleFilePondInitFile"
    @processfiles="handleFilePondProcessFiles"
    :files="files"
    :server="{
      url: '',
      process: {
        url: '/api/file/upload',
        methods: 'POST',
        withCredentials: true,
        headers: {
          Authorization: 'Bearer ' + authtoken,
        },
        onload: handleFilePondLoad,
        onerror: handleFilePondError,
        timeout: 7000,
      },
       revert: handleFilePondRevert,
    }"
   
  />
  <!-- :accepted-file-types="fileType" -->
</template>

<script>
import vueFilePond from "vue-filepond";

// Import plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";
import FilePondPluginFileImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginGetFile from "filepond-plugin-get-file";
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";
import FilePondPluginImageOverlay from "filepond-plugin-image-overlay";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css";
import "filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css";
import "filepond-plugin-image-overlay/dist/filepond-plugin-image-overlay.css";
import axiosApi from '../api/axiosApi';

// Create FilePond component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileImageValidateSize,
  FilePondPluginFileValidateSize,
  FilePondPluginFilePoster,
  FilePondPluginImageOverlay
//   FilePondPluginGetFile,
//   FilePondPluginPdfPreview
);

export default {
  created() {
    this.setFileType();
    this.authtoken = localStorage.getItem("token");
  },
  data() {
    return {
     authtoken: null,
      files: [],
      fileType:
        "image/*, application/msword, application/pdf,  text/plain , application/json, application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    };
  },

  components: {
    FilePond,
  },
  props: {
    passFiletype: {
      type: String,
      required: false,
      default: "all",
    },
    multiple: {
      type: Boolean,
      default: true,
    },
    maxSize: {
      type: String,
      required: false,
      default: "40MB",
    },
    insertFile: {
      type: String,
      required: false,
      default: "before",
    },
    PdfPreview: {
      type: Boolean,
      required: false,
      default: true,
    },
  },
  methods: {
    handleFilePondInit() {},
    handleFilePondLoad(response) {
        
        console.log(response);
        if(response != ''){
            
            const res = JSON.parse(response);
            const file = res.data;
            console.log(res.data);
            console.log(res.data);
            return file.folder;
            
        }
    },
    handleFilePondInitFile(file) {
      console.log("loading");
    },
    handleFilePondProcessFiles() {
      console.log("complete loadin");
    },
    handleFilePondError(response) {},
    handleFilePondRevert(folder, load, error) {
        axiosApi.delete('api/file/delete',{
            data:{
                'folder': folder
            }
        }).then(res=>{
            console.log(res);
        }).catch(err=>{
            console.log(err);
        })
      load();
    },

    setFileType() {
      if (this.passFiletype == "image") {
        this.fileType = "image/*";
      }
      if (this.passFiletype == "pdf") {
        this.fileType = "application/pdf, application/x-download, application/*";
      }

      if (this.passFiletype == "pdf|docx" || this.passFiletype == "pdf|docs") {
        this.fileType =
          "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document";
      }

      if (this.passFiletype == "json") {
        this.fileType = "application/json";
      }
      if (this.passFiletype == "text") {
        this.fileType = "text/plain";
      }
    },
  },
};
</script>

<style scoped></style>
