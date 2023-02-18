import axios from "axios"




let axiosApi =  axios.create({});
const token = localStorage.getItem('token');


axiosApi.defaults.baseURL = "https://wrms-accreditation.projectorb.shop/";
axiosApi.defaults.headers.common['Content-Type'] = "application/json";
axiosApi.defaults.headers.common['Accept'] = "application/json";
axiosApi.defaults.headers.common['Authorization'] = "Bearer " + token;

export default  axiosApi;



