import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Import your main Vue component
import router from './routes'; // Import the router configuration
import '../css/app.css'; // Import your Tailwind CSS file
import { createPinia } from 'pinia';
import Vue3Toasity from 'vue3-toastify';

const app = createApp(App); // Create a Vue application instance

app.use(router); // Use the router in the Vue application
app.use(createPinia()); // Use Pinia for state management
app.use(Vue3Toastify); // Use Vue3 Toastify for notifications
app.mount("#app"); // Mount the Vue app to the element with id "app"