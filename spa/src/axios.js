import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8080/api/'

axios.interceptors.request.use(function (config) {
    config.headers.Authorization = 'bearer '+ localStorage.getItem('token');
    return config;
});


export default axios