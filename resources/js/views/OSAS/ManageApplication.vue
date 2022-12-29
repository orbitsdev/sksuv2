<template>
  <BaseCard :subtitle="'Manage Form'">
    <template #header>
      <BaseTableSetup>
        <template #searchs-area>
          <TableButton class="mr-2" @click="showTheForm">
            <i class="fa-solid fa-plus mr-1"></i> Create Application Form
          </TableButton>
          <BaseSearchInput :placeholder="'Search application ...'" v-model="search" />
        </template>
        <template #filters-area></template>
        <template #actions-area></template>
      </BaseTableSetup>
      <BaseTable :thdata="['', 'Name', '']" :isFetching="isFetching">
        <template #data>
          <tr>
            <td class="relative w-12 px-6 sm:w-16 sm:px-8">
              <input
                type="checkbox"
                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
              />
            </td>
            <td class="whitespace-nowrap py-4 text-sm">
              <div class="flex items-center">
                <div class="pl-1">
                  <div class="font-medium capitalize text-sm pr-2 text-gray-900">
                    APPLICATION LETTERS
                  </div>
                </div>
              </div>
            </td>

            <td
              class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            >
              <button
                type="button"
                class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button
                type="button"
                class="inline-flex items-center rounded-md border outline:none border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-30 mr-1"
              >
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        </template>
      </BaseTable>
    </template>

    <teleport to="#app">
      <BaseDialog :show="showForm" :width="'800'" :preventClose="true">
        <template #c-content>
          <label class="text-sm">Form title </label>

          <BaseInput />
          <div class="mt-2 ">
            <div class="">
              <Button class="border rounded-lg  p-1 hover:shadow-lg" @click="handleAddFields">
                <i class="fa-solid fa-plus mr-1"></i> Fields
              </Button>
            </div>
            <div v-for="(field,parentindex) in formfields" :key="field.id" class=" relative shadow my-4 border p-2 rounded bg-gray-100">
              <div>

           
              <button 
              @click="removeField(parentindex)"
              class="closeButton flex items-center justify-center rounded-full bg-gray-400 cursor-pointer hover:scale-95">
                <i class="fa-solid fa-xmark"></i>
              </button>
              <div class="">
                
                <label class="text-sm"> Field name </label>
                <input type="text" class="w-full p-1 border ">
                <!-- <BaseInput /> -->
              </div>
              <div class="mt-2 flex justify-between">
                <div>
                  <label class="text-sm"> Field type </label>
                  <div class="mt-1 grid grid-cols-5 gap-1">
                    <label
                    v-for="(option, index) in field.fieldtypeOption"
                    :key="option.id"
                    class="inline-flex items-center rounded cursor-pointer"
                  >
                    <input
                      v-model="option.selected"
                      @change="handleFieldTypeSelection(parentindex,index,option)"
                      type="checkbox"
                      class="mr-1 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
                    />
                    <span class="text-sm"> {{ option.name }}</span>

                  </label>
                  </div>
                  <div class="mt-2 ">
                    <div class="" v-if="formfields[parentindex].selectedtype == 3">
                      <p>Choose data for select field</p>
                      <w-divider class="my6 my-2"></w-divider>
                      <label v-for="(collection, index) in formfields[parentindex].data" :key="collection" class="mt-3 border cursor-pointer flex items-center px-2 py-1 rounded">
                        <input
                        v-model="collection.selected"
                        @change="handleDdataSelection(parentindex,index,collection)"
                        type="checkbox"
                        class="mr-1 h-4 w-4 accent-green-600 text-white rounded border-gray-200 sm:left-6"
                      /> <span class="text-sm"> {{ collection.name}} </span>
                      </label>
                     </div>
                  </div>
                </div>
                
              </div>
            </div>
            
            <w-divider class="my6 my-2"></w-divider>
          <div class="my-2 flex justify-end">
            <TableButton mode class="mr-2" > Close </TableButton>
           <div class="my-1 mx-2" v-if="isSaving">
             <BaseSpinner />
           </div>
            <div >
              <TableButton  >  Save </TableButton>
            </div>
          </div>
        </div>
          </div>
        </template>
      </BaseDialog>
    </teleport>
  </BaseCard>
</template>

<script>
export default {
  data() {
    return {
      showForm: true,
      formfields: [
      
      ],
    };
  },

  methods: {

    removeField(parentindex){
        this.formfields.splice(parentindex, 1);
    },
    handleAddFields() {

      const id = this.formfields.length+1;
      const newfields = {
        id: id,
        selectedtype:1,
        selecteddata: null,
        fieldtypeOption: [
        
            { id: 1, name: "Text", value: "text", selected: true },
            { id: 2, name: "Email", value: "email", selected: false },
            { id: 3, name: "Select", value: "select", selected: false },
            { id: 4, name: "Number", value: "number", selected: false },
            { id: 5, name: "Text Area", value: "textarea", selected: false },
        
        ],
        data:[
          { id: 1, name: "Users", value: "users", selected: false },
          { id: 2, name: "School", value: "schools", selected: false },
          { id: 3, name: "Department", value: "departments", selected: false },
        ],
        
      };

      this.formfields.push(newfields);
    },
    handleFieldTypeSelection(parentindex,index,item) {

      this.formfields[parentindex].fieldtypeOption.forEach((i)=>{
        i.selected = false;
      });
      item.selected = true;

      this.formfields[parentindex].selectedtype = item.id;
        
      
    },

    handleDdataSelection(parentindex,index,item) {

    this.formfields[parentindex].data.forEach((i)=>{
      i.selected = false;
    });
    item.selected = true;

    this.formfields[parentindex].selecteddata = item.id;   
    console.log(this.formfields[parentindex].selectedtype);   
    console.log(this.formfields[parentindex].selecteddata);   
    },
  },
};
</script>

<style scoped>

.closeButton{
  position:  absolute;
  top: -10px;
  right: -10px;
  width: 24px;
  height: 24px;

}
</style>
