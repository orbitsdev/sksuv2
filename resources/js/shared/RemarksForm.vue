

<template>
    <div class="relative">
        <h1 class="text-lg font-bold my-2 px-4">Enrollment Application</h1>
        <ul class="max-h-80 overflow-y-auto border-t-2 rounded-t-lg px-4 ">


            <RemarksCard v-for="i in data" :key="i.id" :message="i.message" :date="formatDate(i.updated_at)" >

            </RemarksCard>
           
        </ul>

        <div class="py-2 ">
            <textarea
            v-model.trim="remark"
            
              class="mt-2 focus:ring-1 focus:ring-gray-200 py-3 pl-3 overflow-y-auto h-24 border placeholder-gray-600 rounded w-full resize-none focus:outline-none"
            ></textarea>

            
         <div class="flex justify-end items-center mt-2">
            <button
            @click="$emit('close')"
            class="hover:shadow mr-2 rounded-md bg-white-600 px-3.5 py-1.5 text-base font-semibold leading-7 border shadow-sm hover:bg-white-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
          >
            Close
          </button> 
            <div class="p-2" v-if="isUpdating" >
                <BaseSpinner  />
              </div>
              <div v-else>
                <button 
                :disabled="remark.length <=0"
                :class="[' mr-2 rounded-md  px-3.5 py-1.5 text-base font-semibold leading-7  shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600', remark.length > 0 ? 'bg-green-700 hover:bg-green-500 text-white hover:shadow' :'bg-gray-50 text-gray-400' ]"
                
                >
                Update
              </button>
               
            </div>
         </div>
        </div>
    </div>
</template>

<script>

import moment from "moment";

    export default {

        
        
        created () {
            this.remarks = this.data;
        },
        
        props: {
            data:{
                type: Array,
                default: []
            },
            isUpdating:{
                type: Boolean,
                default:false,
            }

        },
        imits: ['close'],
        data() {
            return {
                remark: '',
                remarks: []
            }
        },
        methods: {
            formatDate(date) {
              return moment(date).format("MMM, D YYYY hh:mm a");
    },
        }
    }
</script>

<style  scoped>

</style>