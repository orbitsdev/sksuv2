

import mutations from './auth_mutations';
import actions from './auth_mutations';
import getters from './auth_mutations';

export default {

    state(){
        return {
            currentUser: {
                first_name: 'brian',
                first_name: 'orbs',
                email: 'orbs',
                token: null,
            },
        }

    },
    mutations,
    actions,
    getters


}