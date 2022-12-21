import { createRouter } from "vue-router";
import { createWebHistory } from "vue-router";
import store from "../store/store.js";
const routes = [
    {
        name: "googledriveupload",
        path: "/google",
        component: () => import("../testproject/GoogleDriveUploadPage.vue"),
    },
    {
        name: "getstarted",
        path: "/",
        component: () => import("../views/GetStartedPage.vue"),
        meta: { middleware: "guest" },
    },
    {
        name: "login",
        path: "/login",
        component: () => import("../views/LoginPage.vue"),
        meta: { middleware: "guest" },
    },
    {
        name: "register",
        path: "/register",
        component: () => import("../views/RegisterPage.vue"),
        meta: { middleware: "guest" },
    },

    {
        name: "token-catcher",
        path: "/authorize/google/callback",
        component: () => import("../views/SocialAccountTokenCatcher.vue"),
        meta: { middleware: "guest" },
    },
    {
        name: "forgotpassword",
        path: "/forgot-password",
        component: () => import("../views/ForgotPassword.vue"),
        meta: { middleware: "guest" },
    },
    {
        name: "setnewpassword",
        path: "/set-new-password",
        component: () => import("../views/SetNewPasswordPage.vue"),
        meta: { middleware: "guest" },
    },
    {
        name: "password-request-sent",
        path: "/password-request-sent",
        component: () => import("../views/PasswordRequestSent.vue"),
        meta: { middleware: "guest" },
    },

    {
        name: "getting-started",
        path: "/getting-started",
        component: () => import("../views/GettingStarted.vue"),
        meta: { middleware: "auth" },
    },

    {
        name: "dashboard",
        path: "/dashboard",
        component: () => import("../views/DashboardPage.vue"),
        meta: { middleware: "auth", isNotGuest: true },
        children: [
            {
                name: "manage-school",
                path: "/dashboard/osas/manage-school",
                component: () => import("../views/OSAS/ManageSchool.vue"),
                meta: { middleware: "auth" },
                children: [],
            },
            {
                name: "manage-school-department",
                path: "/dashboard/osas/manage-school-department",
                component: () => import("../views/OSAS/ManageDepartment.vue"),
                meta: { middleware: "auth" },
                children: [],
            },
            {
                name: "manage-sbo-adviser",
                path: "/dashboard/osas/manage-sbo-adviser",
                // redirect: '/dashboard/osas/manage-school/user',
                component: () => import("../views/OSAS/ManageSboAdviser.vue"),
                meta: { middleware: "auth" },

                children: [
                    {
                        name: "manage-sbo-adviser-adviser",
                        path: "/dashboard/osas/manage-sbo-adviser/advisers",
                        component: () => import("../views/OSAS/SboAdviser.vue"),
                    },
                    {
                        name: "manage-sbo-adviser-user",
                        path: "/dashboard/osas/manage-sbo-adviser/users",
                        component: () =>
                            import("../views/OSAS/SboAdviserUser.vue"),
                    },
                    {
                        name: "manage-sbo-adviser-request",
                        path: "/dashboard/osas/manage-sbo-adviser/requests",

                        component: () =>
                            import("../views/OSAS/SboAdviserRequest.vue"),
                    },
                ],
            },
            {
                name: "manage-application",
                path: "/dashboard/osas/manage-application",
                component: () => import("../views/OSAS/ManageApplication.vue"),
                meta: { middleware: "auth" },
            },
            {
                name: "manage-roles",
                path: "/dashboard/osas/manage-roles",
                component: () => import("../views/OSAS/ManageRole.vue"),
                meta: { middleware: "auth" },
            },

            // SEND  SBO ADVISER ROLE REQUES
            {
                name: "sbo-adviser-makerequest",
                path: "/dashboard/sbo-adviser/make-request",
                component: () =>
                    import("../views/SBO-ADVISER/MakeRequestPage.vue"),
                meta: { middleware: "auth" },
                children: [],
            },

            {
                name: "manage-sbo-officers",
                path: "/dashboard/sbo-adviser/manage-sbo-offers",
                component: () => import("../views/SBO-ADVISER/ManageOfficersPage.vue"),
                meta: { middleware: "auth" },
                children: [],
            },
        ],
    },

    {
        name: "load",
        path: "/load",
        component: () => import("../components/LoadingScreen.vue"),
        meta: { middleware: "guest" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

function authenticated() {
    return localStorage.getItem("token");
}
function authenticatedIsGuest() {
    return true;
}
router.beforeEach((to, from, next) => {
    if (to.meta.middleware == "guest" && authenticated()) {
        next("/dashboard");
    } else if (to.meta.middleware == "auth" && !authenticated()) {
        next("/?login=attemp");
    } else {
        next();
    }
});
export default router;
