


<template>
    <div class="">
        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
          <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 "
          >
            <svg
              class="h-6 w-6 "
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
            class="block h-full w-full  py-2 border border-gray-300  rounded pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-gray-400 focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-base"
            placeholder="Search"
            type="search"
          />
        </div>
       
      </div>
</template>

<script>
    export default {

        props: {
          
            modelValue: {
                type: [String, Number],
                default: '',
                
            },
        },
    }
</script>

<style scoped>

</style>