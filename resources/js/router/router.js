import { createRouter } from "vue-router";
import { createWebHistory } from "vue-router";
import store from "../store/store.js";

function authenticated() {
    return !!localStorage.getItem("token");
}




const authorization = async (to, from, next) => {
    if(to.meta.middleware === "auth" && !authenticated()){
        next({path:'/?login=attemp'});
        return;

    }else if(to.meta.middleware === "guest" && authenticated()){
        next({path:'/dashboard'});
        return;

    }else{
        if(authenticated()){
             if(store.state.auth.User == null){
            await store.dispatch('getUser').then(res=>{
                store.commit('setUser',res);
            }).catch(err=>{
                localStorage.removeItem('token');
                next({path:'/?login=failed'});
                
            })
            if(!!to.meta.roleIs){
                console.log("has roles meta");
                console.log(store.state.auth.User.is(to.meta.roleIs));
                
                if(store.state.auth.User.is(to.meta.roleIs)){
                    next();
                    console.log(to.path);
                    
                }else{
                    
                    next({path: '/401'});
                    console.log(to.path);
                }

            }else{
                console.log("no roles meta");
                console.log(to.path);
                next();
            }




            
          
            
        }else{
            next();
        }
        }else{
            next();
        }
       
       
        
       
     
    }
        
};

const routes = [
    {
        name: "googledriveupload",
        path: "/google",
        component: () => import("../testproject/GoogleDriveUploadPage.vue"),
        beforeEnter: authorization,
    },
    {
        name: "getstarted",
        path: "/",
        component: () => import("../views/GetStartedPage.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
    {
        name: "login",
        path: "/login",
        component: () => import("../views/LoginPage.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
    {
        name: "register",
        path: "/register",
        component: () => import("../views/RegisterPage.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },

    {
        name: "token-catcher",
        path: "/authorize/google/callback",
        component: () => import("../views/SocialAccountTokenCatcher.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
    {
        name: "forgotpassword",
        path: "/forgot-password",
        component: () => import("../views/ForgotPassword.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
    {
        name: "setnewpassword",
        path: "/set-new-password",
        component: () => import("../views/SetNewPasswordPage.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
    {
        name: "password-request-sent",
        path: "/password-request-sent",
        component: () => import("../views/PasswordRequestSent.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },

    {
        name: "getting-started",
        path: "/getting-started",
        component: () => import("../views/GettingStarted.vue"),
        meta: { middleware: "auth" },
        beforeEnter: authorization,
    },
    {
        name: "notauhtorize",
        path: "/401",
        component: () => import("../views/NoAuthorizePage.vue"),
        beforeEnter: authorization,
    },

    {
        name: "dashboard",
        path: "/dashboard",
        component: () => import("../views/DashboardPage.vue"),
        meta: { middleware: "auth" },
        beforeEnter: authorization,
        children: [
            {
                name: "manage-school",
                path: "/dashboard/osas/manage-school",
                component: () => import("../views/OSAS/ManageSchool.vue"),
                meta: { middleware: "auth", roleIs: 'osas' },
                children: [],
                beforeEnter: authorization,
            },
            {
                name: "manage-school-department",
                path: "/dashboard/osas/manage-school-department",
                component: () => import("../views/OSAS/ManageDepartment.vue"),
                meta: { middleware: "auth", roleIs: 'osas' },
                children: [],
                beforeEnter: authorization,
            },
            {
                name: "manage-sbo-adviser",
                path: "/dashboard/osas/manage-sbo-adviser",
                // redirect: '/dashboard/osas/manage-school/user',
                component: () => import("../views/OSAS/ManageSboAdviser.vue"),
                meta: { middleware: "auth", roleIs: 'osas' },
                beforeEnter: authorization,

                children: [
                    {
                        name: "manage-sbo-adviser-adviser",
                        path: "/dashboard/osas/manage-sbo-adviser/advisers",
                        component: () => import("../views/OSAS/SboAdviser.vue"),
                        meta: { roleIs: 'osas' },
                        beforeEnter: authorization,
                    },
                    {
                        name: "manage-sbo-adviser-user",
                        path: "/dashboard/osas/manage-sbo-adviser/users",
                        component: () =>
                            import("../views/OSAS/SboAdviserUser.vue"),
                        meta: { roleIs: 'osas' },
                        beforeEnter: authorization,
                    },
                    {
                        name: "manage-sbo-adviser-request",
                        path: "/dashboard/osas/manage-sbo-adviser/requests",
                        component: () =>
                            import("../views/OSAS/SboAdviserRequest.vue"),
                        meta: { roleIs: 'osas' },
                        beforeEnter: authorization,
                    },
                ],
            },
            {
                name: "manage-application",
                path: "/dashboard/osas/manage-application",
                component: () => import("../views/OSAS/ManageApplication.vue"),
                meta: { middleware: "auth", roleIs: 'osas' },
                beforeEnter: authorization,
            },
            {
                name: "manage-roles",
                path: "/dashboard/osas/manage-roles",
                component: () => import("../views/OSAS/ManageRole.vue"),
                meta: { middleware: "auth", roleIs: 'osas' },
                beforeEnter: authorization,
            },

            // SEND  SBO ADVISER ROLE REQUES
            {
                name: "sbo-adviser-makerequest",
                path: "/dashboard/sbo-adviser/make-request",
                component: () =>
                    import("../views/SBO-ADVISER/MakeRequestPage.vue"),
                meta: { middleware: "auth", roleIs: 'guest' },
                children: [],
                beforeEnter: authorization,
            },

            {
                name: "manage-sbo-officers",
                path: "/dashboard/sbo-adviser/manage-sbo-offers",
                component: () =>
                    import("../views/SBO-ADVISER/ManageOfficersPage.vue"),
                meta: { middleware: "auth", roleIs: ["sbo-adviser"] },
                children: [],
                beforeEnter: authorization,
            },
        ],
    },

    {
        name: "load",
        path: "/load",
        component: () => import("../components/LoadingScreen.vue"),
        meta: { middleware: "guest" },
        beforeEnter: authorization,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});


export default router;
