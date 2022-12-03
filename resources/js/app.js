

import { createApp } from "vue";
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

// LOTTIE
import Vue3Lottie from 'vue3-lottie'
import 'vue3-lottie/dist/style.css'

// WAVE UI
import WaveUI from 'wave-ui';
import 'wave-ui/dist/wave-ui.css';
new WaveUI(app, {});
  
// REGISTER
app.use(router);
app.use(store);
app.use(Vue3Lottie);
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


router.isReady().then(()=>{
    app.mount("#app");
});
    