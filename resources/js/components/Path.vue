<template>
<div>
{{ currentpath }}
</div>
</template>

<script>
export default {
  computed: {
    currentpath() {
      const pathstring = this.path;
        
      var str_array = pathstring.split('/');
      for (var i = 0; i < str_array.length; i++) {
        // Trim the excess whitespace.
        str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
        // Add additional code here, such as:
      }
      str_array.shift();
      let string  = str_array.join('->');
      return string;
    },
  },

  props: ["path"],
};
</script>

<style scoped></style>
