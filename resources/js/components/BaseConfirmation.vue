

<template>
    <div>
        <h1 class="text-md font-bold">{{ title }} <span class="text-green-700">
          {{ subject }}
        </span></h1>

        <div  class="bg-gray-100 text-xs italic p-1 my-1 rounded-sm" v-for="user in selectedData" :key="user.id">
          {{ user.first_name }} {{ user.last_name  }} -  <span v-if="user.schools != null && user.schools.length > 0    "> {{user.schools[0].name }}</span> <span v-else> Unknown  </span>
        </div>

        <slot name="data">
        </slot>
        <div class="flex my-2">
          <TableButton mode class="mr-2" @click="this.$emit('close')"> Close </TableButton>
          <div class="my-1  ml-1 " v-if="isSaving">
            <BaseSpinner />
          </div>
          <div v-else>
            <slot>
                  yest
            </slot>
            </div>
        </div>

      </div>
</template>

<script>
    export default {
        emits: ['close'],
        props: {
            title: {
                type: String,
                default: 'Are Your sure? '
            },
            subject: {
                type: String,
                default: 'subjet '
            },

            selectedData: {
                type: Array,
                default: [],
            },
            isSaving: {
                type: Boolean,
                default:false,
            }

        },
    }
</script>

<style lang="scss" scoped>

</style>