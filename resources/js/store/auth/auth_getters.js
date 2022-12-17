
    function array_has (arr, obj) {
        return (arr.indexOf (obj) != -1);
    }

    function array_has_roles(arr, obj){
        return arr.includes(obg);
    }



    function hey(){
    return   'hey';
    }
export default {

    Auth(state){
        return {
            ...state.Auth,
            is(role){
                return array_has(state.Auth.roles, role);
            },
            hasRoles(roles){
                return array_has_roles(state.Auth.roles, roles);
            }

        };
    },
    
    token(state){
        return state.token;
    },
    
    // Auth(state){
    //     return {
    //         ...state.currentUser,
    //         is(role){
    //             return array_has(state.currentUser.roles, role);
    //         }
    //     }
    // } 

}