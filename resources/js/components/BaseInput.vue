<template>
    <div>
        <label for="email" class="block text-sm ">{{ label}}</label>
        <div class="mt-1">
        
          <input 
          :type="type"  
          :value="modelValue"
          :placeholder="showPlaceholder ? label : '' "
          @input="$emit('update:modelValue', $event.target.value)"
          :class="[{
            'block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm  focus:outline-none sm:text-base': (hasError == false || hasError == null), 
            'block w-full appearance-none rounded-md border-2 border-red-600 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-red-600 focus:outline-none focus:ring-red-600 sm:text-base': !!hasError,
        
        }]"
          />    
          <p v-if="!!hasError" class="mx-2 text-red-500 text-sm my-2"> {{ hasError[0] }}</p>
        </div>
      </div>
</template>

<script>

    export default {
        props: {
            type: {
                type: String,
                default: 'text',
            },
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
                required: false
            }

        },    
    }
</script>

<style  scoped>

</style>