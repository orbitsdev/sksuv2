import{_ as o,g as t,o as n,r}from"./app.1c991082.js";const c={created(){this.loginUser()},methods:{loginUser(){localStorage.setItem("token",this.$route.query.code),localStorage.getItem("token")&&window.location.reload(!0)}}};function a(s,i,l,d,_,p){const e=r("LoadingScreen");return n(),t(e)}const m=o(c,[["render",a]]);export{m as default};
