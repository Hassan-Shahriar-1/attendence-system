<template>
    <OverviewTable
	:search_enabled="true"
      :footer_enabled="false"
      :paginationData="data?.meta"
      class="!border-t-0"
      bodyClass=""
      headerClass=""
      headerTopClass="!py-0 !border-t-0"
      placeholder="Search here..."
    >
      <template #filters>
    </template>
    <template #overview-top-left>
        </template>
        <template #overview-top-right>
        </template>
        <template #header>
            <tr>
            <th
                v-for="column in columns"
                :key="column.columnName"
                :class="column.class"
                class="text-left px-6 py-4 text-sm font-medium text-gray-900 bg-gray-50"
            >
                {{ column.label }}
            </th>
            </tr>
        </template>
      <template #body>
        <TableRow
          v-for="row in data?.data" :row="row"	:key="row.id"
        />
      </template>

	</OverviewTable>
</template>

<script setup>
import { ref, shallowRef, defineAsyncComponent, watch, reactive } from "vue";
import { useRoute } from "vue-router";
import OverviewTable from "@/Components/table/OverviewTable.vue";
import axios from "@/axios";
import TableRow from "./components/TableRow.vue";

const loading = ref(false);
const route = useRoute()

const columns = ref([
	{ label: "Student Id", columnName: "student_id", enableSort: false, class: "w-[20%]" },
	{ label: "Name", columnName: "name", enableSort: false, class: "w-[30%]" },
	{ label: "Grade", columnName: "grade", enableSort: false, class: "w-[25%]" },
	{ label: "Section", columnName: "section", enableSort: false, class: "w-[25%]" }
]); 

const queryParams = ref(route.query)

const {data} = await axios.get(`/students`, {
    pick: ['data', 'meta'],
    query: queryParams,
})

console.log('data',data.data);


watch(() => route.query, (newVal, oldValue) => {
    queryParams.value = newVal
})
</script>