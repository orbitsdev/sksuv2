import{_ as I,x as d,g as p,w as l,r as c,o as a,d as r,k as C,c as i,i as f,b as n,h as y,z as q,t as h,F as w,T as V,v as x,e as u}from"./app.a30414ce.js";const R={created(){this.getSchoolYear(),this.getUser(),this.getVpa()},data(){return{search:"",vpas:[],users:[],selected_vpas:[],selected_vpa:null,hasRequestError:null,hasWarning:null,selectedItem:null,showVpaForm:!1,showDeleteConfirmation:!1,school_years:[],isDeleting:!1,isSaving:!1,isFetching:!1,isSchoolYearFetching:!1,isFetchingUser:!1}},watch:{search(o,s){this.searchVpa()}},methods:{searchVpa:_.debounce(async function(){await d.post("api/vpa/search",{search:this.search}).then(o=>{this.vpas=o.data.data})},300),async getUser(){this.isFetchingUser=!0,await d.get("api/available-users").then(o=>{this.users=o.data.data,this.users.length>0&&(this.selected_vpa=this.users[0].id)}).catch(o=>{this.hasRequestError='"Oops! It seems like there was an error when  fetchin available users school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSchoolYearFetching=!1})},selectVpa(o){this.selectedItem=o},async getVpa(){this.isFetching=!0,await d.get("api/vpa").then(o=>{this.vpas=o.data.data}).catch(o=>{this.hasRequestError='"Oops! It seems like there was an error when when fetchib vpaa Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isFetching=!1})},async createVpa(){this.isSaving=!0;let o={user_id:this.selected_vpa,school_year_id:this.selected_school_year};console.log(o),await d.post("api/vpa/create",o).then(s=>{s.data.data===1?this.hasWarning='" User is already exist "':(this.showVpaForm=!1,this.getSchoolYear(),this.getUser(),this.getVpa()),console.log(s.data.data)}).catch(s=>{this.hasRequestError='"Oops! It seems like there was an error when adding campuse adviser Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSaving=!1})},async getSchoolYear(){this.isSchoolYearFetching=!0,await d.get("api/school-year-with-schools").then(o=>{this.school_years=o.data.data,this.school_years.length>0&&(this.selected_school_year=this.school_years[0].id,this.schools=this.school_years[0].schools,this.schools.length>0&&(this.selecated_school=this.schools[0].id))}).catch(o=>{this.hasRequestError='"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSchoolYearFetching=!1})},async deleteSelectedVpa(){this.isDeleting=!0,await d.post("api/vpa/delete-selected",{vpas:this.selected_vpas}).then(o=>{this.showDeleteConfirmation=!1,this.selected_vpas=[],this.getSchoolYear(),this.getUser(),this.getVpa()}).catch(o=>{this.hasRequestError='"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isDeleting=!1})}}},N=n("i",{class:"fa-solid fa-plus mr-1"},null,-1),P=u(" ADD VPA "),W=n("i",{class:"fa-regular fa-trash-can mr-1"},null,-1),A=n("span",{class:"block"},"Delete Selected ",-1),O={class:"relative w-12 px-6 sm:w-16 sm:px-8"},G=["value"],M={class:"whitespace-nowrap px-3 py-4 text-sm text-green-700"},j={class:"font-semibold font-rubik"},z={class:"whitespace-nowrap py-4"},H={class:"capitalize"},L=n("td",{class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},null,-1),J={class:"mt-2"},K=n("p",{class:"text-base font-bold"},"Select School Year",-1),Q=u(" Empty "),X=["value"],Z={class:"mt-2"},$=n("p",{class:"text-base font-bold mt-4"},"Select User",-1),ee=u("Empty "),se=["value"],te={class:"my-2 flex justify-end"},oe=u(" Close "),ae={key:0,class:"my-1 mx-2"},ne={key:1},le={key:0},re=u(" Save "),ie={key:0,class:"col-span-1 flex justify-center items-center"};function ce(o,s,he,de,t,g){const m=c("TableButton"),S=c("BaseSearchInput"),D=c("BaseTableSetup"),B=c("BaseTable"),v=c("NoDataCard"),k=c("BaseSpinner"),b=c("BaseDialog"),F=c("ConfirmCard"),E=c("GlobalErrorCard"),Y=c("GlobalWarning"),U=c("BaseCard");return a(),p(U,{class:"relative",subtitle:"Manage VPA"},{header:l(()=>[r(D,null,{"searchs-area":l(()=>[r(m,{class:"mr-2",onClick:s[0]||(s[0]=e=>t.showVpaForm=!0)},{default:l(()=>[N,P]),_:1}),r(S,{placeholder:"Search name ..",modelValue:t.search,"onUpdate:modelValue":s[1]||(s[1]=e=>t.search=e)},null,8,["placeholder","modelValue"])]),"filters-area":l(()=>[]),"actions-area":l(()=>[t.selected_vpas.length>0?(a(),p(m,{key:0,onClick:s[2]||(s[2]=e=>t.showDeleteConfirmation=!0),mode:""},{default:l(()=>[W,A]),_:1})):C("",!0)]),_:1})]),default:l(()=>[r(B,{thdata:["","Year","Campus Director Name",""],isFetching:t.isFetching},{data:l(()=>[(a(!0),i(w,null,f(t.vpas,e=>(a(),i("tr",{key:e.id},[n("td",O,[y(n("input",{"onUpdate:modelValue":s[3]||(s[3]=T=>t.selected_vpas=T),value:e.id,type:"checkbox",class:"absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"},null,8,G),[[q,t.selected_vpas]])]),n("td",M,[n("p",j," SY."+h(e.school_year.from)+" - "+h(e.school_year.to),1)]),n("td",z,[n("p",H,h(e.user.first_name+" "+e.user.last_name),1)]),L]))),128))]),_:1},8,["isFetching"]),(a(),p(V,{to:"#app"},[r(b,{show:t.showVpaForm,width:"500",preventClose:!0},{"c-content":l(()=>[n("section",J,[n("div",null,[K,t.school_years.length<=0?(a(),p(v,{key:0},{default:l(()=>[Q]),_:1})):y((a(),i("select",{key:1,onChange:s[4]||(s[4]=(...e)=>o.changeHandler&&o.changeHandler(...e)),"onUpdate:modelValue":s[5]||(s[5]=e=>o.selected_school_year=e),class:"block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"},[(a(!0),i(w,null,f(t.school_years,e=>(a(),i("option",{key:e.id,value:e.id}," SY. "+h(e.from)+" - "+h(e.to),9,X))),128))],544)),[[x,o.selected_school_year]])])]),n("section",Z,[n("div",null,[$,t.users.length<=0?(a(),p(v,{key:0},{default:l(()=>[ee]),_:1})):y((a(),i("select",{key:1,"onUpdate:modelValue":s[6]||(s[6]=e=>t.selected_vpa=e),class:"block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"},[(a(!0),i(w,null,f(t.users,e=>(a(),i("option",{key:e.id,value:e.id},h(e.first_name)+" "+h(e.last_name),9,se))),128))],512)),[[x,t.selected_vpa]])])]),n("div",te,[r(m,{mode:"",class:"mr-2",onClick:s[7]||(s[7]=e=>t.showVpaForm=!1)},{default:l(()=>[oe]),_:1}),t.isSaving?(a(),i("div",ae,[r(k)])):(a(),i("div",ne,[t.selected_vpa==null||o.selected_school_year==null?(a(),i("div",le)):C("",!0),n("div",null,[r(m,{class:"",onClick:g.createVpa},{default:l(()=>[re]),_:1},8,["onClick"])])]))])]),_:1},8,["show"])])),(a(),p(V,{to:"#app"},[r(b,{show:t.showDeleteConfirmation,width:"600",preventClose:!0,class:"h-96"},{"c-content":l(()=>[r(F,{title:"Are you sure? Do you want to delete these Vpaa",message:"Be mindful that deleting this data will also remove all associated informations. This action cannot be undone. Do you still wish to proceed?"},{default:l(()=>[t.isDeleting?(a(),i("div",ie,[r(k)])):(a(),i("button",{key:1,onClick:s[8]||(s[8]=(...e)=>g.deleteSelectedVpa&&g.deleteSelectedVpa(...e)),class:"col-span-1 transition duration-150 ease-in-out hover:bg-red-600 bg-red-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"}," Yes ")),n("button",{class:"col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm",onClick:s[9]||(s[9]=e=>t.showDeleteConfirmation=!1)}," Close ")]),_:1},8,["message"])]),_:1},8,["show"])])),r(E,{onClose:s[10]||(s[10]=e=>t.hasRequestError=null),show:t.hasRequestError!=null},null,8,["show"]),r(Y,{onClose:s[11]||(s[11]=e=>t.hasWarning=null),show:t.hasWarning!=null},{default:l(()=>[u(h(t.hasWarning),1)]),_:1},8,["show"])]),_:1})}const ue=I(R,[["render",ce]]);export{ue as default};
