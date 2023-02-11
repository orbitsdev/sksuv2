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
                component: () => import("../views/osas/ManageSchoolYear.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [],
            },

            {
                name: "manage-university-tabs",
                path: "osas/manage-university/pages",
                component: () => import("../views/osas/UniversityPageTab.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [
                    {
                        name: "manage-univeristy",
                        path: "university",
                        component: () =>
                            import("../views/osas/ManageSchool.vue"),
                        meta: { requireAuth: true, allowedRoles: ["osas"] },
                        children: [],
                    },
                    {
                        name: "manage-organizations",
                        path: "university",
                        component: () =>
                            import("../views/osas/ManageDepartment.vue"),
                        meta: {
                            requireAuth: true,
                            allowedRoles: ["sbo-adviser", "osas"],
                        },
                        children: [],
                    },
                ],

                redirect: { name: "manage-univeristy" },
            },
            {
                name: "manage-account-tabs",
                path: "osas/manage-account/pages",
                component: () => import("../views/osas/ManageAccountTab.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [
                    {
                        name: "manage-account-password",
                        path: "manageaccount",
                        component: () =>
                            import("../views/osas/ManageAccountPassword.vue"),
                        meta: { requireAuth: true, allowedRoles: ["osas"] },
                        children: [],
                    },
                    {
                        name: "manage-sbo-adviser-user",
                        path: "users",
                        component: () =>
                            import("../views/osas/SboAdviserUser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-campus-director",
                        path: "manage/campus-director",
                        component: () =>
                            import("../views/osas/ManageCampusDirector.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                    {
                        name: "manage-campus-deans",
                        path: "manage/campus-deans",
                        component: () =>
                            import("../views/osas/ManageCampusDean.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                ],

                redirect: { name: "manage-account-password" },
            },

            {
                name: "manage-application-tabs",
                path: "osas/manage-application/page",
                component: () =>
                    import("../views/osas/ManageApplicationTab.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },
                children: [
                    {
                        name: "manage-requirement",
                        path: "osas/manage-requirement",
                        component: () =>
                            import("../views/osas/ManageRequirement.vue"),
                        meta: { requireAuth: true, allowedRoles: ["osas"] },
                        children: [],
                    },
                    {
                        name: "manage-application",
                        path: "osas/manage-application",
                        component: () =>
                            import("../views/osas/ManageApplication.vue"),
                        meta: { requireAuth: true, allowedRoles: ["osas"] },
                    },
                ],
                redirect: { name: "manage-requirement" },
            },

            {
                name: "manage-sbo-adviser",
                path: "osas/manage-sbo-adviser",
                component: () => import("../views/osas/ManageSboAdviser.vue"),
                meta: { requireAuth: true, allowedRoles: ["osas"] },

                children: [
                    {
                        name: "manage-sbo-adviser-adviser",
                        path: "advisers",
                        component: () => import("../views/osas/SboAdviser.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },

                    {
                        name: "manage-sbo-adviser-request",
                        path: "requests",
                        component: () =>
                            import("../views/osas/SboAdviserRequest.vue"),
                        meta: { allowedRoles: ["osas"] },
                    },
                ],
            },

            {
                name: "manage-organization",
                path: "osas/manage-organization",
                component: () => import("../views/osas/ManageDepartment.vue"),
                meta: {
                    requireAuth: true,
                    allowedRoles: ["sbo-adviser", "osas"],
                },
                children: [],
            },

            // SEND  SBO ADVISER ROLE REQUES
            {
                name: "sbo-adviser-makerequest",
                path: "sbo-adviser/make-request",
                component: () =>
                    import("../views/sboadviser/MakeRequestPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["guest"] },
                children: [],
            },

            // SBO ADVISER PAGE

            {
                name: "select-school-year-for-manage-officers",
                path: "sbo-adviser/school-years",
                component: () =>
                    import("../views/sboadviser/SchoolYearPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
            {
                props: true,
                name: "select-school-for-manage-officers",
                path: "sbo-adviser/school-years/school/:id",
                component: () => import("../views/sboadviser/SchoolPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
            {
                props: true,
                name: "manage-sbo-officers",
                path: "sbo-adviser/school-years/school/manage-officer/:id",
                component: () =>
                    import("../views/sboadviser/ManageOfficersPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },

            {
                name: "schools-officers-documents",
                path: "sbo-adviser/schools/documents",
                component: () =>
                    import("../views/sboadviser/SchoolsDocuementPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },

            {
                name: "schools-contain-endorsed-documents",
                path: "sbo-adviser/schools/endorsed",
                component: () =>
                    import(
                        "../views/sboadviser/SchoolContainEndorsedDocumentPage.vue"
                    ),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },
            {
                name: "officers-documents",
                path: "sbo-adviser/schools/documents/:id",
                component: () => import("../views/sboadviser/DocumentPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-adviser"] },
                children: [],
            },

            //SBO STUDENT
            {
                props: true,
                name: "get-school-year-application",
                path: "school-years/applications",
                component: () =>
                    import("../views/sbostudent/SchoolYearApplicationPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],
            },

            {
                name: "application-from-osas",
                path: "school-years/applications/:id",
                component: () =>
                    import("../views/sbostudent/ApplicationFormPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],
            },

            {
                name: "take-application",
                path: "school-years/applications/tak/:applicationId/:title",
                component: () =>
                    import("../views/sbostudent/FillupFormPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],

                props: true,
            },

            {
                props: true,
                name: "school-year-minitor-application",
                path: "school-years/monitor",
                component: () =>
                    import("../views/sbostudent/SchoolYearMonitorPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
                children: [],
            },
            {
                name: "monitor-applications",
                path: "sbo-student/monitor/school/:id",
                component: () => import("../views/sbostudent/MonitorPage.vue"),
                meta: { requireAuth: true, allowedRoles: ["sbo-student"] },
            },

            {
                name: "monitor-app",
                path: "sbo-student/monitor/applications/:id",
                component: () =>
                    import("../views/sbostudent/ApplicationPage.vue"),
                props: true,
            },

            //CAMPUS DIRECTOR

            {
                name: "campus-director-endorsed-application",
                path: "campus-director-endorsed-application-from-sbo-adviser",
                component: () =>
                    import(
                        "../views/campusdirector/CampusDirectorSchoolsEndorsmentDocuementPage.vue"
                    ),
                meta: { requireAuth: true, allowedRoles: ["campus-director"] },
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
