

import { createApp } from "vue";
import './bootstrap';
let app = createApp({});


import router from './router/router';
import store from './store/store';

// COMPONENT
import App from "./App.vue";
import LoadingScreen from './components/LoadingScreen.vue';
import BaseSpinner from './components/BaseSpinner.vue';
import BaseDialog from './components/BaseDialog.vue';
import SquareButton from './components/SquareButton.vue';
import FlyoutMenu from './components/FlyoutMenu.vue';
import BaseInput from './components/BaseInput.vue';
import BaseInputPassword from './components/BaseInputPassword.vue';
import WideButton from './components/WideButton.vue';
import RequestError from './components/RequestError.vue';
import BaseErrorDialog from './components/BaseErrorDialog.vue';
import BaseCard from './components/BaseCard.vue';
import TableButton from './components/TableButton.vue';
import FilePondBase from './components/FilePondBase.vue';
import FormHeader from './components/FormHeader.vue';
import LinearLoader from './components/LinearLoader.vue';
import TableLoader from './components/TableLoader.vue';
import FileChip from './components/FileChip.vue';
import BaseTableSetup from './components/BaseTableSetup.vue';
import BaseSearchInput from './components/BaseSearchInput.vue';
import BaseFilter from './components/BaseFilter.vue';
import BaseTable from './components/BaseTable.vue';
import SchoolCard from './components/SchoolCard.vue';
import Path from './components/Path.vue';
import BaseConfirmation from './components/BaseConfirmation.vue';
import FieldTypeComponent from './components/FieldTypeComponent.vue';
import Pagination from './components/Pagination.vue';
import FormComponent from './components/FormComponent.vue';
import CardSkeleton from './components/CardSkeleton.vue';
import EmptyCard from './components/EmptyCard.vue';
import Loader1 from './components/Loader1.vue';
import TimelineCard from './components/TimelineCard.vue';
import Loader2 from './components/Loader2.vue';
import ConfirmCard from './components/ConfirmCard.vue';
import IndorseCard from './components/IndorseCard.vue';
import StatusCard from './components/StatusCard.vue';
import DateCard from './components/DateCard.vue';





import axiosApi from "./api/axiosApi";
import axios from 'axios';
window.axios = axios;
window.axiosApi = axiosApi;
// LOTTIE
import Vue3Lottie from 'vue3-lottie'
import 'vue3-lottie/dist/style.css'

// SWEET ALERT
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

// WAVE UI
import WaveUI from 'wave-ui';
import 'wave-ui/dist/wave-ui.css';
new WaveUI(app, {});




app.use(router);
app.use(store);
app.use(Vue3Lottie);
app.use(VueSweetalert2);
// app.use(vuetify);
app.component("App", App);

// GLOBAL COMPONENT
app.component("LoadingScreen", LoadingScreen);
app.component("BaseSpinner", BaseSpinner);
app.component("BaseDialog", BaseDialog);
app.component("SquareButton", SquareButton);
app.component("FlyoutMenu", FlyoutMenu);
app.component("BaseInput", BaseInput);
app.component("BaseInputPassword", BaseInputPassword);
app.component("WideButton", WideButton);
app.component("RequestError", RequestError);
app.component("BaseErrorDialog", BaseErrorDialog);
app.component("BaseCard", BaseCard);
app.component("TableButton", TableButton);
app.component("FilePondBase", FilePondBase);
app.component("FormHeader", FormHeader);
app.component("LinearLoader", LinearLoader);
app.component("TableLoader", TableLoader);
app.component("FileChip", FileChip);
app.component('Pagination', Pagination);
app.component('BaseTableSetup', BaseTableSetup);
app.component('BaseSearchInput', BaseSearchInput);
app.component('BaseFilter', BaseFilter);
app.component('BaseTable', BaseTable);
app.component('SchoolCard', SchoolCard);
app.component('Path', Path);
app.component('BaseConfirmation', BaseConfirmation);
app.component('FieldTypeComponent', FieldTypeComponent);
app.component('FormComponent', FormComponent);
app.component('CardSkeleton', CardSkeleton);
app.component('EmptyCard', EmptyCard);
app.component('Loader1', Loader1);
app.component('TimelineCard', TimelineCard);
app.component('Loader2', Loader2);
app.component('ConfirmCard', ConfirmCard);
app.component('IndorseCard', IndorseCard);
app.component('StatusCard', StatusCard);
app.component('DateCard', DateCard);





router.isReady().then(()=>{
    app.mount("#app");
});
