
    function array_has (arr, obj) {
        return (arr.indexOf (obj) != -1);
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