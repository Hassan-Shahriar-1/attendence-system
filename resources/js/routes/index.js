import { createWebHistory,createRouter } from "vue-router";
import { UserStore } from "../stores/UserStore";

const Dashboard = () => import("../Pages/Dashboard.vue");
const NotFound = () => import("../Pages/NotFound.vue"); // 404 page
const AuthenticatedLayout = () => import("../Layouts/AuthenticatedLayout.vue");
const Studentlist = () => import("../Pages/Students/Studentlist.vue");
const Attendance = () => import("../Pages/Attendance/AttendanceList.vue");

const routes = [
    {
        path: "/",
        component: AuthenticatedLayout,
        meta: { requiresAuth: true },   
        children: [
             {
                path: "",
                redirect: { name: "Dashboard" }, // Redirect root path to "dashboard"
            },
            {
                path: "dashboard",
                component:  Dashboard,
                name: "Dashboard",
                meta: {
                requiresAuth: true,
                },
            },
            {
                path: "students",
                component:  Studentlist,
                name: "Students",
                meta: {
                requiresAuth: true,
                },
            },
            {
                path: "attendance",
                component:  Attendance,
                name: "Attendance",
                meta: {
                requiresAuth: true,
                },
            },
        ],
    },
    {
        path: "/login",
        name: "login",
        component: () => import("../Pages/Login.vue"), // add a login route (create file if missing)
        meta: { requiresAuth: false },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFound,
    },
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