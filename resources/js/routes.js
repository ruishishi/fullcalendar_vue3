import CalendarComponent from "./components/Calendar.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/calendar",
        component: CalendarComponent,
        name: "calendar",
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
});

export default router;
