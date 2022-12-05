

export default {
    
    setUserDetails(state, payload){
        
        state.Auth = payload;
        console.log(payload);
    }
}