<template>
  <div
    class="entries-per-page"
    @click="opened = !opened"
    v-click-away="() => (opened = false)"
  >
    <div class="label">
      <div
        class="bg-white bg-transparent flex items-center px-4 py-1 rounded-[100px]"
      >
        {{ per_page }}
        <svg
          class="ml-1"
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M15 7.50004C15 7.50004 11.3176 12.5 10 12.5C8.68233 12.5 5 7.5 5 7.5"
            stroke="#8F8E8B"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </div>

      <span>Entries Per Page</span>
    </div>

    <div class="options" v-if="opened">
      <p
        class="option"
        :class="{ active: per_page == 10 }"
        @click="setPerPage(10)"
      >
        10
      </p>
      <p
        class="option"
        :class="{ active: per_page == 25 }"
        @click="setPerPage(25)"
      >
        25
      </p>
      <p
        class="option"
        :class="{ active: per_page == 50 }"
        @click="setPerPage(50)"
      >
        50
      </p>
      <p
        class="option"
        :class="{ active: per_page == 100 }"
        @click="setPerPage(100)"
      >
        100
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      opened: false,
      per_page: 25,
    };
  },
  methods: {
    setPerPage(item_count) {
      if (this.per_page == item_count) return;
      this.per_page = item_count;

      const query = { ...this.$route.query };
      delete query.page;
      query.per_page = item_count;

      this.$router.push({ query });

      this.$emit("updateResult");
    },
  },
  mounted() {
    this.per_page = this.$route.query.per_page ?? 10;
  },
};
</script>

<style lang="scss" scoped>
.entries-per-page {
  position: relative;

  .label {
    @apply text-sm font-normal text-[#5D5D5D] cursor-pointer flex items-center gap-[5px];

    span {
      // @apply ml-4;
    }
  }

  .options {
    position: absolute;
    background-color: white;
    width: 72px;
    // right: 0px;
    bottom: 0;
    z-index: 1;
    border: 1px solid #e2e8f0;
    border-radius: 5px;

    .option {
      @apply text-sm font-normal text-[#5D5D5D];
      padding: 10px 0px 7px 16px;
      border-bottom: 1px solid #e2e8f0;
      cursor: pointer;
      margin: 0px;
    }

    .option:last-of-type {
      border-bottom: none;
    }

    .option.active {
      background-color: #f6f6f7;
    }
  }
}

.entries-per-page .options .option {
  padding: 10px 0px 5px 20px;
}
</style>
