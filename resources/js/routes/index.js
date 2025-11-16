import { createWebHistory,createRouter } from "vue-router";

// Pages
const Dashboard = () => import("../Pages/Dashboard.vue");
const NotFound = () => import("../Pages/NotFound.vue"); // 404 page

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: () => Dashboard(),
    },
     {
        path: '/:pathMatch(.*)*', // matches any route not defined above
        name: 'NotFound',
        component: () => NotFound(),
    }
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;