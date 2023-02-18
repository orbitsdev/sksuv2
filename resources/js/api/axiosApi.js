import axios from "axios"




let axiosApi =  axios.create({});
const token = localStorage.getItem('token');

axiosApi.defaults.baseURL = import.meta.env.VITE_PUSHER_APP_URL;
axiosApi.defaults.headers.common['Content-Type'] = "application/json";
axiosApi.defaults.headers.common['Accept'] = "application/json";
axiosApi.defaults.headers.common['Authorization'] = "Bearer " + token;

export default  axiosApi;



