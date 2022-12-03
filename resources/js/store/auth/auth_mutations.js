

export default {
    
    setUserDetails(state, payload){
        
        state.currentUser = payload;
        console.log(payload);
    }
}