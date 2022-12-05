


import { createStore } from 'vuex'
import auth from './auth/auth_index';
import global from './helper/helper_index';

const store = createStore({
    modules: {
        auth,
        global,
    }
    
    
});

export default store;
