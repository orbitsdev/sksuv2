<template>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">{{ label}}</label>
        <div class="mt-1 flex items-center justify-between">
        
          <input 
          :type="show? 'text' : 'password'"  
          :value="modelValue"
          :placeholder="showPlaceholder ? label : '' "
          @input="$emit('update:modelValue', $event.target.value)"
          :class="[{
            'block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm': (hasError == false || hasError == null), 
            'block w-full appearance-none rounded-md border-2 border-red-600 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-red-600 focus:outline-none focus:ring-red-600 sm:text-sm': !!hasError,
        
        }]"
          />
          <button class="p-2 w-10 rounded-sm ml-1" @click.prevent="$emit('showPassword')">
            <i :class="{'fa-regular fa-eye-slash': !show, 'fa-regular fa-eye': show }"></i>
          </button>
            </div>
        <p v-if="!!hasError" class="mx-2 text-red-500 text-sm my-2"> {{ hasError[0] }} </p>
      </div>
</template>

<script>

    export default {

        imits: ['showPassword'],
        props: {
           
            showPlaceholder:{
                type: Boolean,
                default: false,                
            },
            label:{
                type: String,
                default: '',
                required: false
            },

            modelValue: {
                type: [String, Number],
                default: '',
                
            },
            hasError: {
                type: [String, Array, Number],
                default: null,
                required: false,
            },
            show: {
                type:Boolean,
                default:true,
                required: false,
            }

        },    
    }
</script>

<style  scoped>

</style>