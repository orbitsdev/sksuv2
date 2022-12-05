<template>
  <div class="bh ">
    <BaseCard class="p-4">
      compistion Api
      <hr>
      {{ data }}
      <hr>
        FULL NAME:      {{ fullname }}
      <hr>      
        <input type="text" placeholder="firstname"  @input="setFirstName"/>
      <hr>          
      <hr>      
        <input type="text" placeholder="last name"  @input="setLastName"/>
      <hr>          
        Description:  {{ description }}
      <hr>      
        <input type="text" placeholder="description"  @input="setDescriptionValue"/>
      <hr>      
      <TableButton @click="changeArray"> Click Me</TableButton>
      <hr>
      <h1> {{ age }}</h1>
      <TableButton @click="increaseAge"> Add Age</TableButton>
      <hr>
    </BaseCard>
  </div>
</template>

<script>
import { ref , computed , watch, onMounted} from "vue";
export default {
  setup() {
    const data = ref(["vue", "laravel"]);
    const first_name = ref('');
    const last_name = ref('');
    const description = ref('');
    const age= ref(18);

    const fullname = computed(function(){
        return first_name.value +' ' + last_name.value ; 
    })
    onMounted(function(){
        console.log('mounted');
    });
    watch(age, function(oldValue, newValue){
            console.log(oldValue,newValue); 
    })

    function increaseAge(){
        age.value++;
    }

    function changeArray(){
        data.value = ['flutter', 'firebase']
    }

    function setFirstName(event){
        first_name.value = event.target.value;
    }
    function setLastName(event){
        last_name.value = event.target.value;
    }

    function setDescriptionValue(event){
        description.value = event.target.value
    }


    return {
      data,
      fullname,
      changeArray,
      description,
      setDescriptionValue,
      first_name,
      last_name,
      setFirstName,
      setLastName,
      age,
      increaseAge


    };
  },
};
</script>

<style scoped>
.bh {
    padding: 80px 120px;
    height: 100vh;
    background: #f2f2f2;
  }
</style>