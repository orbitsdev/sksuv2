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
        name: "dashboard",
        path: "/dashboard",
        component: () => import("../views/DashboardPage.vue"),
        meta: { requireAuth: true },
        children: [
            {
                name: "manage-school-year",
                path: "osas/manage-school-year",
                component: () => import("../views/OSAS/ManageSchoolYear.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
          
          
            {
                name: "manage-university",
                path: "osas/manage-university",
                component: () => import("../views/OSAS/ManageSchool.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
            {
                name: "manage-requirement",
                path: "osas/manage-requirement",
                component: () => import("../views/OSAS/ManageRequirement.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
            {
                name: "manage-sbo-adviser",
                path: "osas/manage-sbo-adviser",
                component: () => import("../views/OSAS/ManageSboAdviser.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },

                children: [
                    
                    {
                        name: "manage-sbo-adviser-adviser",
                        path: "advisers",
                        component: () => import("../views/OSAS/SboAdviser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-sbo-adviser-user",
                        path: "users",
                        component: () =>
                            import("../views/OSAS/SboAdviserUser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-sbo-adviser-request",
                        path: "requests",
                        component: () =>
                            import("../views/OSAS/SboAdviserRequest.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                ],
            },
            {
                name: "manage-application",
                path: "osas/manage-application",
                component: () => import("../views/OSAS/ManageApplication.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
            },
           
            {
                name: "manage-roles",
                path: "osas/manage-roles",
                component: () => import("../views/OSAS/ManageRole.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
            },

            
            {
                name: "manage-organization",
                path: "osas/manage-organization",
                component: () => import("../views/OSAS/ManageDepartment.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },
           

            // SEND  SBO ADVISER ROLE REQUES
            {
                name: "sbo-adviser-makerequest",
                path: "sbo-adviser/make-request",
                component: () =>
                    import("../views/SBO-ADVISER/MakeRequestPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["guest"] },
                children: [],
            },

            // SBO ADVISER PAGE

         

            {
                name: "select-school-year-for-manage-officers",
                path: "sbo-adviser/school-years",
                component: () => import("../views/SBO-ADVISER/SchoolYearPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
            {
                props:true,
                name: "select-school-for-manage-officers",
                path: "sbo-adviser/school-years/school/:id",
                component: () => import("../views/SBO-ADVISER/SchoolPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
            {

                props: true ,
                name: "manage-sbo-officers",
                path: "sbo-adviser/school-years/school/manage-officer/:id",
                component: () => import("../views/SBO-ADVISER/ManageOfficersPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },

            {
                name: "officers-documents",
                path: "sbo-adviser/officers/documents",
                component: () => import("../views/SBO-ADVISER/DocumentPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
           

            {
                name: "application-from-osas",
                path: "sbo-student/applications",
                component: () =>
                    import("../views/SBO-STUDENT/ApplicationFormPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],
            },

            {
                name: "take-application",
                path: "sbo-student/applications/:applicationId/:title",
                component: () =>
                    import("../views/SBO-STUDENT/FillupFormPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],
               
                props: true,
            },
            {
                name: "monitor-applications",
                path: "sbo-student/monitor/applications",
                component: () => import("../views/SBO-STUDENT/MonitorPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
               

            },

            {
                
                    name: "monitor-app",
                    path: "sbo-student/monitor/applications/:id",
                    component: () => import("../views/SBO-STUDENT/ApplicationPage.vue"),
                    props: true,
                
            }


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
