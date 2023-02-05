<template>
  <div>
    <div class="flex">
      <div class="flex-2 px-6 py-5">
        <p
          tabindex="0"
          class="font-bold font-rubik focus:outline-none text-xl leading-none text-green-700"
        >
          {{ title }}
        </p>

        <slot> </slot>
      </div>
      <div class="px-3">
        <img tabindex="0" class="focus:outline-none w-24" :src="image" alt="medal" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      default: "SY.2023-2024",
      type: String,
    },
    image: {
      required: false,
      type: String,
      default: "/assets/undraw_hiring_re_yk5n.svg",
    },
  },
};
</script>

<style lang="scss" scoped></style>
