import{_ as B,x as p,c,d as l,w as a,r as i,o as r,g as m,e as d,t as f,k as D,F as V,i as E,b as e,h as T,z as A,T as Y}from"./app.a30414ce.js";const M={components:{},created(){this.getAllSchoolYears()},data(){return{yearFormat:"YYYY",viewMode:"years",isSaving:!1,search:"",showForm:!1,isFetching:!1,schoolyears:[],selectedSchoolYears:[],selectedSchoolYear:null,validationError:null,requestError:null,fromYear:new Date,toYear:new Date,isUpdatingMode:!1,showConfirmation:!1,isDeleting:!1}},methods:{showConfirmationModal(){this.showConfirmation=!0},closeConfirmationModal(){this.showConfirmation=!1},async deleteSelectedSchoolYear(){console.log(this.selectedSchoolYears),this.isDeleting=!0,await p.post("api/school-year/delete-selected-school-year",{school_years:this.selectedSchoolYears}).then(n=>{this.selectedSchoolYears=[],this.showConfirmation=!1,this.getAllSchoolYears()}).catch(n=>{console.log(n),this.requestError='"Oops! It seems like there was an error when deleting, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isDeleting=!1})},async getAllSchoolYears(){this.isFetching=!0,await p.get("api/school-year-with-schools").then(n=>{this.schoolyears=n.data.data}).catch(n=>{this.requestError='"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isFetching=!1})},handleCloseForm(){this.isUpdatingMode=!1,this.selectedSchoolYear=null,this.showForm=!1},selecSchoolYear(n){this.selectedSchoolYear=n,this.fromYear=new Date(n.from,0,1),this.toYear=new Date(n.to,0,1),this.showForm=!0},async updateSchoolYear(){this.isSaving=!0;let n={fromYear:this.fromYear.getFullYear(),toYear:this.toYear.getFullYear(),id:this.selectedSchoolYear.id};await p.post("api/school-year/update",n).then(t=>{this.showForm=!1,this.selectedSchoolYears=[],this.getAllSchoolYears()}).catch(t=>{this.requestError='"Oops! It seems like there was an error when  updating school year , Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSaving=!1})},async saveYear(){this.isSaving=!0;let n={fromYear:this.fromYear.getFullYear(),toYear:this.toYear.getFullYear()};await p.post("api/school-year/create",n).then(t=>{this.showForm=!1,this.selectedSchoolYears=[],this.getAllSchoolYears()}).catch(t=>{console.log(t)}).finally(()=>{this.isSaving=!1})}}},q=e("p",{index:"40px",class:"text-white font-rubok text-base font-semibold"}," - Be aware that deleting shool year will also delete all attached files. ",-1),U=e("i",{class:"fa-solid fa-plus mr-1"},null,-1),I=d(" Add School Year "),N=e("i",{class:"fa-regular fa-trash-can mr-2"},null,-1),j={class:"whitespace-normal align-top relative w-12 px-6 sm:w-16 sm:px-8"},z=["value"],O={class:"whitespace-normal align-top py-4"},P={tabindex:"0",class:"whitespace-normal pl-2 align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800"},G={class:"whitespace-normal align-top py-4"},L={tabindex:"0",class:"whitespace-normal pl-2 align-top font-semibold text-wrap focus:outline-none text-sm leading-none text-gray-800"},H=["onClick","disabled"],J=e("i",{class:"fa-regular fa-pen-to-square"},null,-1),K=[J],Q=e("p",{class:"text-lg font-bold"},"Choose Year",-1),R={class:"bg-green-700 py-4 px-6 rounded-lg grid grid-cols-2 my-2 gap-x-2 mt-4"},W={class:"col-span-1"},X=e("p",{class:"mb-1 text-sm font-bold capitalize text-white"},"From",-1),Z={class:"col-span-1"},$=e("p",{class:"mb-1 text-sm font-bold capitalize text-white"},"to",-1),ee=e("div",{class:"my-4 h-72 flex items-center justify-center"},[e("img",{src:"/assets/undraw_my_files_swob.svg",alt:"",class:"h-36"})],-1),te={class:"my-2 flex justify-end"},oe=d(" Close "),se={key:0,class:"my-1 mx-2"},le={key:1},ae=d(" Save "),ne=d(" Update "),re={key:0,class:"col-span-1 flex justify-center items-center"};function ie(n,t,ce,he,o,h){const x=i("InstructionCard"),u=i("TableButton"),b=i("BaseTableSetup"),S=i("StatusCard"),v=i("BaseTable"),g=i("Datepicker"),_=i("BaseSpinner"),y=i("BaseDialog"),C=i("ConfirmCard"),k=i("GlobalErrorCard"),F=i("BaseCard");return r(),c("div",null,[l(x,{class:"mb-4 shadow pulse",title:"Note "},{default:a(()=>[q]),_:1}),l(F,{subtitle:"Manage School Year"},{header:a(()=>[l(b,null,{"searchs-area":a(()=>[l(u,{class:"mr-2",onClick:t[0]||(t[0]=s=>o.showForm=!0)},{default:a(()=>[U,I]),_:1})]),"actions-area":a(()=>[o.selectedSchoolYears.length>0?(r(),m(u,{key:0,class:"",mode:"",onClick:t[1]||(t[1]=s=>o.showConfirmation=!0)},{default:a(()=>[N,d(" Delete selected "+f(o.selectedSchoolYears.length),1)]),_:1})):D("",!0)]),_:1}),l(v,{thdata:[" ","School Year","Univerity",""],isFetching:o.isFetching},{data:a(()=>[(r(!0),c(V,null,E(o.schoolyears,s=>(r(),c("tr",{key:s},[e("td",j,[T(e("input",{"onUpdate:modelValue":t[2]||(t[2]=w=>o.selectedSchoolYears=w),value:s.id,type:"checkbox",class:"absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"},null,8,z),[[A,o.selectedSchoolYears]])]),e("td",O,[e("p",P," SY. "+f(s.from)+"-"+f(s.to),1)]),e("td",G,[e("p",L,[l(S,{class:"bg-green-100 text-green-700"},{default:a(()=>[d(f(s.schools.length),1)]),_:2},1024)])]),e("td",null,[e("button",{onClick:w=>h.selecSchoolYear(s),disabled:o.selectedSchoolYears.length>0,type:"button",class:"inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"},K,8,H)])]))),128))]),_:1},8,["isFetching"])]),default:a(()=>[(r(),m(Y,{to:"#app"},[l(y,{show:o.showForm,width:"600",preventClose:!0,class:"h-96"},{"c-content":a(()=>[Q,e("div",R,[e("div",W,[X,l(g,{class:"px-2 py-2 w-full text-lg border",modelValue:o.fromYear,"onUpdate:modelValue":t[3]||(t[3]=s=>o.fromYear=s),inputFormat:"yyyy","minimum-view":"year"},null,8,["modelValue"])]),e("div",Z,[$,l(g,{class:"px-2 py-2 w-full text-lg border",modelValue:o.toYear,"onUpdate:modelValue":t[4]||(t[4]=s=>o.toYear=s),inputFormat:"yyyy","minimum-view":"year"},null,8,["modelValue"])])]),ee,e("div",te,[l(u,{mode:"",class:"mr-2",onClick:h.handleCloseForm},{default:a(()=>[oe]),_:1},8,["onClick"]),o.isSaving?(r(),c("div",se,[l(_)])):(r(),c("div",le,[this.selectedSchoolYear==null?(r(),m(u,{key:0,class:"",onClick:h.saveYear},{default:a(()=>[ae]),_:1},8,["onClick"])):(r(),m(u,{key:1,onClick:h.updateSchoolYear,class:""},{default:a(()=>[ne]),_:1},8,["onClick"]))]))])]),_:1},8,["show"])])),(r(),m(Y,{to:"#app"},[l(y,{show:o.showConfirmation,width:"600",preventClose:!0,class:"h-96"},{"c-content":a(()=>[l(C,{title:"Are you sure? Do you want to delete this school years?",message:"Be mindful that deleting this data will also remove all associated informations. This action cannot be undone. Do you still wish to proceed?"},{default:a(()=>[o.isDeleting?(r(),c("div",re,[l(_)])):(r(),c("button",{key:1,onClick:t[5]||(t[5]=(...s)=>h.deleteSelectedSchoolYear&&h.deleteSelectedSchoolYear(...s)),class:"col-span-1 transition duration-150 ease-in-out hover:bg-red-600 bg-red-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"}," Yes ")),e("button",{class:"col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm",onClick:t[6]||(t[6]=s=>o.showConfirmation=!1)}," Close ")]),_:1},8,["message"])]),_:1},8,["show"])])),l(k,{onClose:t[7]||(t[7]=s=>o.requestError=null),show:o.requestError!=null},null,8,["show"])]),_:1})])}const ue=B(M,[["render",ie]]);export{ue as default};
