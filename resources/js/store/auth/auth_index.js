

import mutations from './auth_mutations';
import actions from './auth_actions';
import getters from './auth_getters';

function array_has (arr, obj) {
    return (arr.indexOf (obj) != -1);
}

export default {

    state(){
        return {
            
            Auth: {
                first_name: 'brian',
                first_name: 'orbs',
                email: 'orbs',
                token: null,
                roles: [],
                
            },
        }

    },
    mutations,
    actions,
    getters


}