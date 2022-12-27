


import axiosApi from '../../api/axiosApi';
export default {


  async getUser() {
      return  await axiosApi.get('api/user').then(res=>{
        return res.data;
      });
    },

   
  
    logoutUser(){
      localStorage.removeItem('token');
      window.location.reload(true);
  }

  


}