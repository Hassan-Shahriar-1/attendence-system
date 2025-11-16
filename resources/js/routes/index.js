import { createWebHistory,createRouter } from "vue-router";
import { UserStore } from "../stores/UserStore";

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

router.beforeEach((to, from) => {
  const store = UserStore();

  // Redirect to login if the route requires auth and the user is not authenticated
  if (to.meta.requiresAuth && !store.token) {
    return { name: "login" };
  }

  // Redirect to dashboard if the user is authenticated, doesn't require auth for the route, and has a company
  if (!to.meta.requiresAuth && store.token) {
    return { name: "Dashboard" };
  }

  return true;
});



export default router;