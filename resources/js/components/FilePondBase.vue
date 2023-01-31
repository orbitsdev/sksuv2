<template>
  <!-- <hr />
  {{ fileType }}
  <hr />

  {{ multiple }} -->
  <file-pond
    credits="false"
    name="files"
    ref="pond"
    allowFileSizeValidation="true"
    allowPdfPreview="false"

    pdfComponentExtraParams="toolbar=0&view=fit&page=1"
    :disabled="isDisabled"
    :label-idle="label"
    :max-file="maxFile"
    :maxFileSize="maxSize"
    :allow-multiple="multiple"
    :accepted-file-types="fileType"
    :itemInsertLocation="insertFile"
    @init="handleFilePondInit"
    @initfile="handleFilePondInitFile"
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
import { ref } from "vue";
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
import axiosApi from "../api/axiosApi";

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
  setup(props, context) {
    const authtoken = localStorage.getItem("token");
    const loading = ref(false);
    const form = ref({
      name: "",
    });
    const files = ref([]);

    // FILEPOND METHODS
    function handleFilePondInit() {}
    function handleFilePondLoad(response) {
      if (response != "") {
        const res = JSON.parse(response);
        const file = res.data;
        context.emit("fileIsUploaded", file);
        return file.folder;
      }
    }
    function handleFilePondInitFile(file) {
      context.emit("fileIsUploading", true);
    }
    function handleFilePondProcessFiles() {
      context.emit("fileIsUploading", false);
    }
    function handleFilePondError(response) {
      context.emit("fileIsUploading", false);
    }

    function handleFilePondRevert(folder, load, error) {
      axiosApi
        .delete("api/file/delete", {
          data: {
            folder: folder,
          },
        })
        .then((res) => {
          context.emit("fileIsDeleted", res.data.data);
        })
        .catch((err) => {
          console.log(err);
        });
      load();
    }

    return {
      authtoken,
      files,
      handleFilePondInit,
      handleFilePondLoad,
      handleFilePondInitFile,
      handleFilePondProcessFiles,
      handleFilePondError,
      handleFilePondRevert,
    };
  },
  emits: ["fileIsUploaded", "fileIsDeleted", "fileIsUploading", "hasError"],
  components: {
    FilePond,
  },
  props: {
    maxFile: {
      type: String,
    },
    fileType: {
      type: String,
      default:
        "image/*, application/msword, application/pdf,  text/plain , application/json, application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      required: true,
    },
    multiple: {
      type: Boolean,
      default: true,
    },
    isDisabled: {
      type: Boolean,
      default:false,
    },
    label: {
      type: String,
      required: false,
      default: "Drag & Drop your files or Browse",
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
};
</script>

<style scoped></style>
