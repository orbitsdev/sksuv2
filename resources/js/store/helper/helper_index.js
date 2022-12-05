

export default {

    state(){
        return {
          fileType:{
            image : 'image/*',
            documents: 'application/*',
            pdf: 'application/pdf',
            json: 'application/json',
            docs: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

          }  

        }

    },

    getters: {
        fileType(state){
            return state.fileType;
        }
    }
   

}
