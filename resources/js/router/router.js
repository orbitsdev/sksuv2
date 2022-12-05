



import {createRouter} from 'vue-router';
import {createWebHistory} from 'vue-router';
import store from '../store/store';


const routes = [
    {
        name: 'getstarted',
        path: '/',
        component: ()=> import('../views/GetStartedPage.vue'),
        meta: {middleware: "guest"}
        
    },
    {
        name: 'login',
        path: '/login',
        component: ()=> import('../views/LoginPage.vue'),
        meta: {middleware: "guest"}
    },
    {
        name: 'register',
        path: '/register',
        component: ()=> import('../views/RegisterPage.vue'),
        meta: {middleware: "guest"}
    },
  
    {
        name: 'token-catcher',
        path: '/authorize/google/callback',
        component: ()=> import('../views/SocialAccountTokenCatcher.vue'),
        meta: {middleware: "guest"}
       
    },
    {
        name: 'forgotpassword',
        path: '/forgot-password',
        component: ()=> import('../views/ForgotPassword.vue'),
        meta: {middleware: "guest"}
       
    },
    {
        name: 'setnewpassword',
        path: '/set-new-password',
        component: ()=> import('../views/SetNewPasswordPage.vue'),
        meta: {middleware: "guest"}
       
    },
    {
        name: 'password-request-sent',
        path: '/password-request-sent',
        component: ()=> import('../views/PasswordRequestSent.vue'),
        meta: {middleware: "guest"}
       
    },
    {
        name: 'test',
        path: '/test',
        component: ()=> import('../views/TEST/CompositionApiPage.vue'),
        meta: {middleware: "guest"}
       
    },

    {
        name: 'dashboard',
        path: '/dashboard',
        component: ()=> import('../views/DashboardPage.vue'),
        meta: {middleware: "auth"},
        children: [
            {
                name: 'manage-school',
                path: '/dashboard/osas/manage-school',
                component: ()=> import('../views/OSAS/ManageSchool.vue'),
                meta: {middleware: "auth"}
            },
            {
                name: 'manage-sbo-adviser',
                path: '/dashboard/osas/manage-sbo-adviser',
                component: ()=> import('../views/OSAS/ManageSbo.vue'),
                meta: {middleware: "auth"}
            },
            {
                name: 'manage-application',
                path: '/dashboard/osas/manage-application',
                component: ()=> import('../views/OSAS/ManageApplication.vue'),
                meta: {middleware: "auth"}
            },
            {
                name: 'manage-roles',
                path: '/dashboard/osas/manage-roles',
                component: ()=> import('../views/OSAS/ManageRole.vue'),
                meta: {middleware: "auth"}
            },
        ],
    },

   
];


const router = createRouter({
    history:  createWebHistory(),
    routes: routes
});


function authenticated(){
    return localStorage.getItem('token');
}
router.beforeEach((to,from,next)=>{

    if(to.meta.middleware == 'guest' && authenticated()){
        next('/dashboard');
    }else  if(to.meta.middleware == "auth" && !authenticated()){
        next('/?login=attemp');
    }else{
        next();
    }

});
export default router;