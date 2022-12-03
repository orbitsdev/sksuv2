import axios from "axios"




let axiosApi =  axios.create({});
const token = localStorage.getItem('token');


axiosApi.defaults.baseURL = "http://127.0.0.1:8000/";
axiosApi.defaults.headers.common['Content-Type'] = "application/json";
axiosApi.defaults.headers.common['Accept'] = "application/json";
axiosApi.defaults.headers.common['Authorization'] = "Bearer " + token;

export default  axiosApi;



