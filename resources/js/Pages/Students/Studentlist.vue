<template>
    <TableOverviewTableScroll
	:search_enabled="true"
      :footer_enabled="false"
      :paginationData="meta"
      class="!border-t-0 "
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
        <TableSortColumn
            v-for="column in columns"
            :key="column.columnName"
            :label="column.label"
            :column-name="column.columnName"
            :enable="column.enableSort"
            :class="column.class"   
            />           
        </template>
      <template #body>
        <TableRow
            v-for="student in rows"
            :key="student.id"
            :student="student"
        />
       
      </template>

	</TableOverviewTableScroll>
</template>

<script setup>
import { ref, shallowRef, watch, reactive, onMounted } from "vue";
import { useRoute } from "vue-router";
import OverviewTable from "../../Components/table/OverviewTable.vue";
import TableOverviewTableScroll from "../../Components/table/OverviewTableScroll.vue";

import TableSortColumn from "../../Components/table/SortTableColumn.vue";

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
