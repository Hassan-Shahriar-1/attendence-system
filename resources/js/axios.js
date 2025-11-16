import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
axios.defaults.withCredentials = true;
axios.defaults.headers = {
  'Access-Control-Allow-Origin': '*',
  Accept: 'application/json',
  'X-Value': true,
};
axios.defaults.baseURL = window.App.url;

// Request Interceptor
axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response Interceptor
axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {

    const currentRoute = window.location.pathname;
    if (error.response && [401].includes(error.response.status) && currentRoute !== '/login') {
      localStorage.removeItem('token');
      const toast = toast();
      toast.error('Your session has expired. Please log in again.', {
        position: 'bottom-center',
      });
   
      return (window.location = '/login');
    }

    if (error.response && [404].includes(error.response.status)) {
      return (window.location = '/404');
    }

    return Promise.reject(error);
  }
);
