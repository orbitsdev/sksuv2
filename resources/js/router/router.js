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
        meta: { requireAuth: false },
    },
    {
        name: "login",
        path: "/login",
        component: () => import("../views/LoginPage.vue"),
        meta: { requireAuth: false },
    },
    {
        name: "register",
        path: "/register",
        component: () => import("../views/RegisterPage.vue"),
        meta: { requireAuth: false },
    },

    {
        name: "token-catcher",
        path: "/authorize/google/callback",
        component: () => import("../views/SocialAccountTokenCatcher.vue"),
        meta: { requireAuth: false },
    },
    {
        name: "forgotpassword",
        path: "/forgot-password",
        component: () => import("../views/ForgotPassword.vue"),
        meta: { requireAuth: false },
    },
    {
        name: "setnewpassword",
        path: "/set-new-password",
        component: () => import("../views/SetNewPasswordPage.vue"),
        meta: { requireAuth: false },
    },
    {
        name: "password-request-sent",
        path: "/password-request-sent",
        component: () => import("../views/PasswordRequestSent.vue"),
        meta: { requireAuth: false },
    },

    {
        name: "getting-started",
        path: "/getting-started",
        component: () => import("../views/GettingStarted.vue"),
        meta: { requireAuth: true },
    },
    {
        name: "notauhtorize",
        path: "/401",
        component: () => import("../views/NoAuthorizePage.vue"),
    },
    {
        name: "applicationform",
        path: "/applicationform",
        component: () => import("../views/FormPage.vue"),
    },


    {
        name: "view-application",
        path: "/dashboard/osas/manage-application/view/:id",
        component: () => import("../views/FormPage.vue"),
        props:true,
        meta: { requireAuth: true, allowedRoles: ["osas"] },
    },

    {
        name: "dashboard",
        path: "/dashboard",
        component: () => import("../views/DashboardPage.vue"),
        meta: { requireAuth: true },
        children: [
            {
                name: "manage-school",
                path: "/dashboard/osas/manage-school",
                component: () => import("../views/OSAS/ManageSchool.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
            {
                name: "manage-school-department",
                path: "/dashboard/osas/manage-school-department",
                component: () => import("../views/OSAS/ManageDepartment.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
            {
                name: "manage-requirement",
                path: "/dashboard/osas/manage-requirement",
                component: () => import("../views/OSAS/ManageRequirement.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
            {
                name: "manage-sbo-adviser",
                path: "/dashboard/osas/manage-sbo-adviser",
                // redirect: '/dashboard/osas/manage-school/user',
                component: () => import("../views/OSAS/ManageSboAdviser.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },

                children: [
                    {
                        name: "manage-sbo-adviser-adviser",
                        path: "/dashboard/osas/manage-sbo-adviser/advisers",
                        component: () => import("../views/OSAS/SboAdviser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-sbo-adviser-user",
                        path: "/dashboard/osas/manage-sbo-adviser/users",
                        component: () =>
                            import("../views/OSAS/SboAdviserUser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-sbo-adviser-request",
                        path: "/dashboard/osas/manage-sbo-adviser/requests",
                        component: () =>
                            import("../views/OSAS/SboAdviserRequest.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                ],
            },
            {
                name: "manage-application",
                path: "/dashboard/osas/manage-application",
                component: () => import("../views/OSAS/ManageApplication.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
            },
           
            {
                name: "manage-roles",
                path: "/dashboard/osas/manage-roles",
                component: () => import("../views/OSAS/ManageRole.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
            },
           

            // SEND  SBO ADVISER ROLE REQUES
            {
                name: "sbo-adviser-makerequest",
                path: "/dashboard/sbo-adviser/make-request",
                component: () =>
                    import("../views/SBO-ADVISER/MakeRequestPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["guest"] },
                children: [],
            },

            {
                name: "manage-sbo-officers",
                path: "/dashboard/sbo-adviser/manage-sbo-offers",
                component: () =>
                    import("../views/SBO-ADVISER/ManageOfficersPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
        ],
    },

    {
        name: "load",
        path: "/load",
        component: () => import("../components/LoadingScreen.vue"),
        meta: { requireAuth: false },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
function authenticated() {
    return !!localStorage.getItem("token");
}

function proceed(requireAuth, allowedRoles, next) {
    // prevent user to access login page and signup page;
    if (requireAuth == false && authenticated()) {
        next("/dashboard");
    }
    // prevent user to access login page and signup page;
    if (allowedRoles) {
        if (
            allowedRoles.some((role) =>
                store.state.auth.User.user_roles.includes(role)
            )
        ) {
            next();
        } else {
            next("/401");
        }
    } else {
        next();
    }
}

router.beforeEach(async (to, from, next) => {
    // restrict accessing pages if user is not authenticated
    if (to.meta.requireAuth && !authenticated()) {
        next("/?login=attemp");
    } else {
        // is user authenticated
        if (authenticated()) {
            // check authenticated user data ;
            if (store.state.auth.User == null) {
                // get user details
                await store
                    .dispatch("getUser")
                    .then((res) => {
                        // set user details
                        store.commit("setUser", res);
                    })
                    .catch((err) => {
                        // if error occur force logout
                        localStorage.removeItem("token");
                        next({ path: "/?login=failed" });
                    });

                proceed(to.meta.requireAuth, to.meta.allowedRoles, next);
            } else {
                proceed(to.meta.requireAuth, to.meta.allowedRoles, next);
            }
        } else {
            next();
        }
    }
});

export default router;
