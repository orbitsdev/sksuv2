import{_ as h,a as _,c as d,b as n,t as m,f as g,d as t,g as y,w as c,T as v,r as a,o as i,p as E,q as P}from"./app.a30414ce.js";const x={mounted(){this.setCredentials()},data(){return{form:{email:"",token:"",password:"",password_confirmation:"",actual_email:""},showPassword:!1,showPasswordConfirmation:!1,screenLoading:!1,isLoading:!1,validationError:{},requestError:null}},methods:{async setCredentials(){this.$route.query.email&&this.$route.query.token&&(this.form.email=this.$route.query.email,this.form.actual_email=this.$route.query.email,this.form.token=this.$route.query.token)},closeErrorDialog(){this.validationError={},this.requestError=null},async setNewPassword(){this.isLoading=!0,await _.post("api/set-password",this.form).then(e=>{this.$router.replace("/")}).catch(e=>{e.response.status===422?this.validationError=e.response.data.errors:this.requestError={statusCode:String(e.response.status),message:e.response.data[0]}}).finally(()=>{this.isLoading=!1})}}},q=e=>(E("data-v-1a77100c"),e=e(),P(),e),C={class:"flex justify-center items-center h-screen p-20 bg-white"},S={class:"flex flex-col justify-center items-center"},b=q(()=>n("img",{class:"sv-image",src:"/assets/my_universe_803e.svg",alt:"sksu"},null,-1)),k={class:"mt-2 text-lg tex-green-400 font-bold tracking-tight text-gray-900 sm:text-5xl"},B={class:"min-h-16"},N={key:0,class:"flex justify-center items-center"},V={key:1,type:"submit",class:"flex w-full justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"};function I(e,o,D,L,s,l){const u=a("BaseInputPassword"),w=a("BaseSpinner"),f=a("RequestError"),p=a("BaseErrorDialog");return i(),d("div",C,[n("div",S,[b,n("h1",k,m(s.form.email)+" "+m(s.validationError),1),n("form",{class:"space-y-3 mt-4",onSubmit:o[4]||(o[4]=g((...r)=>l.setNewPassword&&l.setNewPassword(...r),["prevent"]))},[t(u,{label:"Enter New Password",show:s.showPassword,onShowPassword:o[0]||(o[0]=r=>s.showPassword=!s.showPassword),hasError:s.validationError.password,modelValue:s.form.password,"onUpdate:modelValue":o[1]||(o[1]=r=>s.form.password=r)},null,8,["show","hasError","modelValue"]),t(u,{label:"Retype New Password",show:s.showPasswordConfirmation,onShowPassword:o[2]||(o[2]=r=>s.showPasswordConfirmation=!s.showPasswordConfirmation),modelValue:s.form.password_confirmation,"onUpdate:modelValue":o[3]||(o[3]=r=>s.form.password_confirmation=r)},null,8,["show","modelValue"]),n("div",B,[s.isLoading?(i(),d("div",N,[t(w)])):(i(),d("button",V," Save "))])],32),(i(),y(v,{to:"#app"},[t(p,{show:s.requestError!=null,width:"400",transition:"slide-fade-down"},{"c-content":c(()=>[t(f,{statusCode:s.requestError.statusCode,onClose:l.closeErrorDialog,message:s.requestError.message},null,8,["statusCode","onClose","message"])]),"c-actions":c(()=>[]),_:1},8,["show"])]))])])}const R=h(x,[["render",I],["__scopeId","data-v-1a77100c"]]);export{R as default};
