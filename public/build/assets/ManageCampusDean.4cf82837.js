import{_ as q,x as p,g as h,w as n,r as c,o as a,d as r,c as i,k as N,i as f,b as l,h as y,z as R,t as u,e as d,F as w,T as b,v as S}from"./app.a30414ce.js";const I={created(){this.getDeans(),this.getAllSchoolYears(),this.getUsers()},data(){return{filterBy:"none",showForm:!1,search:"",sboadvisers:[],selectedSboAdvisers:[],requestError:null,isFetching:!1,isSchooLoading:!1,isSaving:!1,requestError:null,showMainForm:!1,hasRequestError:null,campus_deans:[],users:[],schools:[],school_years:[],selected_dean:null,selecated_school:null,selected_school_year:null,isSchoolYearFetching:!1,isAvailabeUserFetching:!1,isSchoolFetching:!1,seleted_deans:[],selectedCampusAdviser:null,showDeleteConfirmation:!1,isDeleting:!1,isUpdatingMode:!1,hasWarning:null,isFetchingUser:!1}},watch:{search(t,o){this.searchDean()}},methods:{changeHandler(t){let o=this.school_years.find(g=>g.id==t.target.value);this.schools=o.schools,this.selecated_school=null,this.schools.length>0&&(this.selecated_school=this.schools[0].id)},chnageSchoolData(){},handleCloseForm(){this.selectedCampusAdviser=null,this.isUpdatingMode=!1,this.showMainForm=!1},selectCampusAdviser(t){this.selectedCampusAdviser=t,this.isUpdatingMode=!0,console.log(t),this.selected_school_year=t.school_year.id,t.school!=null&&(this.selecated_school=t.school.id),this.showMainForm=!0},async deleteSelected(){this.isDeleting=!0,await p.post("api/manage-campus-dean/delete-selected",{campus_deans_id:this.seleted_deans}).then(t=>{console.log(t),this.showDeleteConfirmation=!1,this.seleted_deans=[],this.getDeans(),this.getUsers()}).catch(t=>{this.hasRequestError="Oops! It seems like there was an error when  when deleting campus advisers. if you think it it was the system please do contact the developer"}).finally(()=>{this.isDeleting=!1})},async getDeans(){this.isFetching=!0,await p.get("api/manage-campus-dean/get-all-campus-dean").then(t=>{this.campus_deans=t.data.data}).catch(t=>{this.hasRequestError="Oops! It seems like there was an error when  fetchin  campus advisers, Please check your network connection. o and try again. if you think it it was the system please do contact the developer"}).finally(()=>{this.isFetching=!1})},async getAllSchoolYears(){this.isSchoolYearFetching=!0,await p.get("api/school-year-with-schools").then(t=>{this.school_years=t.data.data,this.school_years.length>0&&(this.selected_school_year=this.school_years[0].id,this.schools=this.school_years[0].schools,this.schools.length>0&&(this.selecated_school=this.schools[0].id))}).catch(t=>{this.hasRequestError='"Oops! It seems like there was an error when  fetchin information school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSchoolYearFetching=!1})},async getUsers(){this.isFetchingUser=!0,await p.get("api/available-users").then(t=>{this.users=t.data.data,this.users.length>0&&(this.selected_dean=this.users[0].id)}).catch(t=>{this.hasRequestError='"Oops! It seems like there was an error when  fetchin available users school year, Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSchoolYearFetching=!1})},async addDean(){this.isSaving=!0;let t={user_id:this.selected_dean,school_id:this.selecated_school,school_year_id:this.selected_school_year};console.log(t),await p.post("api/manage-campus-dean/create",t).then(o=>{o.data.data===1?this.hasWarning='" You can only set one user Per School in each school year "':(this.showMainForm=!1,this.getAllSchoolYears(),this.getDeans(),this.getUsers()),console.log(o.data.data)}).catch(o=>{this.hasRequestError='"Oops! It seems like there was an error when adding campuse adviser Please check your network connection. o and try again. if you think it it was the system please do contact the developer'}).finally(()=>{this.isSaving=!1})},closeTheForm(){this.showForm=!1},showTheForm(){this.showForm=!0},customConfirmationDialog({title:t="Are you sure?",text:o="You won't be able to revert this!",icon:g="warning",confirmButtonText:x="Yes, delete it!",passFunction:e,passCancelFunction:_}){this.$swal({title:t,text:o,icon:g,showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:x}).then(async m=>{m.isConfirmed&&e()})},async searchDean(){p.post("api/campus/campus-adviser/search",{search:this.search}).then(t=>{this.campus_deans=t.data.data})},async getDeans(){this.isFetching=!0,await p.get("api/manage-campus-dean/get-all-campus-dean").then(t=>{this.campus_deans=t.data.data}).catch(t=>{this.requestError=t}).finally(()=>{this.isFetching=!1})}}},W=l("i",{class:"fa-solid fa-plus mr-1"},null,-1),P=d(" ADD CAMPUS DEANS "),O={key:0},G={key:1,class:"flex items-center"},j=l("i",{class:"fa-regular fa-trash-can mr-1"},null,-1),H=l("span",{class:"block"},"Delete Selected ",-1),L={class:"relative w-12 px-6 sm:w-16 sm:px-8"},z=["value"],J={class:"whitespace-nowrap px-3 py-4 text-sm text-green-700"},K={class:"font-semibold font-rubik"},Q={class:"whitespace-nowrap py-4"},X={class:"capitalize"},Z={class:"whitespace-nowrap py-4 text-sm text-gray-900"},$=d(" None "),ee=l("td",{class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},null,-1),se=d(" Yes "),te={class:"mt-2"},oe=l("p",{class:"text-base font-bold"},"Select School Year",-1),ae=d(" Empty "),ne=["value"],le={class:"mt-2"},ie=l("p",{class:"text-base font-bold"},"Select University",-1),re=d("Empty "),ce=["value"],he={class:"mt-2"},de=l("p",{class:"text-base font-bold mt-4"},"Select User",-1),ue=d("Empty "),_e=["value"],me={class:"my-2 flex justify-end"},pe=d(" Close "),ge={key:0,class:"my-1 mx-2"},fe={key:1},ye={key:0},we={key:1},ve=d(" Update "),ke=d(" Save "),Ce={key:0,class:"col-span-1 flex justify-center items-center"};function be(t,o,g,x,e,_){const m=c("TableButton"),F=c("BaseSearchInput"),v=c("BaseSpinner"),B=c("BaseTableSetup"),D=c("StatusCard"),A=c("BaseTable"),U=c("BaseConfirmation"),k=c("BaseDialog"),C=c("NoDataCard"),E=c("ConfirmCard"),Y=c("GlobalErrorCard"),M=c("GlobalWarning"),T=c("BaseCard");return a(),h(T,{class:"relative",subtitle:"Campus Deans"},{header:n(()=>[r(B,null,{"searchs-area":n(()=>[r(m,{class:"mr-2",onClick:o[0]||(o[0]=s=>e.showMainForm=!0)},{default:n(()=>[W,P]),_:1}),r(F,{placeholder:"Search name ..",modelValue:e.search,"onUpdate:modelValue":o[1]||(o[1]=s=>e.search=s)},null,8,["placeholder","modelValue"])]),"filters-area":n(()=>[e.isSchooLoading?(a(),i("div",O,[r(v)])):(a(),i("div",G))]),"actions-area":n(()=>[e.seleted_deans.length>0?(a(),h(m,{key:0,onClick:o[2]||(o[2]=s=>e.showDeleteConfirmation=!0),mode:""},{default:n(()=>[j,H]),_:1})):N("",!0)]),_:1})]),default:n(()=>[r(A,{thdata:["","Year","Campus Dean","University",""],isFetching:e.isFetching},{data:n(()=>[(a(!0),i(w,null,f(e.campus_deans,s=>(a(),i("tr",{key:s.id},[l("td",L,[y(l("input",{"onUpdate:modelValue":o[3]||(o[3]=V=>e.seleted_deans=V),value:s.id,type:"checkbox",class:"absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"},null,8,z),[[R,e.seleted_deans]])]),l("td",J,[l("p",K," SY."+u(s.school_year.from)+" - "+u(s.school_year.to),1)]),l("td",Q,[l("p",X,u(s.user.first_name+" "+s.user.last_name),1)]),l("td",Z,[s.school!=null?(a(),h(D,{key:0,class:"bg-green-700 text-white"},{default:n(()=>[d(u(s.school.name),1)]),_:2},1024)):(a(),h(D,{key:1,class:"bg-gray-700 text-white"},{default:n(()=>[$]),_:1}))]),ee]))),128))]),_:1},8,["isFetching"]),(a(),h(b,{to:"#app"},[r(k,{show:e.showForm,width:"500",preventClose:!0},{"c-content":n(()=>[r(U,{selectedData:e.selectedSboAdvisers,onClose:_.closeTheForm,isSaving:e.isSaving,title:"Are your sure do you want to make this users as",subject:"Sbo-Adviser"},{default:n(()=>[r(m,{class:"mr-2",onClick:t.makeUsersAsSboAdviser},{default:n(()=>[se]),_:1},8,["onClick"])]),_:1},8,["selectedData","onClose","isSaving"])]),_:1},8,["show"])])),(a(),h(b,{to:"#app"},[r(k,{show:e.showMainForm,width:"500",preventClose:!0},{"c-content":n(()=>[l("section",te,[l("div",null,[oe,e.school_years.length<=0?(a(),h(C,{key:0},{default:n(()=>[ae]),_:1})):y((a(),i("select",{key:1,onChange:o[4]||(o[4]=(...s)=>_.changeHandler&&_.changeHandler(...s)),"onUpdate:modelValue":o[5]||(o[5]=s=>e.selected_school_year=s),class:"block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"},[(a(!0),i(w,null,f(e.school_years,s=>(a(),i("option",{key:s.id,value:s.id}," SY. "+u(s.from)+" - "+u(s.to),9,ne))),128))],544)),[[S,e.selected_school_year]])])]),l("section",le,[l("div",null,[ie,e.schools.length<=0?(a(),h(C,{key:0},{default:n(()=>[re]),_:1})):y((a(),i("select",{key:1,"onUpdate:modelValue":o[6]||(o[6]=s=>e.selecated_school=s),class:"block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"},[(a(!0),i(w,null,f(e.schools,s=>(a(),i("option",{key:s.id,value:s.id},u(s.name),9,ce))),128))],512)),[[S,e.selecated_school]])])]),l("section",he,[l("div",null,[de,e.users.length<=0?(a(),h(C,{key:0},{default:n(()=>[ue]),_:1})):y((a(),i("select",{key:1,"onUpdate:modelValue":o[7]||(o[7]=s=>e.selected_dean=s),class:"block w-full py-2 px-3 pr-8 rounded-md bg-white border border-gray-400 focus:outline-none focus:shadow-outline-green focus:border-green-500 sm:text-sm sm:leading-5"},[(a(!0),i(w,null,f(e.users,s=>(a(),i("option",{key:s.id,value:s.id},u(s.first_name)+" "+u(s.last_name),9,_e))),128))],512)),[[S,e.selected_dean]])])]),l("div",me,[r(m,{mode:"",class:"mr-2",onClick:_.handleCloseForm},{default:n(()=>[pe]),_:1},8,["onClick"]),e.isSaving?(a(),i("div",ge,[r(v)])):(a(),i("div",fe,[e.selected_dean==null||e.selecated_school==null||e.selected_school_year==null?(a(),i("div",ye)):(a(),i("div",we,[e.isUpdatingMode?(a(),h(m,{key:0,class:"",onClick:t.updateCampusAdviser},{default:n(()=>[ve]),_:1},8,["onClick"])):(a(),h(m,{key:1,class:"",onClick:_.addDean},{default:n(()=>[ke]),_:1},8,["onClick"]))]))]))])]),_:1},8,["show"])])),(a(),h(b,{to:"#app"},[r(k,{show:e.showDeleteConfirmation,width:"600",preventClose:!0,class:"h-96"},{"c-content":n(()=>[r(E,{title:"Are you sure? Do you want to delete these Campus Advisers?",message:"Be mindful that deleting this data will also remove all associated informations. This action cannot be undone. Do you still wish to proceed?"},{default:n(()=>[e.isDeleting?(a(),i("div",Ce,[r(v)])):(a(),i("button",{key:1,onClick:o[8]||(o[8]=(...s)=>_.deleteSelected&&_.deleteSelected(...s)),class:"col-span-1 transition duration-150 ease-in-out hover:bg-red-600 bg-red-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"}," Yes ")),l("button",{class:"col-span-1 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm",onClick:o[9]||(o[9]=s=>e.showDeleteConfirmation=!1)}," Close ")]),_:1},8,["message"])]),_:1},8,["show"])])),r(Y,{onClose:o[10]||(o[10]=s=>e.hasRequestError=null),show:e.hasRequestError!=null},null,8,["show"]),r(M,{onClose:o[11]||(o[11]=s=>e.hasWarning=null),show:e.hasWarning!=null},{default:n(()=>[d(u(e.hasWarning),1)]),_:1},8,["show"])]),_:1})}const xe=q(I,[["render",be]]);export{xe as default};
