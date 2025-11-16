<template>
  <div class="overview__table" >
      <div
          class="overview__table--tabs flex items-center mb-5 gap-x-3 flex-wrap lg:flex-nowrap"
          :class="[$attrs.tabClass]"
          v-if="$slots.tabs"
      >
        <slot name="tabs">Tabs</slot>
      </div>
    <div
      class="overview__table--header__top flex items-center mb-5 gap-x-3 flex-wrap lg:flex-nowrap"
      :class="[$attrs.headerTopClass]"
      v-if="headerTop"
    >
      <slot name="header-top">
        <div class="overview__top--left">
          <slot name="overview-top-left"></slot>
        </div>
        <div class="overview__top--right ml-auto">
          <slot name="overview-top-right"> </slot>
        </div>
      </slot>
    </div>
    <div
      class="overview__table--header__search__filter flex items-center justify-between mb-5 gap-x-3"
      :class="[$attrs.headerTopClass]"
      v-if="headerTop"
    >

      <div class="overview__top--search w-full lg:w-[450px] xl:w-[450px] my-5 lg:my-0" v-if="search_enabled">
        <slot name="overview-search">
          <TableOverviewTableSearch :placeholder="placeholder" />
        </slot>
      </div>
      <div class="filter mr-3" v-if="$slots.filters">
        <slot name="filters" />
      </div>
    </div>
    <div class="full-width-table-container">
      <div class="full-width-table">
        <div class="flex flex-col w-full header-body-wrapper">
          <div class="flex overview__table--header" :class="[$attrs.headerClass]" ref="header">
            <slot name="header" />
          </div>
          <div class="overview__table--body" :class="[$attrs.bodyClass]" ref="overview__table__body">
            <slot name="body"  v-if="paginationData?.total > 0"  />
            <NoResoultFound v-if="paginationData?.total == 0" />
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-between overview__table--footer flex-wrap xl:flex-nowrap mt-2.5 xl:mt-0" v-if="paginationData?.total > 0">
      <div class="min-w-fit">
        <EntriesPerPage />
      </div>
      <PaginationView :pagination="paginationData" :limit="4" />
    </div>
  </div>
</template>

<script>
import EntriesPerPage from "./EntriesPerPage.vue";
import PaginationView from "./Pagination.vue";
// import OverviewTableSearch from "./OverviewTableSearch.vue";
import NoResoultFound from './NoResultFound.vue'

export default {
  components: { PaginationView, EntriesPerPage, NoResoultFound },
  props: {
    paginationData: {
      type: Object,
      required: true,
    },
    headerTop: {
      type: Boolean,
      default: true,
    },
    filter: {
      type: Boolean,
      default: true,
    },
    search_enabled: {
      type: Boolean,
      default: true,
    },
    placeholder: {
      type: String,
      default: "Search...",
    },
  },
  data() {
    return {
      openPerPageDropdown: false,
      per_page: null,
    };
  },
  created() {
    const per_page = this.$route.query.per_page;
    this.per_page = per_page ?? 25;
  },

  methods: {
    setPerPage(perPage) {
      this.openPerPageDropdown = false;
      this.per_page = perPage;

      const queries = this.$route.query;

      delete queries.page;
      this.$router.push({ query: { ...queries, per_page: perPage } });
    },
  },
};
</script>

<style lang="scss">

.overview__table {
  @apply bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-[#e0e2e5] p-[24px] my-[20px];
}

.full-width-table-container {
  width: 100%;
  overflow-x: auto;
  border-top-right-radius: 16px;
  border-top-left-radius: 16px;

  scrollbar-color: #4e54c8 #e2e8f7;
  scrollbar-width: 5px;

  &::-webkit-scrollbar {
    width: 3px !important;
    height: 6px !important;
  }

  &::-webkit-scrollbar-track {
    background: #e2e8f7;
  }

  &::-webkit-scrollbar-thumb {
    border-radius: 3px;
    background: var(
      --Gradients-1,
      linear-gradient(0deg, #4e54c8 18.39%, rgba(23, 160, 178, 0.93) 109.89%)
    ) !important;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: var(
      --Gradients-1,
      linear-gradient(0deg, #4e54c8 18.39%, rgba(23, 160, 178, 0.93) 109.89%)
    ) !important;
  }
}

.full-width-table {

}


.overview__table--header {
  background: #F1F2F3;
  width: 100%;
  height: 60px;
  border-top-right-radius: 16px;
  border-top-left-radius: 16px;
}
.overview__table--header__top {
  @apply w-full  border-b-[1px] border-[#e5e0e0] !pb-4;
}

.overview__table--header__search__filter {

}
.overview__table--filter {
  @apply w-full justify-between bg-[#E9F7FE] px-4 pb-3;
}

.overview__table--footer {
  @apply px-0 py-6 pb-0 pl-0;
}

.overview__table--body {
  border: 1px solid #E0E2E5;
  border-top: 0px;
  min-height:400px;
}

.overview__table--body .tr {
  @apply flex bg-white;
  margin: 0 auto;

  &:hover {
    //
  }
}

.td {
  @apply break-words border-b border-[#E0E2E5] font-normal text-sm text-[#565C67] px-6 py-3;
}

.td-link {
  @apply text-[#11577B];
}

.table__menubar {
  @apply relative flex justify-end;
}
.table__menubar .bar-icon {
  @apply cursor-pointer;
}

.table__menubar__dropdown {
  @apply absolute list-none bg-white min-w-[140px]   top-0 right-0 z-[99];
}

.table__menubar__dropdown li {
  color: var(--Tints-5, #135f84);
  font-family: Nexa;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: 20px;
  border-bottom: 1px solid #fef1e7;
  &:hover {
    background: #bee7fb;
  }
  &:last-child {
    border: none;
  }
}

.table__menubar__dropdown a {
  @apply block hover:cursor-pointer;
  padding: 8px 16px;
}

.pagination {
  width: 100%;
}
</style>


