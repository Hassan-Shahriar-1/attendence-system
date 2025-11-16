<template>
  <div class="self-stretch bg-white justify-start items-center inline-flex w-full grow shrink basis-0 text-[#585754] text-xs leading-[18px] px-3 py-2 rounded-md hover:bg-[#E0E2E5] hover:text-[#41454E]">
    {{ (label) }}
</div>
</template>

<script setup>
  const props = defineProps({
    label: {
      type: String,
      required: true,
    },
  })
</script>

<style lang="scss" scoped>

</style>