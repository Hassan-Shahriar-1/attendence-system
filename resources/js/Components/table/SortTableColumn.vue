<template>
  <div class="sort flex items-center pl-2">
    {{ label != ''? label : '' }}
    <span v-if="enable" @click="sort">
    </span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: [String, Object],
      required: true,
    },
    columnName: {
      type: String,
      required: true,
    },
    enable: {
      type: Boolean,
      default: true,
    },
    tooltip: {
      type: Boolean,
      default: false,
    },
    tooltipText: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      direction: null,
    };
  },
  created() {
    const order_by = this.$route.query.order_by;
    const direction = this.$route.query.direction;
    if (this.columnName == order_by) this.direction = direction;
  },
  watch: {
    direction(newValue, oldValue) {
      const queries = this.$route.query;
      delete queries.page;
      const routeObj = {
        params: { ...this.$route.params },
        query: {
          ...queries,
          order_by: this.columnName,
          direction: this.direction,
        },
      };

      this.$router.push(routeObj);
    },
  },
  methods: {
    sort() {
      if (!this.enable) return;

      const direction = this.direction ? this.direction : "DESC";
      this.direction = direction.toUpperCase() == "ASC" ? "DESC" : "ASC";
    },
  },
};
</script>

<style lang="scss" scoped>
.sort {
  @apply px-6 py-3;

	color: var(--Greyscale900, #151619);
	font-family: Manrope;
	font-size: 14px;
	font-style: normal;
	font-weight: 800;
	line-height: 16px; /* 114.286% */
  svg {
    margin-left: 5px;
    cursor: pointer;
  }
}
</style>
