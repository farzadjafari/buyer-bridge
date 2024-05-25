import axios from 'axios';

axios.defaults.withCredentials = true;
axios.get('/sanctum/csrf-cookie').then(() => {

});

axios.interceptors.request.use(config => {
    const token = localStorage.getItem('token');

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default axios;
