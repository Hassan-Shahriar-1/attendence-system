import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Import your main Vue component
import router from './routes'; // Import the router configuration
import '../css/app.css'; // Import your Tailwind CSS file

const app = createApp(App); // Create a Vue application instance

app.use(router); // Use the router in the Vue application

app.mount("#app"); // Mount the Vue app to the element with id "app"