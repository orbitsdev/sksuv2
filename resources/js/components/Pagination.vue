<template>
  <div>
    <button v-if="page > 1" @click="changePage(page - 1)">Previous</button>
    <button
      v-for="pagenum in pages"
      @click="changePage(pagenum)"
      :key="pagenum"
      :class="{ active: pagenum === page }"
    >
      {{ pagenum }}
    </button>
    <button v-if="page < pages.length" @click="changePage(page + 1)">Next</button>
  </div>
</template>

<script>
export default {
  props: {
    page: {
      type: Number,
      required: true,
    },
    lastPage: {
      type: Number,
      required: true,
    },
  },
  computed: {
    pages() {
      return Array.from(Array(this.lastPage).keys()).map((i) => i + 1);
    },
  },
  methods: {
    changePage(page) {
      this.$emit("change-page", page);
    },
  },
};
</script>
