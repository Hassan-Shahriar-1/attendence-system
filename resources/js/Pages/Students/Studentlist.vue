<template>
	<div class="text-[#3d3d3d] text-[32px] font-medium font-title leading-[38.40px]">
		Student List
	</div>
	<OverviewTable
		:filterEnabled="false"
		:searchEnabled="true"
		:paginationData="meta"
		:loading="loading"
		:showSelectAll="false"
		headerTopClass=""
		headerClass=""
		bodyClass=""
		searchPlaceholder="Search by student & Grade name"
		@refetch="loadStudents()"
	>
		<template #filter>
			
		</template>
		

		<template #header>
			<div v-for="column in columns" :key="column.columnName" :class="column.class">
				<SortTableColumn
					:label="column.label"
					:columnName="column.columnName"
					:enableSort="column.enableSort"
				/>
			</div>
		</template>

		<template #body>
			<TableRow
				v-if="rows.length > 0"
				:students="rows"
			/>
			<template v-else>
				<tr class="justify-center items-center flex">
					<td
						colspan="5"
						class="text-center py-8 text-[#585755] text-sm font-normal"
					>
						No data found
					</td>
				</tr>
			</template>
		</template>
	</OverviewTable>
	
</template>

<script setup>
import { ref, shallowRef, watch, reactive, onMounted } from "vue";
import { useRoute } from "vue-router";
import OverviewTable from "@/Components/table/OverviewTable.vue";
import OverviewTableFilter from "@/Components/table/OverviewTableFilter.vue";
import SortTableColumn from "@/Components/table/SortTableColumn.vue";


import axios from "@/axios";
import TableRow from "./components/TableRow.vue";

const loading = ref(false);
const rows = ref([]);       // holds student list
const route = useRoute();
const meta = ref({});       // holds pagination meta data

const columns = ref([
    { label: "Student Id", columnName: "student_id", enableSort: false, class: "w-[20%]" },
    { label: "Name", columnName: "name", enableSort: false, class: "w-[30%]" },
    { label: "Grade", columnName: "grade", enableSort: false, class: "w-[25%]" },
    { label: "Section", columnName: "section", enableSort: false, class: "w-[25%]" },
]);

const queryParams = ref(route.query);

const loadStudents = async () => {
    loading.value = true;

    try {
        const response = await axios.get("/students", {
            params: queryParams.value,
        });

        rows.value = response.data.data;   // assign rows
        meta.value = response.data.meta;   // assign meta
        console.log("students:", rows.value);
    } catch (error) {
        console.error("error loading students", error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadStudents();
});

watch(
  () => route.query,
  (newVal) => {
    queryParams.value = newVal;
    loadStudents();
  }
);
</script>
