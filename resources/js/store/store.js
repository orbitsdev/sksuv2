


import { createStore } from 'vuex'
import auth from './auth/auth_index';

const store = createStore({
    modules: {
        auth
    }
    
    
});

export default store;
